<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Share extends Model
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
    protected $fillable = ['sender_user_id', 'title', 'description'];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * The share's sender.
     */
    public function sendingUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    /**
     * The share's target users.
     */
    public function receivingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * All files in one share.
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'share_id')->orderBy('extension');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get formatted created at.
     */
    public function getCreatedAtAttribute($createdAt)
    {
        return human_datetime_diff($createdAt);
    }

    /**
     * Get formatted updated at.
     */
    public function getUpdatedAtAttribute($updatedAt)
    {
        return human_datetime_diff($updatedAt);
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
}
