<?php

use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EpreuveController;
use App\Http\Controllers\EpreuvePdfController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\LangueController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NiveauDeDifficulteController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReponseController;
use App\Http\Controllers\UniversiteController;
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

Route::get('/admin_route', function(){
    return response()->json([
        'success' => false,
        'reason' => "You're not admin",
    ], 403);
})->name('isAdminRoute');


Route::post('user/connexion', [UserController::class, 'connexion']);

Route::post('users', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function(){
    Route::controller(UserController::class)->group(function(){
        Route::post('user/deconnexion', 'deconnexion');
        Route::get('user/students', 'all_student')->middleware('isAdmin');
        // Route::get('users', 'index');
        Route::get('users/{id}', 'show')->whereNumber('id');
        Route::put('users/{id}', 'update');
        Route::delete('users/{id}', 'destroy')->middleware('isAdmin');
        Route::get('/user', 'getAuthUser');
    });
    Route::apiResource('langues', LangueController::class);
    Route::apiResource('matieres', MatiereController::class);

    Route::apiResource('epreuves', EpreuveController::class);
    Route::get('epreuve/{id}/questions', [EpreuveController::class, 'questions']);
    Route::post('create_qcm', [EpreuveController::class, 'store_qcm']);
    Route::put('update_qcm/{id}', [EpreuveController::class, 'update_qcm']);

    //routes des questions
    Route::post('questions', [QuestionController::class, 'store']);
    Route::get('question/{id}/reponses', [QuestionController::class, 'reponses']);
    Route::post('reponses', [ReponseController::class, 'store']);

    // routes des classes
    Route::get('/classes', [ClasseController::class, 'index'])->middleware('isAdmin');
    Route::post('/classes', [ClasseController::class, 'store'])->middleware('isAdmin');
    Route::delete('/classes/{classe}', [ClasseController::class, 'destroy'])->middleware('isAdmin');
    Route::get('/classes/{classe}', [ClasseController::class, 'show'])->middleware('isAdmin');
    Route::put('/classes/{classe}', [ClasseController::class, 'update'])->middleware('isAdmin');

    //Routes des universités
    Route::apiResource('/universites', UniversiteController::class)->middleware('isAdmin');
    //Route des filieres
    //Routes des pdfs
    Route::get('/epreuvePdfs', [EpreuvePdfController::class, 'index']);
    Route::get('/epreuvePdfs/{epreuvePdf}', [EpreuvePdfController::class, 'show']);
    Route::post('/epreuvePdfs', [EpreuvePdfController::class, 'store']);

});
Route::post('user/recuperation_de_mot_de_passe', [UserController::class ,'recuperation_de_mot_de_passe']);
Route::apiResource('/filieres', FiliereController::class);
//->middleware('isAdmin');
Route::apiResource('niveaux', NiveauDeDifficulteController::class);


