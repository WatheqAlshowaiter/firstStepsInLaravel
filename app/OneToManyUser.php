<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OneToManyUser extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function posts()
    {
        return $this->hasMany('App\OneToManyPost','user_id');
    }
}
