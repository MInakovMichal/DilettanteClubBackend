<?php

use Common\Auth\Infrastructure\Http\Controller\LoginController;
use Common\Auth\Infrastructure\Http\Controller\RegisterController;
use Component\Punishment\Infrastructure\Http\Controller\PunishmentController;
use Component\Question\Infrastructure\Http\Controller\QuestionController;
use Component\Room\Infrastructure\Http\Controller\RoomController;
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
        Route::get('/', [QuestionController::class, 'getAllQuestions'])->name('user.questions.all');
        Route::post('/add', [QuestionController::class, 'addQuestion'])->name('user.questions.add');
        Route::delete('/delete', [QuestionController::class, 'deleteQuestion'])->name('user.questions.delete');
        Route::put('/update', [QuestionController::class, 'updateQuestion'])->name('user.questions.update');
    });

    Route::group(["prefix" => '/punishment',], static function () {
        Route::get('/', [PunishmentController::class, 'getAllPunishments'])->name('user.punishments.all');
        Route::post('/add', [PunishmentController::class, 'addPunishment'])->name('user.punishments.add');
        Route::delete('/delete', [PunishmentController::class, 'deletePunishment'])->name('user.punishments.delete');
        Route::put('/update', [PunishmentController::class, 'updatePunishment'])->name('user.punishments.update');
    });

    Route::group(["prefix" => '/punishment',], static function () {
//        Route::get('/', [PunishmentController::class, 'getAllPunishments'])->name('user.punishments');
        Route::post('/create', [RoomController::class, 'createRoom'])->name('user.room.create');
        Route::post('/addQuestions', [RoomController::class, 'addQuestionsToRoom'])->name('user.room.addQuestions');
        Route::post('/addPunishments', [RoomController::class, 'addPunishmentsToRoom'])->name('user.room.addPunishments');
        Route::post('/usersInRoom', [RoomController::class, 'userEnterRoom'])->name('user.room.usersInRoom');
//        Route::delete('/delete', [PunishmentController::class, 'deletePunishment'])->name('user.punishments.delete');
//        Route::put('/update', [PunishmentController::class, 'updatePunishment'])->name('user.punishments.update');
    });
});
