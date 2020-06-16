<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TinkerPost extends Model
{
    // to be able to mass assigning
    protected $fillable = ['title', 'body'];
}
