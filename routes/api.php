<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::namespace('API')->middleware('auth:api')->group(function ($request) {
    Route::get('users/me', function(Request $request) {
        return redirect('api/users/' . $request->user()->id);
    });

    Route::post('teams/{team}/members', 'TeamController@storeMember');
    Route::put('teams/{team}/members/{user}', 'TeamController@updateMember');
    Route::delete('teams/{team}/members/{user}', 'TeamController@destroyMember');

  Route::apiResource('users', 'UserController');
  Route::apiResource('teams', 'TeamController');
  Route::apiResource('shifts', 'ShiftController');
  Route::apiResource('locations', 'LocationController');
  Route::apiResource('additional-fields', 'AdditionalFieldController');
  Route::apiResource('donotdisturbs', 'DoNotDisturbController');
});
