<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
  Route::get('/', 'Auth\LoginController@redirectToProvider');
  Route::get('/callback', 'Auth\LoginController@handleProviderCallback');
});

Route::group(['middleware' => ['auth.github']], function () {
  Route::get('', function() {
      return "This github authenticated route works!";
  });

  Route::group(['prefix' => 'user'], function() {
    Route::patch('uuid', 'User\UuidController@update');
  });
});
