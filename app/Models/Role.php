<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pivot\RoleUser;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The users that belong to the role.
     */
    public function users()
    {
        // return $this->belongsToMany(User::class)->withTimestamps();
        return $this->belongsToMany(User::class)->using(RoleUser::class);
    }

    // Local scope to query roles by name
    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

}
