<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpensesTypes extends Model
{
    //
    protected $guarded = [];


    public function expenses()
    {
        return $this->hasMany(Expenses::class,'type');
    }
    

    public function getSumExpenses($type)
    {
       return $this->expenses()->where('type',$type)->sum('Expense');
    }

    
}
  