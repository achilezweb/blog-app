<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Pivot\RoleUser;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'username',
        'active',
        'archive',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        // Automatically generate username before saving the user
        static::creating(function ($user) {
            $baseUsername = Str::slug($user->name);
            $username = $baseUsername;
            $count = 1;

            // Check if the generated username already exists
            while (static::where('username', $username)->exists()) {
                $username = $baseUsername . '-' . $count;
                $count++;
            }

            $user->username = $username;
        });

        // Handle QR code generation on creation
        static::created(function ($user) {
            $user->generateAndSaveQrCode();
            $user->generateBarcode();
        });

        // Handle QR code regeneration on updates
        static::updated(function ($user) {
            // Optionally, check if specific attributes have changed if needed
            if ($user->isDirty('email')) { // Assuming email changes affect the QR code
                // $user->generateAndSaveQrCode(); // mo laag
            }
        });

    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchived($query)
    {
        return $query->where('archive', true);
    }

    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        // return $this->belongsToMany(Role::class)->withTimestamps();
        return $this->belongsToMany(Role::class)->using(RoleUser::class);
    }

    /**
     * Check if the user has a role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRoles($role)
    {
        return $this->roles()->where('name', $role)->exists();
        //return (bool) $this->roles()->where('name', $role)->first();
    }

    /**
     * Check if the user has any of the specified roles.
     *
     * @param array|string $roles
     * @return bool
     */
    public function hasAnyRole(array $roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Assign a role to the user.
     *
     * @param string $role
     * @return void
     */
    public function assignRole($role)
    {
        $this->roles()->syncWithoutDetaching(Role::where('name', $role)->first());
    }

    /**
     * Generate a QR code that represents the User's unique identifier or any other relevant data.
     *
     * @return string
     */
    public function getQrCodeAttribute()
    {
        $data = $this->email;  // Or any other data you wish to encode
        return QrCode::size(200)->generate($data); //called from blade {{ $user->qrCode }}
    }

    /**
     * Generate and save a QR code image that represents the User's unique identifier or any other relevant data.
     * Called from static::created $user->generateAndSaveQrCode();
     */
    public function generateAndSaveQrCode()
    {
        $data = $this->email;  // Or any other data you wish to encode
        $qrCodePath = 'qrcodes/users/' . $this->id . '.svg';

        $qrCode = QrCode::format('svg')->size(100)->generate($data);

        // Save the QR code to the storage
        Storage::disk('public')->put($qrCodePath, $qrCode);

        // Update the user's QR code path attribute if necessary
        $this->qrcodes = $qrCodePath;
        $this->save();

        return $qrCodePath;
    }

    public function generateBarcode()
    {
        $barcode = new DNS1D();
        $this->barcode = $barcode->getBarcodePNG($this->id, "C39");
        $this->save();
    }

    /**
     * // Usage: Assigning a role to a user
     * $user = User::find(1);
     * $user->assignRole('admin');
     *
     * // Checking if a user has a role
     * if ($user->hasRole('admin')) {
     * // User has the 'admin' role
     * }
     *
     * $user = User::find(1); //assigning role to users
     * $role = Role::find(1);
     * $user->roles()->attach($role);
     *
     * $user = User::find(1); //retrieve role for a user
     * $roles = $user->roles;
     *
     * $role = Role::find(1); //retrieve users for a role
     * $users = $role->users;
     *
     * $user->roles()->sync([1, 2, 3]); //sync the role for a user
     *
     * $user->roles()->detach($role); // remove a role from a user
     */

    /**
     * Get all of the posts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class); //$posts = $user->posts;
    }

    /**
     * The taggedInPosts that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function taggedInPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * The likedPosts that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_user_likes');
    }

    /**
     * The sharedPosts that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sharedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_user_shares');
    }

    public function friendRequestsReceived()
    {
        return $this->hasMany(FriendRequest::class, 'friend_id');
    }

    public function friendRequestsSent()
    {
        return $this->hasMany(FriendRequest::class, 'user_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friend_requests', 'user_id', 'friend_id');
    }

    public function addFriend(User $user)
    {
        $this->friends()->attach($user->id);
    }

    /**
     * Get all of the chatgpts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chatgpts(): HasMany
    {
        return $this->hasMany(Chatgpt::class); //$chatgpts = $user->chatgpts;
    }

    /**
     * Get all of the channels for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class); //$channels = $user->channels;
    }

}
