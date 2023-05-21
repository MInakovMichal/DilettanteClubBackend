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

    Route::group(["prefix" => '/punishments',], static function () {
        Route::get('/', [PunishmentController::class, 'getAllPunishments'])->name('user.punishments.all');
        Route::post('/add', [PunishmentController::class, 'addPunishment'])->name('user.punishments.add');
        Route::delete('/delete', [PunishmentController::class, 'deletePunishment'])->name('user.punishments.delete');
        Route::put('/update', [PunishmentController::class, 'updatePunishment'])->name('user.punishments.update');
    });

    Route::group(["prefix" => '/rooms',], static function () {
        Route::get('/public', [RoomController::class, 'getAllPublicRooms'])->name('user.rooms.public.all');

        Route::post('/create', [RoomController::class, 'createRoom'])->name('user.rooms.create');
        Route::delete('/close', [RoomController::class, 'closeRoom'])->name('user.rooms.close');

        Route::post('/add-questions', [RoomController::class, 'addQuestionsToRoom'])->name('user.rooms.questions.add');
        Route::delete('/delete-questions', [RoomController::class, 'deleteQuestionsFromRoom'])->name('user.rooms.questions.delete');

        Route::post('/add-punishments', [RoomController::class, 'addPunishmentsToRoom'])->name('user.rooms.punishments.add');
        Route::delete('/delete-punishments', [RoomController::class, 'deletePunishmentsFromRoom'])->name('user.rooms.punishments.delete');

        Route::post('/enter', [RoomController::class, 'userEnterRoom'])->name('user.rooms.users.enter');
        Route::post('/leave', [RoomController::class, 'userLeaveRoom'])->name('user.rooms.users.leave');
    });
});
