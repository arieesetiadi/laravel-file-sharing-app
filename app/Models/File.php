<?php

namespace App\Models;

use App\Constants\GeneralStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory, HasUuids;

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * Allowed field for mass assignment.
     */
    protected $fillable = ['name', 'url', 'sender_user_id'];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * File's sender.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

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
