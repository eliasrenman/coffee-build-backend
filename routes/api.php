<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
  Route::get('/', 'Auth\LoginController@redirectToProvider');
  Route::get('/callback', 'Auth\LoginController@handleProviderCallback');
});


Route::group(['middleware' => ['auth.github']], function () {
  Route::group(['prefix' => 'user'], function() {
    Route::patch('/eid', 'User\eidController@update');
    
    Route::post('/subscription', 'User\PushSubscriptionController@store');
    Route::get('/subscriptions', 'User\PushSubscriptionController@index');
    Route::delete('/subscription/{id}', 'User\PushSubscriptionController@delete');
  });
});

Route::get('/notify/{eid}', "NotifyController@store");