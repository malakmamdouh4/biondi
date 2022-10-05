<div class="modal fade text-md-start" id="createAppointment{{isset($reservation) ? $reservation->id : ''}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content"> 
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.createAppointment')}}</h1>
                </div>
                {{Form::open(['url'=>route('admin.appointments.store',$reservation->id), 'id'=>'addAppointmentForm', 'class'=>'row gy-1 pt-75'])}}
 
                    <div class="col-12 col-md-4 servicesShow">
                        <label class="form-label" for="day">{{trans('common.services')}}</label>
                            @foreach(servicesList() as $service)
                                <div class="form-check me-3 me-lg-1">
                                    <label class="form-check-label" for="service{{$service->id}}{{$reservation->id}}">
                                        {{$service->name}}
                                    </label>
                                    <input class="form-check-input" type="checkbox" id="service{{$service->id}}{{$reservation->id}}" name="services[]" value="{{$service->id}}" />
                                </div>
                            @endforeach
                    </div>

                    <div class="col-12 col-sm-4">
                        <label class="form-label" for="area_id">{{trans('common.area')}}</label>
                        {{Form::select('area_id',['0'=>'بدون تحديد'] + areasList(),'',['id'=>'area_id','class'=>'form-select','required'])}}
                    </div>  

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="day">{{trans('common.date')}}</label>
                        {{Form::date('date','',['id'=>'day', 'class'=>'form-control','onchange'=>'getAvailableTimes(this.value)'])}}
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="time">{{trans('common.time')}}</label>
                        <div class="row hoursRadios"></div>
                    </div>

 
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="body">{{trans('common.body')}}</label>
                        {{Form::text('body','',['id'=>'body', 'class'=>'form-control'])}}
                    </div>
 
                    
                    {!! Form::hidden('reservation_id', $reservation->id ?? '0') !!}  
                    {!! Form::hidden('client_id', $reservation->client->id ?? '0') !!}  
                    {!! Form::hidden('employee_id', $reservation->employee->id ?? '0') !!}
                   

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


@section('scripts')
<script>
    function serviceOffer(val) {
        var type = val;
        console.log(type);
        if(type == 'serviceoffer')
        {
            $('.offersShow').hide();
            $('.servicesShow').hide();
        }
        if (type == 'offers') {
            $('.offersShow').show();
        } else {
            $('.offersShow').hide();
        }
        if (type == 'services') {
            $('.servicesShow').show();
        } else {
            $('.servicesShow').hide();
        }
    }


   








    function getAvailableTimes(date){
        $.ajax({
            type: "POST",
            url: "{{route('admin.getAvailableTimes')}}",
            data : {
                'date': date,
                '_token': '{{ csrf_token() }}'
            },    
            dataType: "html",   //expect html to be returned                
            success: function(data){
                var list = $.parseJSON(data);
                if (list.length > 0) {
                    console.log(data);
                    var radioInput = '';
                    for (var i=0;i<list.length;i++){
                        radioInput += '<div class="col-md-2"><div class="form-check me-3 me-lg-1">';
                        radioInput += '<label class="form-check-label" for="hour'+list[i]+'">';
                        radioInput += list[i];
                        radioInput += '</label>';
                        radioInput += '<input type="radio" name="hour" value="'+list[i]+'" class="form-check-input" id="hour'+list[i]+'" />';
                        radioInput += '</div></div>';
                    }
                    $('.hoursRadios').find('div').remove().end().append(radioInput);
                } else {
                    $('#saleVoucherItems').empty();
                    radioInput += '<option value="">اختر الفاتورة</option>';
                    $('.hoursRadios').find('div').remove().end().append(radioInput);
                }
            }
        });
    }

    


</script>


@stop