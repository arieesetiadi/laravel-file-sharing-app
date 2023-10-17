<?php

namespace App\Models;

use App\Constants\GeneralStatus;
use App\Constants\UserRoleCode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
    protected $append = ['avatar_path'];

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
     * Filter the user with role Customer.
     */
    public function scopeCustomer(Builder $query): Builder
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
