<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $guarded = [];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

}
