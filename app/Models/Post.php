<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

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
        return $this->belongsToMany(Tag::class);
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




}
