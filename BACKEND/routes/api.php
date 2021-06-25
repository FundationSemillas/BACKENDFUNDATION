<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VolunteerEventsController;
use App\Http\Controllers\SponsorsController;
use App\Http\Controllers\SponsorsEventsController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\VolunteersController;

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

//Route::get('/', '\App\Http\Controllers\UserController@index');

//Rutas de Authenticacion y recuperación de contraseña
Route::post('/login', '\App\Http\Controllers\AuthController@login');

Route::get('/user', '\App\Http\Controllers\AuthController@user')->middleware('auth:api');

Route::post('/register', '\App\Http\Controllers\AuthController@register');

Route::post('/forgot', '\App\Http\Controllers\ForgotController@forgot');

Route::post('/reset', '\App\Http\Controllers\ForgotController@reset');

//Rutas en general del servidor get-post-put-delete
Route::apiResource('child',ChildrenController::class);

Route::apiResource('blog',BlogController::class);

Route::apiResource('event',EventsController::class);

Route::apiResource('volunteer',VolunteersController::class);

Route::apiResource('image',ImageController::class);

Route::apiResource('VolunteerEvents',VolunteerEventsController::class);

Route::apiResource('sponsor',SponsorsController::class);

Route::apiResource('sponsorEvents',SponsorsEventsController::class);

Route::apiResource('album',AlbumController::class);

Route::get('/artisan/storage', function() {
    $command = 'storage:link';
    $result = Artisan::call($command);
    return Artisan::output();
});



