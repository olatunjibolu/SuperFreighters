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

//Route::get('/', function () {
   // return view('welcome');
//});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('order','Ordercontroller')->middleware('auth');

Route::post('/order/{id}','Ordercontroller@store')->name('order.store');
Route::get('/order/{id}','Ordercontroller@show')->name('order.show');
//Route::post('/order/{id}','Ordercontroller@initialise')->name('order.initialise');

Route::get('/report', [App\Http\Controllers\Ordercontroller::class, 'report'])->name('report');

Route::resource('category','Categorycontroller')->middleware('auth');

Route::resource('product','Productcontroller')->middleware('auth');

Route::get('/products/{id}','Productcontroller@view')->name('product.view');

Route::get('/home/{id}','HomeController@view')->name('home.view');


Route::get('/','Productcontroller@listProduct');

Route::post('/pay', 'Paymentcontroller@redirectToGateway')->name('pay');
Route::get('/payment/callback', 'Paymentcontroller@handleGatewayCallback');
/*
Route::get('send-mail', function () {
   
   $details = [
       'title' => 'Freight Confirmation Order',
       'body' => 'Thank you for your Order. Your payment successful. Your Order is now under processing'
   ];
  
    $userEmail = auth()->user()->email;
    //echo $userEmail;
   \Mail::to($userEmail)->send(new \App\Mail\MyTestMail($details));
  
   dd("Email is Sent.");
});
*/
