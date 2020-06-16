<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    //
    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('created_at');
    }
}
