<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Channel extends Model
{   
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
    ];

    /**
     * Get the user that owns the Channel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); //$user = $channel->user;
    }

    /**
     * Get all of the chatgpts for the Channel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chatgpts(): HasMany
    {
        return $this->hasMany(Chatgpt::class); //$chatgpts = $channel->chatgpts;
    }

}
