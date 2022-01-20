<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\BlockChainController;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use App\Models\Game;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;

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

// Route::get('/', function(){
//     $client = new CoinGeckoClient();
//     $coin = $client->coins()->getMarketChart('smooth-love-potion', 'usd', "1");
//     dd($coin);
// });


Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::post('login-web3', \App\Actions\LoginUsingWeb3::class);


Route::resource('/game', GameController::class);
Route::get('/game/screenshots/{review}', [GameController::class, 'screenshots'])->name('game.review.screenshots');

Route::group(['middleware' => ['auth', 'admin']], function()
{
    Route::resource('/genre', GenreController::class);
    Route::get('/genre/delete/{genre}', [GenreController::class, 'delete'])->name('genre.delete');
    Route::resource('/blockchain', BlockChainController::class);
    Route::get('/blockchain/delete/{blockchain}', [BlockChainController::class, 'delete'])->name('blockchain.delete');

    Route::get('/game/delete/{game}', [GameController::class, 'delete'])->name('game.delete');
    Route::get('/game/approve/{game}', [GameController::class, 'approve'])->name('game.approve');
    Route::put('/game/approveGame/{game}', [GameController::class, 'approveGame'])->name('game.approveGame');
});

Route::group(['middleware' => ['auth']], function()
{
    Route::post('/review', [ReviewController::class ,'store'])->name('review.store');
    Route::get('profile/settings/', [UserController::class, 'settings'])->name('profile.settings');
});


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
