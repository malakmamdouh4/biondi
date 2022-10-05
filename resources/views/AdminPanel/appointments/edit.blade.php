<div class="modal fade text-md-start" id="editappointment{{$appointment->id}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                   
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>  
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">{{trans('common.edit')}}: {{trans('common.appointment')}} </h1>
                    </div>
                    {{Form::open(['url'=>route('admin.appointments.update',[$appointment->id,$appointment->reservation_id]), 'id'=>'editappointmentForm'.$appointment->id, 'class'=>'row gy-1 pt-75 justify-content-center'])}}
                             
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="employee_id">{{trans('common.employees')}}</label>
                        {{Form::select('employee_id',employeesList(),$appointment->employee_id,['id'=>'employee_id','class'=>'form-select selectpicker','data-live-search'=>'true'])}}
                    </div> 

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="day">{{trans('common.date')}}</label>
                        {{Form::date('date',$appointment->date,['id'=>'day', 'class'=>'form-control','onchange'=>'getAvailableTimes(this.value)'])}}
                    </div> 

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="pulses">{{trans('common.pulses')}}</label>
                        {{Form::text('pulses',$appointment->pulses,['id'=>'pulses', 'class'=>'form-control'])}}
                    </div>


                    <div class="col-12 col-md-4 servicesShow">
                    <label class="form-label" for="day">{{trans('common.services')}}</label>
                        @foreach(servicesList() as $service)
                            <div class="form-check me-3 me-lg-1">
                                <label class="form-check-label" for="service{{$service->id}}{{$appointment->id}}">
                                    {{$service->name}}
                                </label>
                                <input class="form-check-input" type="checkbox" id="service{{$service->id}}{{$appointment->id}}" name="services[]" value="{{$service->id}}" @if($appointment->checkForServApp($service->id) != '') disabled @endif />
                            </div>
                        @endforeach
                    </div> 

                    <div class="col-12 col-sm-4">
                        <label class="form-label" for="area_id">{{trans('common.area')}}</label>
                        {{Form::select('area_id',['0'=>'بدون تحديد'] + areasList(),$appointment->area_id,['id'=>'area_id','class'=>'form-select','required'])}}
                    </div>  

                    <div class="col-12">
                        <label class="form-label" for="time">{{trans('common.time')}}</label>
                        <div class="row hoursRadios"></div>
                    </div>

 
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="body">{{trans('common.body')}}</label>
                        {{Form::text('body',$appointment->body,['id'=>'body', 'class'=>'form-control'])}}
                    </div>

               
                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1">{{trans('common.Save changes')}}</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                                {{trans('common.Cancel')}}
                            </button>
                        </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>