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

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

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
}
