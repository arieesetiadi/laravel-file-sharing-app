<?php

namespace App\Models;

use App\Constants\GeneralStatus;
use App\Constants\UserRoleCode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasFactory, HasApiTokens, HasUuids;

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * Allowed field for mass assignment.
     */
    protected $fillable = ['username', 'name', 'email', 'phone', 'password', 'status', 'user_role_id'];

    /**
     * Hidden field while get data.
     */
    protected $hidden = ['password'];

    /**
     * New field for the result.
     */
    protected $append = ['avatar_path', 'is_admin', 'is_general', 'received_files'];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * User's role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }

    /**
     * All sender's shares.
     */
    public function sentShares(): HasMany
    {
        return $this->hasMany(Share::class, 'sender_user_id');
    }

    /**
     * All general user's received shares.
     */
    public function receivedShares(): BelongsToMany
    {
        return $this->belongsToMany(Share::class)->latest();
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get user avatar image path | src.
     */
    public function getAvatarPathAttribute(): string
    {
        return asset('assets/cms/images/profiles/default.png');
    }

    /**
     * Get is admin value.
     */
    public function getIsAdminAttribute(): bool
    {
        return $this->role->code == UserRoleCode::ADMIN;
    }

    /**
     * Get is general value.
     */
    public function getIsGeneralAttribute(): bool
    {
        return $this->role->code == UserRoleCode::GENERAL;
    }

    /**
     * Get all general users received filed
     */
    public function getReceivedFilesAttribute(): Collection
    {
        return $this->receivedShares->flatMap(function ($share) {
            return $share->files;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Mutators
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Filter the user with role Admin.
     */
    public function scopeAdmin(Builder $query): Builder
    {
        return $query->whereHas('role', function ($query) {
            return $query->where('code', UserRoleCode::ADMIN);
        });
    }

    /**
     * Filter the user with role General.
     */
    public function scopeGeneral(Builder $query): Builder
    {
        return $query->whereHas('role', function ($query) {
            return $query->where('code', UserRoleCode::GENERAL);
        });
    }

    /**
     * Filter the active user.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', GeneralStatus::ACTIVE);
    }

    /**
     * Filter the inactive user.
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('status', GeneralStatus::INACTIVE);
    }
}
