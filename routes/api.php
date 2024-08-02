<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CompetitorController;
use App\Http\Controllers\DayuserController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\WorkingDayController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ROUTES AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/loginUser', [AuthController::class, 'loginUser']);
Route::post('/datauser', [AuthController::class, 'dataUser'])->middleware('auth:sanctum');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/send-mail', [AuthController::class, 'sendEmail']);

// ROUTES SPORTS
Route::get('/sports', [SportController::class, 'index']);
Route::get('/sports/{id}/detail', [SportController::class, 'detail']);
Route::post('/sports', [SportController::class, 'create']);
Route::put('/sports', [SportController::class, 'update']);
Route::delete('/sports/{id}', [SportController::class, 'delete']);

// ROUTES SEASONS
Route::get('/seasons/{id}', [SeasonController::class, 'index']);
Route::get('/seasons/{id}/detail', [SeasonController::class, 'detail']);
Route::post('/seasons', [SeasonController::class, 'create']);
Route::put('/seasons', [SeasonController::class, 'update']);
Route::delete('/seasons/{id}', [SeasonController::class, 'delete']);


// ROUTES WORKING-DAY
Route::get('/working/{id}', [WorkingDayController::class, 'index']);
Route::get('/working/{id}/detail', [WorkingDayController::class, 'detail']);
Route::post('/working', [WorkingDayController::class, 'create']);
Route::put('/working', [WorkingDayController::class, 'update']);
Route::delete('/working/{id}', [WorkingDayController::class, 'delete']);

// ROUTES GAME
Route::get('/game/{id}', [GameController::class, 'index']);
Route::get('/game/{id}/detail', [GameController::class, 'detail']);
Route::post('/game', [GameController::class, 'create']);
Route::put('/game', [GameController::class, 'update']);
Route::delete('/game/{id}', [GameController::class, 'delete']);
Route::post('/game/updateMarker', [GameController::class, 'updateMarker']);


// ROUTES CLUB
Route::get('/club/{id}', [ClubController::class, 'index']);
Route::get('/club/{id}/detail', [ClubController::class, 'detail']);
Route::post('/club', [ClubController::class, 'create']);
Route::put('/club', [ClubController::class, 'update']);
Route::delete('/club/{id}', [ClubController::class, 'delete']);



// ROUTES COMPETITOR
Route::get('/competitor', [CompetitorController::class, 'index']);
Route::get('/competitor/{id}/detail', [CompetitorController::class, 'detail']);
Route::post('/competitor', [CompetitorController::class, 'create']);
Route::put('/competitor', [CompetitorController::class, 'update']);
Route::delete('/competitor/{id}', [CompetitorController::class, 'delete']);


// ROUTES BANNERS
Route::get('/banner', [BannerController::class, 'index']);
Route::get('/banner/{id}/detail', [BannerController::class, 'detail']);
Route::post('/banner', [BannerController::class, 'create']);
Route::put('/banner', [BannerController::class, 'update']);
Route::delete('/banner/{id}', [BannerController::class, 'delete']);

// ROUTES BANNERS
Route::get('/day/user/{journey_id}/{season_id}', [DayuserController::class, 'index']);
Route::put('/day/update', [DayuserController::class, 'update']);


// ROUTRES FRONT
Route::get('/front/season/{id}', [FrontController::class, 'index']);
Route::get('/front/test', [FrontController::class, 'createOppwaCheckout']);
Route::post('/front/createUserDay', [FrontController::class, 'createUserDay']);
Route::get('/front/getGames/{id}', [FrontController::class, 'getGames']);
Route::get('/front/detalles/{id}/{seasonId}', [FrontController::class, 'getDetalles']);
Route::get('/front/rankings/{journeyId}', [FrontController::class, 'getRankings']);
// ROUTES GROUP
// Route::get('/get-groups', [GroupController::class, 'getGroups']);
// Route::get('/getGroupFilter', [GroupController::class, 'getGroupFilter']);
// Route::post('/create-group', [GroupController::class, 'createGroup']);
// Route::get('/grupo/delete', [GroupController::class, 'delete']);
// Route::get('/grupo/getById', [GroupController::class, 'getById']);
// Route::post('/grupo/update', [GroupController::class, 'update']);
