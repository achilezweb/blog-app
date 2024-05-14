<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        // When a category is created
        static::created(function ($category) {
            CategoryAuditLog::create([
                'category_id' => $category->id,
                'updated_by' => auth()->id() ?? 1, // if no auth()->id() set to 1
                'action' => 'created',
                'changes' => json_encode(['all' => $category->toArray()]),
            ]);
        });

        // When a category is updated
        static::updated(function ($category) {
            CategoryAuditLog::create([
                'category_id' => $category->id,
                'updated_by' => auth()->id() ?? 1, // if no auth()->id() set to 1
                'action' => 'updated',
                'changes' => json_encode($category->getChanges()),
            ]);
        });

        // When a category is deleted, disabled due to constraint when deleting models in CategoryAuditLog
        // static::deleted(function ($category) {
        //     CategoryAuditLog::create([
        //         'category_id' => $category->id,
        //         'updated_by' => auth()->id() ?? 1, // if no auth()->id() set to 1
        //         'action' => 'deleted',
        //         'changes' => json_encode(['deleted' => true]),
        //     ]);
        // });

    }

    /**
     * The posts that belong to the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Get all of the auditLogs for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(CategoryAuditLog::class, 'category_id');
    }

    // Get the last user who updated this category
    public function getLastUpdaterAttribute()
    {
        $log = $this->auditLogs()->latest()->first();
        return $log ? $log : null;
    }

}
