<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OneToOneUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * One to One Relationship with Address
     */
    public function address(){
        return $this->hasOne('App\OneToOnAddress','user_id');
    }
}
