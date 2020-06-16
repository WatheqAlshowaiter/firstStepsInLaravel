<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OneToManyPost extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body'
    ];
}
