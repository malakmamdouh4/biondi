<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntriesOperations extends Model
{
    //
    public function Entries()
    {
        return $this->hasMany(DailyEntries::class)->orderBy('id','asc');
    }
}
