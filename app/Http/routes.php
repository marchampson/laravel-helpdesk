<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return response()->json(['ok'], 200);
//});

Route::get('/home', function() {
    return Redirect::to('/');
});

Route::get('/privacy', 'HomeController@privacy');
Route::get('/terms', 'HomeController@terms');

Route::get('/', 'HomeController@index');
Route::get('/register', 'HomeController@register');
Route::post('/create-account', 'HomeController@createAccount');

Route::get('/plans', 'HomeController@plans');
Route::post('/plans', 'HomeController@plans');

Route::post('/mandrill', 'MandrillController@newMessage');
Route::get('/mandrill', function() {
   return response()->json(['ok'], 200);
});

Route::post('/email-response', 'MandrillController@emailResponse');
Route::get('/email-response', function() {
    return response()->json(['ok'], 200);
});

//Route::post('queue/memset-add', function() {
//   return Queue::marshal();
//});

Route::get('/dns/zone/list', 'DnsController@zonelist');
Route::get('/dns/zone/record/create/{domain}', 'DnsController@zoneRecordCreate');
//
Route::get('/dns/zone/record/list', 'DnsController@zoneRecordList');
//
//Route::post('/earlyaccess', 'MandrillController@earlyaccess');
//Route::get('/earlyaccess', function() {
//    return response()->json(['ok'], 200);
//});

Route::get('/holr/{stub}', 'MandrillController@holr');

Route::get('/inbound', 'MandrillController@inbound');

Route::get('/add-domain/{domain}', 'MandrillController@addDomain');

Route::get('/routes', 'MandrillController@routes');

Route::get('/add-route/{domain}', 'MandrillController@addRoute');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::group(['middleware' => 'auth'], function()
{
    Route::get('/subscribed', 'HomeController@subscribed');

    Route::get('/profile', 'ProfileController@index');
    Route::get('/profile/edit', 'ProfileController@edit');
    Route::post('/profile/edit', 'ProfileController@store');

    Route::get('/profile/plans', 'ProfileController@plans');
    Route::post('/profile/plans', 'ProfileController@plans');

    Route::get('/hollers/{status}', 'HollerController@index');
    Route::get('/hollers/{id}/show', 'HollerController@show');
    Route::post('/hollers/{id}/show', 'HollerController@update');
    Route::get('/hollers/{id}/complete', 'HollerController@complete');
    Route::resource('hollers','HollerController');

    Route::get('/member/create', 'MemberController@create');
    Route::post('/member/create', 'MemberController@store');

    Route::get('/member/{id}/edit', 'MemberController@edit');
    Route::post('/member/{id/edit', 'MemberController@update');

    Route::get('/member/{id}/delete', 'MemberController@destroy');

    Route::get('/domain/create', 'DomainController@create');
    Route::post('/domain/create', 'DomainController@store');

    Route::get('/domain/{id}/show', 'DomainController@show');

    Route::get('/domain/{id}/edit', 'DomainController@edit');
    Route::post('/domain/{id/edit', 'DomainController@update');

    Route::get('/domain/{id}/primary', 'DomainController@primary');

    Route::get('/domain/{id}/delete', 'DomainController@destroy');

    Route::get('/profile/cancel-subscription', 'ProfileController@cancel');
    Route::get('/profile/initiate-shutdown', 'ProfileController@shutdown');


});

