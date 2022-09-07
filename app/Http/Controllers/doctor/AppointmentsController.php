<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reservation;
use App\Appointment;
use App\Service;
use Illuminate\Support\Facades\Response;

 
   
class AppointmentsController extends Controller
{
   

    public function update(Request $request, $id)
    {
        
        $data = $request->except(['_token','services']);

        $appointment = Appointment::find($id);
        $update = Appointment::find($id)->update($data);
        $reservation = Reservation::find($appointment->reservation_id);


        if($request->services != '')
        {
            if ( count($request->services) > 0) {
                for ($i=0; $i<count($request->services);$i++) {
                    if ($request['services'][$i] != '') {
                        $service = Service::find($request['services'][$i]);
                        $appointment->services()->syncWithoutDetaching($service);
                        $reservation->services()->syncWithoutDetaching($service);
                    }
                }
            } 
        }
 
 
        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
        
    }

    public function updateStatus(Request $request, $id)
    {
        $data = $request->except(['_token','servicesId','servicesPrice']);

        $appointment = Appointment::find($id);
        if($appointment->status == 'withDoctor')
        {
            $appointment->status = 'completedSession' ;
            $appointment->save();
        }
          
 
        if ($appointment) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
        
    }

    
}
