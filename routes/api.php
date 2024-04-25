<?php

use App\Http\Controllers\EpreuveController;
use App\Http\Controllers\LangueController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NiveauDeDifficulteController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReponseController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/login', function(){
    return response()->json([
        'success' => false,
        'reason' => "You're not authenticated",
    ], 401);
})->name('login');
Route::post('user/connexion', [UserController::class, 'connexion']);
Route::post('users', [UserController::class, 'store']);
Route::middleware('auth:sanctum')->group(function(){    
    Route::controller(UserController::class)->group(function(){
        Route::post('user/deconnexion', 'deconnexion');
        Route::get('user/students', 'all_student');
        Route::get('users', 'index');
        Route::get('users/{id}', 'show')->whereNumber('id');
        Route::put('users/{id}', 'update');
        Route::delete('users/{id}', 'destroy');
    });
    Route::apiResource('langues', LangueController::class);
    Route::apiResource('matieres', MatiereController::class);
    Route::apiResource('niveaux', NiveauDeDifficulteController::class);
    Route::apiResource('epreuves', EpreuveController::class);
    Route::get('epreuve/{id}/questions', [EpreuveController::class, 'questions']);

    //routes des questions
    Route::post('questions', [QuestionController::class, 'store']);
    Route::get('question/{id}/reponses', [QuestionController::class, 'reponses']);
    ROute::post('reponses', [ReponseController::class, 'store']);

});
Route::post('user/recuperation_de_mot_de_passe', [UserController::class ,'recuperation_de_mot_de_passe']);


