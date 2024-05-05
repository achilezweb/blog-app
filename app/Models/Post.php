<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'category_id',
        'tag_id',
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

    // /**
    //  * Get all of the categories for the Post
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function categories(): HasMany
    // {
    //     return $this->hasMany(Category::class); //$categories = $post->categories; //there should be post_id in categories
    // }

    /**
     * Get the category that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all of the tags for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class); //$tags = $post->tags;
    }

    /**
     * Get all of the privacies for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function privacies(): HasMany
    {
        return $this->hasMany(Privacy::class); //$privacies = $post->privacies;
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
