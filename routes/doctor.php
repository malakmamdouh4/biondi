<?php

use App\Http\Controllers\DoctorPanelController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix'=>'DoctorPanel','middleware'=>['isAdmin','auth']], function(){

    Route::get('/','doctor\DoctorPanelController@index')->name('doctor.index');

    Route::get('/read-all-notifications','doctor\DoctorPanelController@readAllNotifications')->name('doctor.notifications.readAll');
    Route::get('/notification/{id}/details','doctor\DoctorPanelController@notificationDetails')->name('doctor.notification.details');
  
    Route::get('/my-salary','doctor\DoctorPanelController@mySalary')->name('doctor.mySalary');
    Route::get('/my-profile','doctor\DoctorPanelController@EditProfile')->name('doctor.myProfile');
    Route::post('/my-profile','doctor\DoctorPanelController@UpdateProfile')->name('doctor.myProfile.update');
    Route::get('/my-password','doctor\DoctorPanelController@EditPassword')->name('doctor.myPassword');
    Route::post('/my-password','doctor\DoctorPanelController@UpdatePassword')->name('doctor.myPassword.update');


    Route::post('/{id}/Edit', 'doctor\AppointmentsController@update')->name('doctor.appointments.update');
    Route::get('/{id}/EditStatus', 'doctor\AppointmentsController@updateStatus')->name('doctor.appointments.updateStatus');
});        