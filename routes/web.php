<?php

use Illuminate\Http\Request;

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

Route::get('/', function () {
    return redirect('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/calendar/{user}.ics', 'CalendarController@show');

Route::middleware('auth')->group(function() {
    Route::prefix('/user')->group(function() {
        Route::view('/donotdisturb', 'user.donotdisturb')->name('user.donotdisturb');
    });

    Route::prefix('/teams')->group(function() {
        Route::view('/', 'teams.index')->name('teams.view');
    });

    Route::prefix('/admin')->group(function() {
        Route::get('/', function(Request $request) {
            if (!$request->user()->is_super) {
                return response('Forbidden', 403);
            }

            return view('admin');
        });
    });
});
