<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\UserController;
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

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/refresh', [AuthController::class, 'refresh']);
    Route::post('/questionnaire/{questionnaire}/answer', [QuestionnaireController::class, 'storeAnswer']);

    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', [AuthController::class, 'user']);
        Route::get('/responses/{id}', [ResponseController::class, 'getResponses']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::resource('/questionnaire', QuestionnaireController::class);
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });
});
//Route::post('/questionnaire/{questionnaire}/answer', [QuestionnaireController::class, 'storeAnswer']);

Route::group(['middleware' => 'auth:api'], function(){
    // Users
    Route::get('users', [UserController::class, 'index'])->middleware('isAdmin');
    Route::get('users/{id}', [UserController::class, 'show'])->middleware('isAdminOrSelf');
});
