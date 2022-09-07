<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    protected $guarded = [];

 

    public function user()
    {
        return $this->hasMany(User::class,'title');
    }

    public function management()
    {
        return $this->belongsTo(Managements::class,'management_id');
    }


    public function users()
    {
        return $this->hasManyThrough(
            'App\User',
            'App\jobs',
            'management_id', // Local key on users table...
            'title', // Local key on users table...
        );
    }
}
