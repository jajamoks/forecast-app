<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::group(['middleware' => ['latlonval']], function () {
    Route::get('future', 'ApiController@forecastFuture');
    Route::get('history', 'ApiController@forecastHistory');
    Route::get('today', 'ApiController@forecastToday');
});

