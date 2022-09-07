<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Managements extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->hasManyThrough(
            'App\User',
            'App\Jobs',
            'management_id', // Local key on users table...
            'title', // Local key on users table...
        );
    }

    public function jobs()
    {
        return $this->hasMany(Jobs::class,'management_id');
    }

 
 
}

