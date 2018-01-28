<?php

Route::get('/', function () {
    return view('welcome', [
        'upcomingEvents' => App\Event::published()->upcoming()->get()
    ]);
});

Auth::routes();

Route::get('/login/magic', 'Auth\MagicLoginController@show')->name('login.magic');
Route::post('/login/magic', 'Auth\MagicLoginController@sendToken');
Route::get('/login/magic/{token}', 'Auth\MagicLoginController@authenticate');
Route::get('/register/verify/{token}', 'Auth\UserConfirmationController@store');
Route::get('/register/email', 'Auth\UserConfirmationController@create');

Route::get('/events/{slug}', 'EventsController@show');
Route::get('/events/{slug}/policies/{policy}', 'EventsPoliciesController@show');

Route::get('/donations/create', 'DonationsController@create');
Route::post('/donations', 'DonationsController@store');
Route::get('/donations/{hash}', 'DonationsController@show');

Route::get('/users/stop-impersonating', 'Admin\ImpersonationController@stopImpersonating')->name('admin.users.stop-impersonating');
