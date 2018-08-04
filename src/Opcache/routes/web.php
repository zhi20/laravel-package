<?php

//Route::get('opcache/clear', '\Zhi20\Laravel\Opcache\Http\Controllers\OpcacheController@clear');

Route::group(['namespace' => '\Zhi20\Laravel\Opcache\Http\Controllers'], function () {
    Route::get('opcache/clear', 'OpcacheController@clear');
    Route::get('opcache/config', 'OpcacheController@config');
    Route::get('opcache/status', 'OpcacheController@status');
    Route::get('opcache/optimize', 'OpcacheController@optimize');
});