<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\RobotController;
use App\Http\Controllers\DanceoffController;
use App\Http\Controllers\AuthenticationController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/login', [AuthenticationController::class, 'login']);
});

Route::group(['middleware' => 'jwt.verify', 'prefix' => 'teams'], function ($router) {
    Route::post('/', [TeamController::class, 'createTeam']);
    Route::post('/robot', [TeamController::class, 'addRobotToTeam']);
    Route::get('/robot/{team_id}', [TeamController::class, 'getTeamMembers']);
});

Route::group(['middleware' => 'jwt.verify', 'prefix' => 'robots'], function ($router) {
    Route::post('/', [RobotController::class, 'create']);
    Route::get('/{id}', [RobotController::class, 'getSingleRobot']);
    Route::get('/', [RobotController::class, 'getAllRobots']);
});

Route::group(['prefix' => 'danceoffs'], function ($router) {
    Route::post('/', [DanceoffController::class, 'create']);
});
