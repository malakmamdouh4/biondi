<?php
namespace App\Http\Traits;
trait AuthorizeTrait {
    public function can($ability) {
        if (auth()->user()->role == 1 || auth()->user()->hisRole->hasPermission($ability) == 1) {
            return true;
        }
        return false;
    }
}