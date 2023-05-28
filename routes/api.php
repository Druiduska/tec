<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', ['\App\Http\Controllers\Auth\AuthController', 'login'])->name('login');
    Route::post('registration', ['\App\Http\Controllers\Auth\AuthController', 'registration']);
    Route::post('logout', ['\App\Http\Controllers\Auth\AuthController', 'logout']);
    Route::post('refresh', ['\App\Http\Controllers\Auth\AuthController', 'refresh']);
    Route::post('me', ['\App\Http\Controllers\Auth\AuthController', 'me']);
    Route::delete('delete', ['\App\Http\Controllers\Auth\AuthController', 'delete']);

    Route::post('set-login/{id}', ['\App\Http\Controllers\Auth\AccessController', 'setLogin']);
    Route::post('set-last-access/{id}', ['\App\Http\Controllers\Auth\AccessController', 'setAccess']);
});

Route::group([
    'prefix' => 'staff'
], function () {
    Route::get('/', ['\App\Http\Controllers\Staff\StaffController', 'index']);
    Route::post('/load-csv', ['\App\Http\Controllers\Staff\StaffController', 'loadCSV']);
    Route::get('/reports/working-time', ['\App\Http\Controllers\Staff\Reports\WorkingTimeController', 'byWeek']);
});



