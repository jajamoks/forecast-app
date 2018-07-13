<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/**
 * We don't have front-end controller (because of vuejs) so we only
 * need to render the home view to include the javascript components
 */
Route::get('/{vue_capture?}', function () {
    return view('home');
})->where('vue_capture', '[\/\w\.-]*');
