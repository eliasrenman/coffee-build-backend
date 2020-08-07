<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
  Route::get('/', 'Auth\LoginController@redirectToProvider');
  Route::get('/callback', 'Auth\LoginController@handleProviderCallback');
});

Route::group(['middleware' => ['auth.github']], function () {
  Route::group(['prefix' => 'user'], function() {
    Route::patch('/uuid', 'User\UuidController@update');
    Route::post('/subscription', 'User\PushSubscriptionController@store');
  });
});
