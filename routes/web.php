<?php

Route::get('/', 'WelcomeUserController@welcome');

Route::get('/saludo/{name}/{nickname}', 'WelcomeUserController@greetingWithNickname');

Route::get('/saludo/{name}', 'WelcomeUserController@greetingWithoutNickname');

Route::get('/usuarios', 'UserController@index')
    ->name('users.index');

Route::get('/usuarios/nuevo', 'UserController@create')
    ->name('users.create');

Route::post('/usuarios', 'UserController@store');

Route::get('/usuarios/{user}', 'UserController@show')
    ->where('user', '\d+')
    ->name('users.show');

Route::put('/usuarios/{user}', 'UserController@update');

Route::get('/usuarios/{user}/editar', 'UserController@edit')
    ->where('id', '\d+')->name('users.edit');

Route::delete('/usuarios/{user}', 'UserController@destroy')
    ->name('users.destroy');
