<?php

Route::group(['middleware' => 'cors', 'namespace' => '\Zhi20\Laravel\Core'], function () {
    Route::get('api/debug', 'Debuger@getLog');
});