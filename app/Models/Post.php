<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Pivot\TagPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'slug',
        'active',
        'archive',
        'privacy_id',
    ];

    // protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        // Automatically generate slug before saving the post
        static::creating(function ($post) {
            $baseSlug = Str::slug($post->title);
            $slug = $baseSlug;
            $count = 1;

            // Check if the generated username already exists
            while (static::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }

            $post->slug = $slug;
        });

        // When a post is created
        static::created(function ($post) {
            PostAuditLog::create([
                'post_id' => $post->id,
                'updated_by' => auth()->id() ?? 1, // if no auth()->id() set to 1
                'action' => 'created',
                'changes' => json_encode(['all' => $post->toArray()]),
            ]);
        });

        // When a post is updated
        static::updated(function ($post) {
            PostAuditLog::create([
                'post_id' => $post->id,
                'updated_by' => auth()->id() ?? 1, // if no auth()->id() set to 1
                'action' => 'updated',
                'changes' => json_encode($post->getChanges()),
            ]);
        });

        // When a post is deleted, disabled due to constraint when deleting models in PostAuditLog
        // static::deleted(function ($post) {
        //     PostAuditLog::create([
        //         'post_id' => $post->id,
        //         'updated_by' => auth()->id() ?? 1, // if no auth()->id() set to 1
        //         'action' => 'deleted',
        //         'changes' => json_encode(['deleted' => true]),
        //     ]);
        // });
    }

    /**
     * Get the user that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); //$user = $post->user;
    }

    /**
     * Get all of the comments for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class); //$comments = $post->comments;
    }

    /**
     * The categories that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * The tags that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        // return $this->belongsToMany(Tag::class)->using(TagPost::class);
        return $this->belongsToMany(Tag::class, 'tag_post'); //customized as it should be post_tag as default
    }

    /**
     * Get the privacy that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function privacy(): BelongsTo
    {
        return $this->belongsTo(Privacy::class);
    }

    /**
     * The likes that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes (): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_user_likes');
    }

    public function likeCount()
    {
        return $this->likes()->count();
    }

    /**
     * The shares that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shares(): BelongsToMany
    {
        // return $this->hasMany(PostShare::class);
        return $this->belongsToMany(User::class, 'post_user_shares');
    }

    public function shareCount()
    {
        return $this->shares()->count();
    }

    /**
     * Always set the body field to convert text - html markdown
     *
     * @return string
     */
    public function html(): Attribute
    {

        // return Attribute::get(fn () => str($this->body)->markdown()); //or
        return new Attribute(
            get: fn () => str($this->body)->markdown(),
            // set: fn ($value) => $value,
        ); //$html = $post->html;
    }

    /**
     * Get all of the auditLogs for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(PostAuditLog::class, 'post_id');
    }

    // Get the last user who updated this post
    public function getLastUpdaterAttribute()
    {
        $log = $this->auditLogs()->latest()->first();
        return $log ? $log : null;
    }


}
