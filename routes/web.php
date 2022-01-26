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
use App\Http\Controllers\BannerController;

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
// Test
// Route::get('/test', function(){
//     $client = new CoinGeckoClient();
//     $coin = $client->coins()->getMarketChart('smooth-love-potion', 'usd', "1");
//     dd($coin);
// });

Route::get('/test', function(){
    $client = new CoinGeckoClient();
    $coin = $client->coins()->getCoin('smooth-love-potion',['tickers' => 'false']);
    dd($coin);
});
// End test


Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::post('login-web3', \App\Actions\LoginUsingWeb3::class);



Route::get('/game/screenshots/{review}', [GameController::class, 'screenshots'])->name('game.review.screenshots');
Route::get('/game/reviews/{game}', [GameController::class, 'reviews'])->name('game.reviews');
Route::get('/game/recent/', [GameController::class, 'recent'])->name('game.recent');
Route::get('/game/top/', [GameController::class, 'top'])->name('game.top');
Route::get('/game/gainer/', [GameController::class, 'gainer'])->name('game.gainer');
Route::get('/game/loser/', [GameController::class, 'loser'])->name('game.loser');
Route::get('/game/redflag/', [GameController::class, 'redflag'])->name('game.redflag');
Route::get('/game/rugpull/', [GameController::class, 'rugpull'])->name('game.rugpull');
Route::resource('/game', GameController::class);

Route::get('/blockchain/get/', [BlockChainController::class, 'get'])->name('blockchain.get');
Route::get('/genre/get/', [GenreController::class, 'get'])->name('genre.get');

Route::group(['middleware' => ['auth', 'admin']], function()
{
    Route::resource('/genre', GenreController::class);
    Route::get('/genre/delete/{genre}', [GenreController::class, 'delete'])->name('genre.delete');
    Route::resource('/blockchain', BlockChainController::class);
    Route::get('/blockchain/delete/{blockchain}', [BlockChainController::class, 'delete'])->name('blockchain.delete');

    Route::get('/game/delete/{game}', [GameController::class, 'delete'])->name('game.delete');
    Route::get('/game/approve/{game}', [GameController::class, 'approve'])->name('game.approve');
    Route::put('/game/approveGame/{game}', [GameController::class, 'approveGame'])->name('game.approveGame');

    Route::resource('/banner', BannerController::class);
    Route::get('/banner/delete/{banner}', [BannerController::class, 'delete'])->name('banner.delete');
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
