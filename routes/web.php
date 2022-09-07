<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome'); 
});
Route::get('SwitchLang/{lang}',function($lang){
    session()->put('Lang',$lang);
    app()->setLocale($lang);
    if (auth()->check()) {
        $user = App\User::find(auth()->user()->id)->update(['language'=>$lang]);
    }
	return Redirect::back(); 
});
 
Auth::routes();
Route::get('admin/auth/login','admin\AdminLoginController@login')->name('admin.login');
Route::get('doctor/auth/login','DoctorLoginController@login')->name('doctor.login');
Route::get('publisher/auth/login','publishers\PublisherLoginController@login')->name('publisher.login');

Route::get('convert-payments-to-revenues','system\customOldDataController@ConvertPaymentsToRevenues')->name('system.convertPaymentsToRevenues');
Route::get('convert-funds-to-revenues-expenses','system\customOldDataController@ConvertTransfersToRevenuesExpenses')->name('system.ConvertTransfersToRevenuesExpenses');
Route::get('refineExpensesDays','system\customOldDataController@refineExpensesDays')->name('system.refineExpensesDays');
Route::get('refineRevenuesDays','system\customOldDataController@refineRevenuesDays')->name('system.refineRevenuesDays');


Route::get('/client-register','frontend\RegistrationsController@index');
Route::post('/store', 'frontend\RegistrationsController@store')->name('frontend.reservations.store');

