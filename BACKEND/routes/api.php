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
use App\Http\Controllers\RolsController;
use App\Http\Controllers\VolunteersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZonesController;
use App\Models\Images;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
Route::post('login', '\App\Http\Controllers\AuthController@login');

//Route::get('user', '\App\Http\Controllers\AuthController@user')->middleware('auth:api');

Route::post('register', '\App\Http\Controllers\AuthController@register');


Route::group(['middleware' => 'auth:api'], function () {
    //roles
    Route::post('rol/create', [RolsController::class, 'store']);
    Route::delete('rol/delete/{id}', [RolsController::class, 'destroy']);
    Route::put('rol/update', [RolsController::class, 'update']);
    
    //zonas
    Route::post('zone/create', [ZonesController::class, 'store']);
    Route::delete('zone/delete/{id}', [ZonesController::class, 'destroy']);
    Route::put('zone/update', [ZonesController::class, 'update']);
    
    //niños
    Route::get('child', [ChildrenController::class, 'index']);
    Route::get('child/findById/{id}', [ChildrenController::class, 'show']);
    Route::post('child/create', [ChildrenController::class, 'store']);
    Route::delete('child/delete/{id}', [ChildrenController::class, 'destroy']);
    Route::put('child/update', [ChildrenController::class, 'update']);
    
    //blogs
    Route::post('blog/create', [BlogController::class, 'store']);
    Route::delete('blog/delete/{id}', [BlogController::class, 'destroy']);
    Route::put('blog/update', [BlogController::class, 'update']);
    
    //eventos
    Route::post('event/create', [EventsController::class, 'store']);
    Route::delete('event/delete/{id}', [EventsController::class, 'destroy']);
    Route::put('event/update', [EventsController::class, 'update']);
    
    //voluntarios
    Route::get('volunteer', [VolunteersController::class, 'index']);
    Route::get('volunteer/findById/{id}', [VolunteersController::class, 'show']);
    Route::post('volunteer/create', [VolunteersController::class, 'store']);
    Route::delete('volunteer/delete/{id}', [VolunteersController::class, 'destroy']);
    Route::put('volunteer/update', [VolunteersController::class, 'update']);
    
    //imagenes
    Route::post('image/create', [ImageController::class, 'store']);
    Route::delete('image/delete/{id}', [ImageController::class, 'destroy']);
    Route::put('image/update', [ImageController::class, 'update']);
    
    //eventosVoluntarios
    Route::get('volunteerEvent', [VolunteerEventsController::class, 'index']);
    Route::get('volunteerEvent/findById/{id}', [VolunteerEventsController::class, 'show']);
    Route::get('volunteerEvent/getByVolunteer/{id}', [VolunteerEventsController::class], 'byVolunteer');
    Route::get('volunteerEvent/getByEvent/{id}', [VolunteerEventsController::class], 'byEvent');    
    Route::post('volunteerEvent/create', [VolunteerEventsController::class, 'store']);
    Route::delete('volunteerEvent/delete/{id}', [VolunteerEventsController::class, 'destroy']);
    Route::put('volunteerEvent/update', [VolunteerEventsController::class, 'update']);
    
    //patrocinadores
    Route::post('sponsor/create', [SponsorsController::class, 'store']);
    Route::delete('sponsor/delete/{id}', [SponsorsController::class, 'destroy']);
    Route::put('sponsor/update', [SponsorsController::class, 'update']);
    
    //eventosPatrocinadores
    Route::get('sponsorEvent', [SponsorsEventsController::class, 'index']);
    Route::get('sponsorEvent/findById/{id}', [SponsorsEventsController::class, 'show']);
    Route::get('sponsorEvent/getBySponsor/{id}', [SponsorsEventsController::class], 'bySponsor');
    Route::get('sponsorEvent/getByEvent/{id}', [SponsorsEventsController::class], 'byEvent');
    Route::post('sponsorEvent/create', [SponsorsEventsController::class, 'store']);
    Route::delete('sponsorEvent/delete/{id}', [SponsorsEventsController::class, 'destroy']);
    Route::put('sponsorEvent/update', [SponsorsEventsController::class, 'update']);
    
    //albumes
    Route::post('album/create', [AlbumController::class, 'store']);
    Route::delete('album/delete/{id}', [AlbumController::class, 'destroy']);
    Route::put('album/update', [AlbumController::class, 'update']);
});

//roles
Route::get('rol', [RolsController::class, 'index']);
Route::get('rol/findById/{id}', [RolsController::class, 'show']);

//zonas
Route::get('zone', [ZonesController::class, 'index']);
Route::get('zone/findById/{id}', [ZonesController::class, 'show']);

//blogs
Route::get('blog', [BlogController::class, 'index']);
Route::get('blog/findById/{id}', [BlogController::class, 'show']);

//eventos
Route::get('event', [EventsController::class, 'index']);
Route::get('event/findById/{id}', [EventsController::class, 'show']);

//imagenes
Route::get('image', [ImageController::class, 'index']);
Route::get('image/findById/{id}', [ImageController::class, 'show']);

//patrocinadores
Route::get('sponsor', [SponsorsController::class, 'index']);
Route::get('sponsor/findById/{id}', [SponsorsController::class, 'show']);

//albumes
Route::get('album', [AlbumController::class, 'index']);
Route::get('album/findById/{id}', [AlbumController::class, 'show']);

Route::get('/artisan/storage', function () {
    $command = 'storage:link';
    $result = Artisan::call($command);
    return Artisan::output();
});

Route::delete('/image/id/{id}', function ($id) {
    DB::table('images')->where('id', $id)->delete();
    return response()->json(['message' => 'imagen quitada'], 200);
});

Route::get('/filterYear/{year}', function ($year) {
    $data = DB::table('albums')->whereYear('date', '=', $year)->get();
    return response()->json(
        $data
    );
});
