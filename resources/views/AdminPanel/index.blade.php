@extends('AdminPanel.layouts.master')

@section('content')
 
<?php
    $year = date('Y');
    $month = date('m');
    $day = date("d");
    $hour = date('H:i');
    $branch = 'all';

    if (isset($_GET['month'])) {
        if ($_GET['month'] != '') {
            $month = $_GET['month'];
        }
    }
    if (isset($_GET['year'])) {
        if ($_GET['year'] != '') {
            $year = $_GET['year'];
        }
    }
    if (isset($_GET['branch_id'])) {
        if ($_GET['branch_id'] != '') {
            $branch= $_GET['branch_id'];
        }
    }
 
    if (isset($_GET['safe_id'])) {
        if ($_GET['safe_id'] != '') {
            $safeId = $_GET['safe_id'];
        }
    }


?>


    <!-- Dashboard Analytics Start -->
    <section id="dashboard-analytics"> 
        <div class="row">
            @if(userCan('view_home_stats'))
                <!--/ Line Chart -->
                <div class="col-lg-12 col-12">
                    <div class="card card-statistics">
                        <div class="card-header">
                            <h4 class="card-title">{{ auth()->user()->name }}</h4>
                            <div class="d-flex align-items-center">
                                <p class="card-text me-25 mb-0">{{ $hour }} ,  {{ $month }} - {{ $day }}  </p>
                            </div>
                        </div>
                        <div class="card-body statistics-body">
                            <div class="row justify-content-center">
                               
                                <!-- revenues -->
                                <div class="col-md-2 col-sm-6 col-12"> 
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-success me-1">
                                            <div class="avatar-content">
                                                <i data-feather="dollar-sign" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                            <h4 class="fw-bolder mb-0"> {{ round(revenuesTotals($branch, $month, $year)['monthTotal']) }}</h4>
                                            <p class="card-text font-small-3 mb-0">{{trans('common.monthRevenues')}}</p>
                                        </div>
                                    </div>   
                                </div> 
                                <div class="col-md-2 col-sm-6 col-12">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-success me-1">
                                            <div class="avatar-content">
                                                <i data-feather="dollar-sign" class="avatar-icon"></i>
                                            </div> 
                                        </div>
                                        <div class="my-auto">
                                            <h4 class="fw-bolder mb-0">{{ round(revenuesTotals($branch, $month, $year)['dayRevenues']) }}</h4>
                                            <p class="card-text font-small-3 mb-0">{{trans('common.dayRevenues')}}</p>
                                        </div>
                                    </div>    
                                </div> 


                                <!-- expenses -->
                                <div class="col-md-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-danger me-1">
                                            <div class="avatar-content">
                                                <i data-feather="check" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                        <?php $expenses = App\Expenses::where('month',$month)->whereNotIn('Type',['withdrawal','transfeerToAnother'])->sum('Expense');?>
                                            <h4 class="fw-bolder mb-0">{{ $expenses }}</h4>
                                            <p class="card-text font-small-3 mb-0">{{trans('common.monthExpenses')}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-danger me-1">
                                            <div class="avatar-content">
                                                <i data-feather="check" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                        <?php $expenses = App\Expenses::where('ExpenseDate',date('Y-m-d'))->whereNotIn('Type', ['withdrawal','transfeerToAnother'])->sum('Expense'); ?>
                                            <h4 class="fw-bolder mb-0">{{ $expenses }}</h4>
                                            <p class="card-text font-small-3 mb-0">{{trans('common.dayExpenses')}}</p>
                                        </div>
                                    </div>
                                </div>  

 

                                <!-- pulses    -->
                                <div class="col-md-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-danger me-1">
                                            <div class="avatar-content">
                                                <i data-feather="check" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                        
                                            <h4 class="fw-bolder mb-0">{{ pulsesInMonth()['used'] }}</h4>
                                            <p class="card-text font-small-3 mb-0">{{trans('common.usedPulses')}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-danger me-1">
                                            <div class="avatar-content">
                                                <i data-feather="check" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                       
                                            <h4 class="fw-bolder mb-0"> {{ pulsesInMonth()['total'] }}</h4>
                                            <p class="card-text font-small-3 mb-0">{{trans('common.bookedPulses')}}</p>
                                        </div>
                                    </div>
                                </div>


                                <!-- clients -->
                                <div class="col-md-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-danger me-1">
                                            <div class="avatar-content">
                                                <i data-feather="check" class="avatar-icon"></i>
                                            </div> 
                                        </div>
                                        <div class="my-auto">
                                        
                                            <h4 class="fw-bolder mb-0">{{ clientsMonth() }}</h4>
                                            <p class="card-text font-small-3 mb-0">{{trans('common.monthClients')}}</p>
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-md-2 col-sm-6 col-12 mb-2 mb-sm-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-danger me-1">
                                            <div class="avatar-content">
                                                <i data-feather="check" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                        <?php $clients = App\Clients::where('date',date('Y-m-d'))->count(); ?>
                                            <h4 class="fw-bolder mb-0">{{ $clients }}</h4>
                                            <p class="card-text font-small-3 mb-0">{{trans('common.dayClients')}}</p>
                                        </div>
                                    </div>
                                </div>  



                            
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        

 
               <!-- Avg Sessions Chart Card starts -->
               <div class="col-lg-12 col-12">
                <div class="card">
                    <div class="card-body">
                       
                         <!-- Bordered table start -->
                         <div class="row" id="table-bordered">
                                <div class="col-12">
                                    <div class="card">  
                                        <div class="card-header">
                                            <h4 class="card-title"> {{trans('common.15daysAppointments')}} </h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-2">
                                                <thead> 
                                                    <tr>  
                                                        <th class="text-center">{{trans('common.date')}}  </th>
                                                        <th class="text-center">{{trans('common.clientname')}}</th>
                                                        <th class="text-center">{{trans('common.employeename')}}</th>
                                                        <th class="text-center">{{trans('common.services')}}  </th>
                                                        <th class="text-center">{{trans('common.details')}}  </th>
                                                        <th class="text-center">{{trans('common.actions')}}  </th>
                                                    </tr>
                                                </thead>
                                                <tbody>    
                                                    @forelse(appointmentsList() as $appointment)
                                                    <tr id="row_{{$appointment->id}}">
                                                        <td class="text-center text-nowrap">
                                                           {{$appointment['date']  }}  <br> {{$appointment['hour'] }} 
                                                        </td>
                                                        <td  class="text-center text-nowrap">
                                                            @if(isset($appointment->client->id))  
                                                               {{$appointment->client->Name}}  <br> 
                                                                {{$appointment->client->phone}} <br> 
                                                                 {{trans('common.code')}}: {{$appointment->client->code}}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-center text-nowrap">
                                                            @if(isset($appointment->employee->id)) 
                                                                {{$appointment->employee->name}} <br>
                                                                {{$appointment->employee->phone}}  
                                                            @else
                                                                -
                                                            @endif                                                        
                                                        </td>
                                                        <td class="text-center text-nowrap">
                                                            @foreach($appointment->services as $service)
                                                                {{ $service->name }}  <br>
                                                            @endforeach
                                                        </td>
                                                        <td class="text-center text-nowrap">
                                                          -
                                                        </td> 
                                                        <td class="text-center text-nowrap">

                                                            <a href="javascript:;" data-bs-target="#" data-bs-toggle="modal" class="btn btn-icon btn-warning">
                                                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.cancel')}}">
                                                                    <i data-feather='x'></i>
                                                                </span>    
                                                            </a>
  
                                                            <a href="javascript:;" data-bs-target="#addComplaint{{$appointment->client_id}}" data-bs-toggle="modal" class="btn btn-icon btn-dark">
                                                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.addComplaint')}}">
                                                                    <i data-feather='alert-circle'></i>
                                                                </span>    
                                                            </a>
                                                            <div class="col-md-12" style="margin:10px"> </div>

                                                            <a href="javascript:;" data-bs-target="#editappointment{{$appointment->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info">
                                                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                                                    <i data-feather='edit'></i>
                                                                </span>    
                                                            </a>

                                                            <?php $delete = route('admin.appointments.delete',['id'=>$appointment->id]); ?>
                                                            <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$appointment->id}}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
                                                                <i data-feather='trash-2'></i>
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="p-3 text-center ">
                                                                <h2>{{trans('common.nothingToView')}}</h2>
                                                            </td>
                                                        </tr>
                                                    @endforelse

                                                  
                                                </tbody>
                                            </table>
                                        </div>

                                    

                                    </div>
                                </div>
                            </div>
                        <!-- Bordered table end -->
                     
                    </div>
                </div>
            </div>
            <!-- Avg Sessions Chart Card ends -->

              <!-- Avg Sessions Chart Card starts -->
              <div class="col-lg-12 col-12">
                <div class="card">
                    <div class="card-body">
                       
                         <!-- Bordered table start -->
                         <div class="row" id="table-bordered">
                                <div class="col-12">
                                    <div class="card"> 
                                        <div class="card-header">
                                            <h4 class="card-title"> {{trans('common.todayAppointments')}} </h4>

                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-2">
                                                <thead>  
                                                    <tr>  
                                                    <th class="text-center">{{trans('common.date')}}  </th>
                                                        <th class="text-center">{{trans('common.clientname')}}</th>
                                                        <th class="text-center">{{trans('common.employeename')}}</th>
                                                        <th class="text-center">{{trans('common.services')}}  </th>
                                                        <th class="text-center">{{trans('common.details')}}  </th>
                                                        <th class="text-center">{{trans('common.actions')}}  </th>
                                                    </tr>
                                                </thead>
                                                <tbody>    
                                                    <?php $appointments = App\Appointment::where('date',date('Y-m-d'))->where('status','completedSession')->get(); ?>
                                                    @forelse($appointments as $appointment)
                                                    <tr id="row_{{$appointment->id}}">
                                                    <td class="text-center text-nowrap">
                                                           {{$appointment['date']  }}  <br> {{$appointment['hour'] }} 
                                                        </td>
                                                        <td  class="text-center text-nowrap">
                                                            @if(isset($appointment->client->id))  
                                                               {{$appointment->client->Name}}  <br> 
                                                                {{$appointment->client->phone}} <br> 
                                                                 {{trans('common.code')}}: {{$appointment->client->code}}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="text-center text-nowrap">
                                                               {{$appointment->employee->name}} <br>
                                                                {{$appointment->employee->phone}}                                                          
                                                        </td>
                                                        <td class="text-center text-nowrap">
                                                            @foreach($appointment->services as $service)
                                                                {{ $service->name }}  <br>
                                                            @endforeach
                                                        </td>
                                                        <td class="text-center text-nowrap">
                                                          -
                                                        </td> 
                                                        <td class="text-center text-nowrap">
                                                            <a href="javascript:;" data-bs-target="#addComplaint{{$appointment->client_id}}" data-bs-toggle="modal" class="btn btn-icon btn-dark">
                                                                <span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.addComplaint')}}">
                                                                    <i data-feather='alert-circle'></i>
                                                                </span>    
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="p-3 text-center ">
                                                                <h2>{{trans('common.nothingToView')}}</h2>
                                                            </td>
                                                        </tr>
                                                    @endforelse

                                                  
                                                </tbody>
                                            </table>
                                        </div>

                                    

                                    </div>
                                </div>
                            </div>
                        <!-- Bordered table end -->
                     
                    </div>
                </div>
            </div>
            <!-- Avg Sessions Chart Card ends -->


        </div>
    </section>
    <!-- Dashboard Analytics end -->
 

  <!-- edit appointments -->
  @foreach(appointmentsList() as $appointment)
    @include('AdminPanel.appointments.edit',['appointment'=>$appointment])
   <?php $client = App\Clients::find($appointment->client_id) ; ?>
    @include('AdminPanel.clients.createComplaint',['client'=>$client])
  @endforeach



@stop




@section('new_style')
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/vendors/css/charts/apexcharts.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/css-rtl/plugins/charts/chart-apex.css')}}">
@stop

@section('scripts')
    <script src="{{asset('AdminAssets/app-assets/vendors/js/charts/apexcharts.min.js')}}"></script>
    <!-- BEGIN: Page JS-->
    <?php /*<script src="{{asset('AdminAssets/app-assets/js/scripts/pages/dashboard-analytics.js')}}"></script>*/?>
    <script src="{{asset('AdminAssets/app-assets/js/scripts/pages/app-invoice-list.js')}}"></script>
    <!-- END: Page JS-->
    <script>
        $(window).on('load', function () {
            var $avgSessionStrokeColor2 = '#ebf0f7';
            var $avgSessionsChart = document.querySelector('#avg-sessions-chart');
            var avgSessionsChartOptions;
            var avgSessionsChart;
            // Average Session Chart
            // ----------------------------------
            avgSessionsChartOptions = {
                chart: {
                    type: 'bar',
                    height: 200,
                    sparkline: { enabled: true },
                    toolbar: { show: false }
                },
                states: {
                    hover: {
                    filter: 'none'
                    }
                },
                colors: [
                    window.colors.solid.primary,
                    window.colors.solid.primary,
                    window.colors.solid.primary,
                    window.colors.solid.primary,
                    window.colors.solid.primary,
                    window.colors.solid.primary
                ],
                series: [
                    {
                        name: 'Sessions',
                        data: [75, 125, 20, 175, 125, 75, 25]
                    }
                ],
                grid: {
                    show: false,
                    padding: {
                        left: 0,
                        right: 0
                    }
                },
                plotOptions: {
                    bar: {
                        columnWidth: '45%',
                        distributed: true,
                        endingShape: 'rounded'
                    }
                },
                tooltip: {
                    x: { show: false }
                },
                xaxis: {
                    type: 'numeric'
                }
            };
            avgSessionsChart = new ApexCharts($avgSessionsChart, avgSessionsChartOptions);
            avgSessionsChart.render();

        });
    </script>
@stop
