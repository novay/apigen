<?php
Route::prefix('api/{tableName?}')->as('apigen::api.')->namespace('Novay\Apigen\Http\Controllers')->group(function() {
    Route::get('/', 'ApiController@index')->name('index');
    Route::post('/', 'ApiController@store')->name('store');
    Route::get('{params?}', 'ApiController@show')->name('show');
    Route::put('{params?}', 'ApiController@update')->name('update');
    Route::delete('{params?}', 'ApiController@destroy')->name('destroy');
});

Route::middleware('web')->namespace('Novay\Apigen\Http\Controllers')->as('apigen::')->group(function() {
    Route::middleware(['connect'])->group(function() {
        Route::get('/', 'IndexController@index')->name('index');
        Route::get('logout', 'IndexController@logout')->name('logout');
        Route::resource('settings', 'SettingController')->only(['index', 'store']);

        Route::resource('generate', 'GenerateController');

        Route::resource('datasets', 'DatasetController');
        Route::resource('endpoints', 'EndpointController');
    });

    Route::middleware(['disconnect'])->group(function() {
        Route::get('login', 'CheckController@login')->name('login');
        Route::post('login', 'CheckController@check');
    });
});