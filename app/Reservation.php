<?php

namespace App; 

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{ 
    protected $guarded = [];
 
    public function services()
    {
        return $this->belongsToMany(Service::class)->withPivot(['id','client_id']);
    }
    public function doctor()
    {
        return $this->belongsTo(User::class,'doctor_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function client()
    {
        return $this->belongsTo(Clients::class,'client_id');
    } 
    public function offer()
    {
        return $this->belongsTo(Offer::class,'offer_id');
    }
    public function checkForService($service_id)
    {
        return $this->services()->where('services.id',$service_id)->first();
    }
 
    public function sentPulses()
    {
        return $this->hasMany(TransformationPulses::class,'reservationSender_id');
    }
    public function receivedPulses() 
    {
        return $this->hasMany(TransformationPulses::class,'reservationReceiver_id');
    }


    public function sentPayment()
    {
        return $this->hasMany(TransformationPayment::class,'reservationSender_id');
    }
    public function receivedPayment() 
    {
        return $this->hasMany(TransformationPayment::class,'reservationReceiver_id');
    }


    public function payments()
    {
        return $this->hasMany(Revenues::class,'reservation_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class,'reservation_id');
    }
    public function totals()
    { 
        return [  
 
            'total' => $this->services()->sum('price'),
            'discount' => 0 ,
            'paid' => $this->payments()->sum('amount') ,
            'net' => $this->services()->sum('price') -  $this->payments()->sum('amount') ,
 
            'totalPulses' => $this->services()->sum('pulses') + $this->receivedPulses()->sum('pulses'),
            'usedPulses' => $this->appointments()->sum('pulses') + $this->sentPulses()->sum('pulses'),
            'net_pulses' => ($this->services()->sum('pulses') + $this->receivedPulses()->sum('pulses')) -
                            ($this->appointments()->sum('pulses') + $this->sentPulses()->sum('pulses')),

            'totalPayment' => $this->services()->sum('price') + $this->receivedPayment()->sum('payment'),
            'net_Payment' => ($this->services()->sum('price') + $this->receivedPayment()->sum('payment')) -
                            ($this->payments()->sum('amount') + $this->sentPayment()->sum('payment')),

 
        ];
    }
 

}
 