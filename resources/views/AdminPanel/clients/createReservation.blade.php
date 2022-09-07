<div class="modal fade text-md-start" id="addReservation{{isset($client) ? $client->id : ''}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content"> 
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50"> 
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.addReservation')}}</h1>
                        @if(isset($client))
                             <p>{{$client->name}}</p>                           
                        @endif
                </div>
                {{Form::open(['url'=>route('admin.reservations.store'), 'id'=>'addReservationForm', 'class'=>'row gy-1 pt-75'])}}
                      
                    @if(!isset($client))
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="user_id">{{trans('common.clients')}}</label>
                        {{Form::select('client_id',clientList(),'',['id'=>'client_id','class'=>'form-select selectpicker','data-live-search'=>'true'])}}
                    </div>
                    @else
                        {!! Form::hidden('client_id', $client->id) !!}                            
                    @endif

                    <div class="col-12 col-md-4">
                        <label class="form-label" for="user_id">{{trans('common.doctors')}}</label>
                        {{Form::select('doctor_id',doctorsList(),'',['id'=>'doctor_id','class'=>'form-select selectpicker','data-live-search'=>'true'])}}
                    </div>    
                 
                   <div class="col-12 col-md-4">
                        <label class="form-label" for="day">{{trans('common.date')}}</label>
                        {{Form::date('date','',['id'=>'day', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="hours">{{trans('common.hours')}}</label>
                        {{Form::select('time',hoursList(),'',['id'=>'hours', 'class'=>'form-control'])}}
                    </div>
                 
                    <div class="col-12 col-md-4" style="margin-top:36px">
                        <div class="single-input-field">
                            {{Form::select('serviceoffer',[
                                                    'serviceoffer' => trans('common.serviceoffer'),
                                                    'services' => trans('common.service'),
                                                    'offers' => trans('common.offer')
                                                    ],'',['class'=>'form-control','id'=>'serviceoffer','onchange'=>'serviceOffer(this.value)','required'])}}
                            @if ($errors->has('serviceoffer')) 
                                <label id="serviceoffer-error" class="alert-danger" for="serviceoffer">{{ $errors->first('serviceoffer') }}</label>
                            @endif
                        </div>
                    </div> 
                   
                    <div class="col-12 col-md-4 servicesShow">
                        @foreach(servicesList() as $service)
                            <div class="form-check me-3 me-lg-1">
                                <input class="form-check-input" type="checkbox" id="service{{$service->id}}" name="services[]" value="{{$service->id}}" />
                                <label class="form-check-label" for="service{{$service->id}}">
                                    {{$service->name}}
                                </label>
                            </div>
                        @endforeach
                    </div>
 
                    <div class="col-12 col-md-4 offersShow">
                        @foreach(offersList() as $offer)
                            <div class="form-check me-3 me-lg-1">
                                {{ Form::radio('offer_id', $offer->id, false,['class'=>'form-check-input']) }}
                                <label class="form-check-label" for="offer{{$offer->id}}">
                                    {{$offer->name}}
                                </label>
                            </div>
                        @endforeach
                    </div>
 
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="reason">{{trans('common.note')}}</label>
                        {{Form::textarea('note','',['id'=>'note', 'class'=>'form-control','rows'=>'3'])}}
                    </div>

                    {!! Form::hidden('user_id',Auth::user()->id) !!}    
                    {!! Form::hidden('status',1) !!}  
    

                      
                                
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

</script>
@stop






