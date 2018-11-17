<?php

Route::get('/', 'WelcomeUserController@welcome');

Route::get('/saludo/{name}/{nickname}', 'WelcomeUserController@greetingWithNickname');

Route::get('/saludo/{name}', 'WelcomeUserController@greetingWithoutNickname');

Route::get('/usuarios', 'UserController@index')
    ->name('users');

Route::get('/usuarios/nuevo', 'UserController@create')
    ->name('users.create');

Route::post('/usuarios', 'UserController@store');

Route::get('/usuarios/{user}', 'UserController@show')
    ->where('user', '\d+')
    ->name('users.show');

Route::get('/usuarios/{id}/edit', 'UserController@edit')
    ->where('id', '\d+');
