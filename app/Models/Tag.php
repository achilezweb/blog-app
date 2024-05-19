<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    protected static function boot()
    {
        parent::boot();

        // When a category is created
        static::created(function ($tag) {
            TagAuditLog::create([
                'tag_id' => $tag->id,
                'updated_by' => auth()->id() ?? 1, // if no auth()->id() set to 1
                'action' => 'created',
                'changes' => json_encode(['all' => $tag->toArray()]),
            ]);
        });

        // When a category is updated
        static::updated(function ($tag) {
            TagAuditLog::create([
                'tag_id' => $tag->id,
                'updated_by' => auth()->id() ?? 1, // if no auth()->id() set to 1
                'action' => 'updated',
                'changes' => json_encode($tag->getChanges()),
            ]);
        });

        // When a category is deleted, disabled due to constraint when deleting models in CategoryAuditLog
        // static::deleted(function ($tag) {
        //     TagAuditLog::create([
        //         'tag_id' => $tag->id,
        //         'updated_by' => auth()->id() ?? 1, // if no auth()->id() set to 1
        //         'action' => 'deleted',
        //         'changes' => json_encode(['deleted' => true]),
        //     ]);
        // });

    }

    /**
     * The posts that belong to the Tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts(): BelongsToMany
    {
        // return $this->belongsToMany(Post::class)->using(TagPost::class);
        return $this->belongsToMany(Post::class, 'tag_post');
    }

    /**
     * Get all of the auditLogs for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(TagAuditLog::class, 'tag_id');
    }

    // Get the last user who updated this category
    public function getLastUpdaterAttribute()
    {
        $log = $this->auditLogs()->latest()->first();
        return $log ? $log : null;
    }

}
