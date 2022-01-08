<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\BlockChainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [StaterkitController::class, 'home'])->name('home');
Route::post('login-web3', \App\Actions\LoginUsingWeb3::class);

Route::resource('/genre', GenreController::class);
Route::get('/genre/delete/{genre}', [GenreController::class, 'delete'])->name('genre.delete');

Route::resource('/blockchain', BlockChainController::class);
Route::get('/genre/blockchain/{blockchain}', [BlockChainController::class, 'delete'])->name('blockchain.delete');
Route::resource('/game', GameController::class);


// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->name('dashboard');



// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
