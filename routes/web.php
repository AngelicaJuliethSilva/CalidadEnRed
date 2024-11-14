<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\EvaluationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
Route::post('/forum/{topic}/reply', [ForumController::class, 'storeReply'])->name('forum.reply.store');
Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
Route::post('/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');