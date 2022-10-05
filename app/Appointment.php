<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded = [];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class,'reservation_id');
    }

    public function client()
    {
        return $this->belongsTo(Clients::class,'client_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class,'area_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id');
    }
   
    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot(['id']);
    }

    public function checkForServApp($service_id)
    {
        return $this->services()->where('services.id',$service_id)->first();
    }
}
 