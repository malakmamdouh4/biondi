<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix'=>'AdminPanel','middleware'=>['isAdmin','auth']], function(){
    Route::get('/','admin\AdminPanelController@index')->name('admin.index');

    Route::get('/read-all-notifications','admin\AdminPanelController@readAllNotifications')->name('admin.notifications.readAll');
    Route::get('/notification/{id}/details','admin\AdminPanelController@notificationDetails')->name('admin.notification.details');

    Route::get('/my-salary','admin\AdminPanelController@mySalary')->name('admin.mySalary');
    Route::get('/my-profile','admin\AdminPanelController@EditProfile')->name('admin.myProfile');
    Route::post('/my-profile','admin\AdminPanelController@UpdateProfile')->name('admin.myProfile.update');
    Route::get('/my-password','admin\AdminPanelController@EditPassword')->name('admin.myPassword');
    Route::post('/my-password','admin\AdminPanelController@UpdatePassword')->name('admin.myPassword.update');
    Route::get('/notifications-settings','admin\AdminPanelController@EditNotificationsSettings')->name('admin.notificationsSettings');
    Route::post('/notifications-settings','admin\AdminPanelController@UpdateNotificationsSettings')->name('admin.notificationsSettings.update');
   

    // Users 
    Route::group(['prefix'=>'users'], function(){
        Route::get('/','admin\AdminUsersController@index')->name('admin.adminUsers');
        Route::get('/create','admin\AdminUsersController@create')->name('admin.adminUsers.create');
        Route::post('/create','admin\AdminUsersController@store')->name('admin.adminUsers.store');
        Route::get('/{id}/block/{action}','admin\AdminUsersController@blockAction')->name('admin.adminUsers.block');
        Route::get('/{id}/edit','admin\AdminUsersController@edit')->name('admin.adminUsers.edit');
        Route::post('/{id}/edit','admin\AdminUsersController@update')->name('admin.adminUsers.update');
        Route::get('/{id}/hrProfile','admin\AdminUsersController@hrProfile')->name('admin.adminUsers.hrProfile');
        Route::post('/{id}/hrProfile','admin\AdminUsersController@updateHRProfile')->name('admin.adminUsers.updateHRProfile');
        Route::get('/{id}/delete','admin\AdminUsersController@delete')->name('admin.adminUsers.delete');
        Route::get('/{id}/DeletePhoto/{photo}/{X}', 'admin\AdminUsersController@DeleteuserPhoto')->name('admin.users.deletePhoto');
    });
 
    
    // Doctors
    Route::group(['prefix'=>'doctors'], function(){
        Route::get('/','admin\AdminDoctorsController@index')->name('admin.doctors');
        Route::get('/create','admin\AdminDoctorsController@create')->name('admin.doctors.create');
        Route::post('/create','admin\AdminDoctorsController@store')->name('admin.doctors.store');
        Route::get('/{id}/block/{action}','admin\AdminDoctorsController@blockAction')->name('admin.doctors.block');
        Route::get('/{id}/edit','admin\AdminDoctorsController@edit')->name('admin.doctors.edit');
        Route::post('/{id}/edit','admin\AdminDoctorsController@update')->name('admin.doctors.update');
        Route::post('/{userId}/{serviceId}/edit','admin\AdminDoctorsController@updateCommission')->name('admin.commission.update'); 
        Route::get('/{id}/hrProfile','admin\AdminDoctorsController@hrProfile')->name('admin.doctors.hrProfile');
        Route::post('/{id}/hrProfile','admin\AdminDoctorsController@updateHRProfile')->name('admin.doctors.updateHRProfile');
        Route::get('/{id}/delete','admin\AdminDoctorsController@delete')->name('admin.doctors.delete');
        Route::get('/{id}/DeletePhoto/{photo}/{X}', 'admin\AdminDoctorsController@DeleteuserPhoto')->name('admin.users.deletePhoto');
    });


    // HR >> units
    Route::group(['prefix'=>'managements'], function(){
        Route::get('/','admin\hr\ManagementsController@index')->name('admin.managements');
        Route::post('/create','admin\hr\ManagementsController@store')->name('admin.managements.store');
        Route::post('/{id}/edit','admin\hr\ManagementsController@update')->name('admin.managements.update');
        Route::get('/{id}/delete','admin\hr\ManagementsController@delete')->name('admin.managements.delete');
    });

    // HR >> jobs
    Route::group(['prefix'=>'jobs'], function(){
        Route::get('/','admin\hr\JobsController@index')->name('admin.jobs');
        Route::post('/create','admin\hr\JobsController@store')->name('admin.jobs.store');
        Route::post('/{id}/edit','admin\hr\JobsController@update')->name('admin.jobs.update');
        Route::get('/{id}/delete','admin\hr\JobsController@delete')->name('admin.jobs.delete');
    });

    // HR >> Salaries of Employees
    Route::group(['prefix'=>'SalariesControl'], function(){
        //HR Dep. -> Salaries Managment
        Route::get('/', 'admin\hr\SalariesController@index')->name('admin.salaries');
        Route::get('/{id}/Salaries', 'admin\hr\SalariesController@EmployeeSalary')->name('admin.EmployeeSalary');
        Route::post('/{id}/payOutSalary', 'admin\hr\SalariesController@payOutSalary')->name('admin.payOutSalary');
        
        Route::post('/{id}/AddPermission', 'admin\hr\AttendanceController@AddPermission')->name('admin.AddPermission');
        Route::get('/{id}/DeletePermission', 'admin\hr\AttendanceController@DeletePermission')->name('admin.DeletePermission');
        Route::post('/{id}/AddVacation', 'admin\hr\AttendanceController@AddVacation')->name('admin.AddVacation');
        Route::get('/Vacations/{id}/delete', 'admin\hr\AttendanceController@DeleteVacation')->name('admin.DeleteVacation');
 
        Route::get('/AttendanceList', 'admin\hr\AttendanceController@index')->name('admin.attendance');
        Route::post('/NewAttendance', 'admin\hr\AttendanceController@SubmitNewAttendance')->name('admin.attendace.excel');

        //HR Dep. -> Salaries Managment -> Records
        Route::group(['prefix'=>'{UID}/Attendance'], function(){
            Route::get('/{Date}/EditVacation', 'admin\hr\AttendanceController@EmployeeEditVacation')->name('EmployeeEditVacation');
            Route::post('/{Date}/EditVacation', 'admin\hr\AttendanceController@EmployeePostEditVacation')->name('EmployeePostEditVacation');
        });

        //HR Dep. -> Salaries Managment -> Add Deduction
        Route::group(['prefix'=>'deductions'], function(){
            Route::post('/store', 'admin\hr\DeductionsController@store')->name('admin.deductions.store');
            Route::post('/{id}/Edit', 'admin\hr\DeductionsController@update')->name('admin.deductions.update');
            Route::get('/{id}/Delete', 'admin\hr\DeductionsController@delete')->name('admin.deductions.delete');
        });

        //test
        Route::post('/{EID}/PaySalary/{Type}', 'HRDepController@PaySalary')->name('SalaryPay');
        Route::get('/{EID}/PaySalary/{Type}', 'HRDepController@PaySalaryRequest')->name('SalaryPayRequest');
    });


    // Roles
    Route::group(['prefix'=>'roles'], function(){
        Route::post('/CreatePermission','admin\RolesController@CreatePermission')->name('admin.CreatePermission');
        Route::get('/','admin\RolesController@index')->name('admin.roles');
        Route::post('/create','admin\RolesController@store')->name('admin.roles.store');
        Route::post('/{id}/edit','admin\RolesController@update')->name('admin.roles.update');
        Route::get('/{id}/delete','admin\RolesController@delete')->name('admin.roles.delete');
    });


    Route::group(['prefix'=>'governorates'], function(){
        Route::get('/','admin\GovernoratesController@index')->name('admin.governorates');
        Route::post('/create','admin\GovernoratesController@store')->name('admin.governorates.store');
        Route::post('/{governorateId}/edit','admin\GovernoratesController@update')->name('admin.governorates.update');
        Route::get('/{governorateId}/delete','admin\GovernoratesController@delete')->name('admin.governorates.delete');

        Route::group(['prefix'=>'{governorateId}/cities'], function(){
            Route::get('/','admin\CitiesController@index')->name('admin.cities');
            Route::post('/create','admin\CitiesController@store')->name('admin.cities.store');
            Route::post('/{cityId}/edit','admin\CitiesController@update')->name('admin.cities.update');
            Route::get('/{cityId}/delete','admin\CitiesController@delete')->name('admin.cities.delete');
        });
    });

    Route::group(['prefix'=>'settings'], function(){
        Route::get('/','admin\SettingsController@generalSettings')->name('admin.settings.general');
        Route::post('/','admin\SettingsController@updateSettings')->name('admin.settings.update');
        Route::get('/{key}/deletePhoto','admin\SettingsController@deleteSettingPhoto')->name('admin.settings.deletePhoto');
    });

    Route::group(['prefix'=>'branches'], function(){
		Route::get('/', 'admin\BranchesController@index')->name('admin.branches.index');
		Route::post('/', 'admin\BranchesController@store')->name('admin.branches.store');
		Route::post('{id}/Edit', 'admin\BranchesController@update')->name('admin.branches.update');
		Route::get('{id}/Delete', 'admin\BranchesController@delete')->name('admin.branches.delete');
    });

    Route::group(['prefix'=>'services'], function(){

        Route::group(['prefix'=>'machines'], function(){
            Route::get('/','admin\services\MachinesController@index')->name('admin.machines');
            Route::post('/create','admin\services\MachinesController@store')->name('admin.machines.store');
            Route::post('/{machineId}/edit','admin\services\MachinesController@update')->name('admin.machines.update');
            Route::get('/{machineId}/delete','admin\services\MachinesController@delete')->name('admin.machines.delete');
        });

        Route::group(['prefix'=>'areas'], function(){
            Route::get('/','admin\services\AreasController@index')->name('admin.areas');
            Route::post('/create','admin\services\AreasController@store')->name('admin.areas.store');
            Route::post('/{areaId}/edit','admin\services\AreasController@update')->name('admin.areas.update');
            Route::get('/{areaId}/delete','admin\services\AreasController@delete')->name('admin.areas.delete');
        });

        Route::group(['prefix'=>'management-services'], function(){ 
            Route::get('/','admin\services\ManagementServicesController@index')->name('admin.services');
            Route::post('/create','admin\services\ManagementServicesController@store')->name('admin.services.store');
            Route::post('/{serviceId}/edit','admin\services\ManagementServicesController@update')->name('admin.services.update');
            Route::get('/{serviceId}/delete','admin\services\ManagementServicesController@delete')->name('admin.services.delete');
            Route::get('/{id}/reports','admin\services\ManagementServicesController@reports')->name('admin.services.reports');

        });

        Route::group(['prefix'=>'offers'], function(){
            Route::get('/','admin\services\OffersController@index')->name('admin.offers');
            Route::post('/create','admin\services\OffersController@store')->name('admin.offers.store');
            Route::post('/{offerId}/edit','admin\services\OffersController@update')->name('admin.offers.update');
            Route::get('/{offerId}/delete','admin\services\OffersController@delete')->name('admin.offers.delete');
        });

    });

 
    /**
	 * Safes Control
	*/ 
    Route::group(['prefix'=>'Safes'], function(){
		//Safes Control
		Route::get('/', 'admin\accounts\SafesController@index')->name('admin.safes');
		Route::post('/', 'admin\accounts\SafesController@store')->name('admin.safes.store');
		Route::post('/{id}/Edit', 'admin\accounts\SafesController@update')->name('admin.safes.update');
		Route::get('/{id}/Delete', 'admin\accounts\SafesController@delete')->name('admin.safes.delete');
		Route::get('/{id}/Stats', 'admin\accounts\SafesController@Stats')->name('admin.safes.Stats');
    });
  
    Route::group(['prefix'=>'ExpensesTypes'], function(){
        Route::get('/', 'admin\accounts\ExpensesTypesController@index')->name('admin.expensesTypes');
        Route::post('/create', 'admin\accounts\ExpensesTypesController@store')->name('admin.expensesTypes.store');
        Route::post('/{id}/Edit', 'admin\accounts\ExpensesTypesController@update')->name('admin.expensesTypes.update');
        Route::get('/{id}/Delete', 'admin\accounts\ExpensesTypesController@delete')->name('admin.expensesTypes.delete');
    });

    Route::group(['prefix'=>'expenses'], function(){
        Route::get('/', 'admin\accounts\ExpensesController@index')->name('admin.expenses');
        Route::post('/NewExpense', 'admin\accounts\ExpensesController@store')->name('admin.expenses.store');
        Route::post('/{id}/Edit', 'admin\accounts\ExpensesController@update')->name('admin.expenses.update');
        Route::get('/{id}/DeletePhoto/{photo}/{X}', 'admin\accounts\ExpensesController@deletePhoto')->name('admin.expenses.deletePhoto');
        Route::get('/{id}/Delete', 'admin\accounts\ExpensesController@delete')->name('admin.expenses.delete');
    });

    Route::group(['prefix'=>'revenues'], function(){
        Route::get('/', 'admin\accounts\RevenuesController@index')->name('admin.revenues');
        Route::post('/NewExpense', 'admin\accounts\RevenuesController@store')->name('admin.revenues.store');
        Route::post('/{id}/Edit', 'admin\accounts\RevenuesController@update')->name('admin.revenues.update');
        Route::get('/{id}/DeletePhoto/{photo}/{X}', 'admin\accounts\RevenuesController@deletePhoto')->name('admin.revenues.deletePhoto');
        Route::get('/{id}/Delete', 'admin\accounts\RevenuesController@delete')->name('admin.revenues.delete');
    });


    
 
    /**
	* 
	* ClientsControl
	*/ 
	Route::group(['prefix'=>'clients'], function(){
		Route::get('/', 'admin\ClientsFollowUps\ClientsController@index')->name('admin.clients');
        Route::post('/{id}/addComplaint', 'admin\ClientsFollowUps\ClientsController@addComplaint')->name('admin.clients.addComplaint');
		Route::post('/store', 'admin\ClientsFollowUps\ClientsController@store')->name('admin.clients.store');
		Route::post('/createExcelClient', 'admin\ClientsFollowUps\ClientsController@storeExcelClient')->name('admin.clients.storeExcelClient');
		Route::post('/{id}/Edit', 'admin\ClientsFollowUps\ClientsController@update')->name('admin.clients.update');
        Route::get('/{id}/block/{action}','admin\ClientsFollowUps\ClientsController@blockAction')->name('admin.clients.block');
		Route::get('/{id}/Delete', 'admin\ClientsFollowUps\ClientsController@delete')->name('admin.clients.delete');
		Route::get('/noAgentClients', 'admin\ClientsFollowUps\ClientsController@noAgentClients')->name('admin.noAgentClients');
		Route::post('/NoAgent/changeAgent', 'admin\ClientsFollowUps\ClientsController@changeAgent')->name('admin.noAgentClients.asignAgent');
      
        Route::group(['prefix'=>'reservations'], function(){ 
            Route::get('/', 'admin\Reservations\ReservationsController@index')->name('admin.reservations');
            Route::post('/store', 'admin\Reservations\ReservationsController@store')->name('admin.reservations.store');
            Route::get('/filter','admin\Reservations\ReservationsController@filterReservations')->name('admin.filterReservations');
            Route::post('/{id}/Edit', 'admin\Reservations\ReservationsController@update')->name('admin.reservations.update');
            Route::get('/{id}/EditStatus', 'admin\Reservations\ReservationsController@updateStatus')->name('admin.reservations.updateStatus');
            Route::get('/{id}/Delete', 'admin\Reservations\ReservationsController@delete')->name('admin.reservations.delete');

            Route::post('/movePulses', 'admin\Reservations\ReservationsController@movePulses')->name('admin.reservations.movePulses.store');
            Route::post('/movePayment', 'admin\Reservations\ReservationsController@movePayment')->name('admin.reservations.movePayment.store');

        }); 

        Route::group(['prefix'=>'appointments'], function(){
            Route::get('/{id}', 'admin\Reservations\AppointmentsController@index')->name('admin.appointments');
            Route::post('/{id}/store', 'admin\Reservations\AppointmentsController@store')->name('admin.appointments.store');
            Route::post('/{id}/{id1}/Edit', 'admin\Reservations\AppointmentsController@update')->name('admin.appointments.update');
            Route::get('/{id}/EditStatus', 'admin\Reservations\AppointmentsController@updateStatus')->name('admin.appointments.updateStatus');
            Route::get('/{id}/Delete', 'admin\Reservations\AppointmentsController@delete')->name('admin.appointments.delete');
            Route::post('/getAvailableTimes', 'admin\Reservations\AppointmentsController@getAvailableTimes')->name('admin.getAvailableTimes');
        });


        Route::group(['prefix'=>'payments'], function(){
            Route::get('/{id}', 'admin\Reservations\PaymentsController@index')->name('admin.payments');
            Route::post('/store', 'admin\Reservations\PaymentsController@store')->name('admin.payments.store');
            Route::post('/{id}/Edit', 'admin\Reservations\PaymentsController@update')->name('admin.payments.update');
            Route::get('/{id}/Delete', 'admin\Reservations\PaymentsController@delete')->name('admin.payments.delete');
        });

        
        Route::group(['prefix'=>'complaints'], function(){
            Route::get('/', 'admin\ClientsFollowUps\ComplaintsController@index')->name('admin.complaints');
            Route::post('/store', 'admin\ClientsFollowUps\ComplaintsController@store')->name('admin.complaints.store');
            Route::post('/{id}/Edit', 'admin\ClientsFollowUps\ComplaintsController@update')->name('admin.complaints.update');
            Route::get('/{id}/Delete', 'admin\ClientsFollowUps\ComplaintsController@delete')->name('admin.complaints.delete');
        });
 
        Route::get('/{id}/profile', 'admin\ClientsFollowUps\ClientProfileController@showProfile')->name('admin.clients.profile');

        
        Route::group(['prefix'=>'refferalClients'], function(){
            Route::get('/', 'admin\ClientsFollowUps\RefferalClientsController@index')->name('admin.refferalClients');
            Route::post('/store', 'admin\ClientsFollowUps\RefferalClientsController@store')->name('admin.refferalClients.store');
            Route::post('/{id}/Edit', 'admin\ClientsFollowUps\RefferalClientsController@update')->name('admin.refferalClients.update');
            Route::get('/{id}/Delete', 'admin\ClientsFollowUps\RefferalClientsController@delete')->name('admin.refferalClients.delete');
        });




    });  

	Route::group(['prefix'=>'reports'], function(){
		Route::get('/userFollowUpsReport', 'admin\ReportsController@userFollowUpsReport')->name('admin.userFollowUpsReport');
		Route::get('/teamFollowUpsReport', 'admin\ReportsController@teamFollowUpsReport')->name('admin.teamFollowUpsReport');
		Route::get('/branchFollowUpsReport', 'admin\ReportsController@branchFollowUpsReport')->name('admin.branchFollowUpsReport');
		Route::get('/accountsReport', 'admin\ReportsController@accountsReport')->name('admin.accountsReport');
	});

});