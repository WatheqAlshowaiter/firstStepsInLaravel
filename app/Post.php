<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    protected $fillable = ['title', 'content'];

    use SoftDeletes;

    protected $dates = ['deleted_at'];


    public function user(){
        return $this->belongsTo('App\User');
    }

    public function imageable(){
        return $this->morphToMany('App\Photo','imageable');
    }

    public function tags(){
        return $this->morphToMany('App\Tag','taggable');
    }

}
