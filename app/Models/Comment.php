<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'post_id', 'body'];

    protected static function boot()
    {
        parent::boot();

        // When a comment is created
        static::created(function ($comment) {
            CommentAuditLog::create([
                'comment_id' => $comment->id,
                'updated_by' => auth()->id() ?? 1, // if no auth()->id() set to 1
                'action' => 'created',
                'changes' => json_encode(['all' => $comment->toArray()]),
            ]);
        });

        // When a comment is updated
        static::updated(function ($comment) {
            CommentAuditLog::create([
                'comment_id' => $comment->id,
                'updated_by' => auth()->id() ?? 1, // if no auth()->id() set to 1
                'action' => 'updated',
                'changes' => json_encode($comment->getChanges()),
            ]);
        });

        // When a comment is deleted, disabled due to constraint when deleting models in CommentAuditLog
        // static::deleted(function ($comment) {
        //     CommentAuditLog::create([
        //         'comment_id' => $comment->id,
        //         'updated_by' => auth()->id() ?? 1, // if no auth()->id() set to 1
        //         'action' => 'deleted',
        //         'changes' => json_encode(['deleted' => true]),
        //     ]);
        // });

    }

    /**
     * Get the user that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); //$user = $comment->user;
    }

    /**
     * Get the post that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class); //$post = $comment->post;
    }

    /**
     * Get all of the auditLogs for the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(CommentAuditLog::class, 'comment_id');
    }

    // Get the last user who updated this comment
    public function getLastUpdaterAttribute()
    {
        $log = $this->auditLogs()->latest()->first();
        return $log ? $log : null;
    }
}
