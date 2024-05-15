<?php

namespace App\Models\Pivot;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RoleUser extends Pivot
{
    use HasFactory;

    protected $table = 'role_user';

    /**
     * The roles that belong to the RoleUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    // not recommended
    // public function roles(): BelongsToMany
    // {
    //     return $this->belongsToMany(Role::class)->using(RoleUser::class);
    // }

}
