<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TagPost extends Pivot
{
    use HasFactory;

    // protected $table = 'tag_post'; //no need coz belongsToMany table param already set
    // public $timestamps = true; //not recommended for pivot

    /**
     * Not really needed. The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'post_id',
    //     'tag_id',
    //     'status',
    //     'role',
    // ];

    // Define accessor or mutator if needed
    // public function getStatusAttribute($value)
    // {
    //     return ucfirst($value);
    // }

}
