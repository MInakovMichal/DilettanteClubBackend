<?php

use Common\Auth\Infrastructure\Http\Controller\LoginController;
use Common\Auth\Infrastructure\Http\Controller\RegisterController;
use Component\Punishment\Infrastructure\Http\Controller\PunishmentController;
use Component\Question\Infrastructure\Http\Controller\QuestionController;
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

Route::post('/auth/register', [RegisterController::class, 'register'])->name('user.register');
Route::post('/auth/login', [LoginController::class, 'login'])->name('user.login');

Route::group(["middleware" => ["auth:api"],], static function () {
    Route::group(["prefix" => '/questions',], static function () {
        Route::get('/', [QuestionController::class, 'getAllQuestions'])->name('user.questions');
        Route::post('/add', [QuestionController::class, 'addQuestion'])->name('user.questions.add');
    });

    Route::group(["prefix" => '/punishment',], static function () {
        Route::get('/', [PunishmentController::class, 'getAllPunishments'])->name('user.punishments');
        Route::post('/add', [PunishmentController::class, 'addPunishment'])->name('user.punishments.add');
    });
});
