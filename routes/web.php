
<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlockChainController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PrivateSaleController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\UsefulController;
use App\Http\Controllers\UserController;
use App\Models\Game;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    // $coin = $client->coins()->getMarketChart('binancecoin', 'php', "max");
    $coin = $client->coins()->getCoin('axie-infinity',['tickers' => 'false']);
    dd($coin);
});
// End test


Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::post('login-web3', \App\Actions\LoginUsingWeb3::class);



Route::get('/game/screenshots/{review}', [GameController::class, 'screenshots'])->name('game.review.screenshots');
Route::get('/game/screenshot/{game}', [GameController::class, 'gameScreenshot'])->name('game.screenshots');
Route::get('/game/reviews/{game}', [GameController::class, 'reviews'])->name('game.reviews');
Route::get('/game/recent/', [GameController::class, 'recent'])->name('game.recent');
Route::get('/game/top/', [GameController::class, 'top'])->name('game.top');
Route::get('/game/gainer/', [GameController::class, 'gainer'])->name('game.gainer');
Route::get('/game/loser/', [GameController::class, 'loser'])->name('game.loser');
Route::get('/game/redflag/', [GameController::class, 'redflag'])->name('game.redflag');
Route::get('/game/rugpull/', [GameController::class, 'rugpull'])->name('game.rugpull');
Route::resource('/game', GameController::class)->except(['show']);
Route::get('/game/{game:slug}', [GameController::class, 'show'])->name('game.show');
Route::post('/game/getChart/{game}', [GameController::class, 'getChart'])->name('game.getChart');

// Route::resource('/game', GameController::class)->parameters(['game' => 'game:slug']);
Route::get('/blockchain/get/', [BlockChainController::class, 'get'])->name('blockchain.get');
Route::get('/genre/get/', [GenreController::class, 'get'])->name('genre.get');




Route::get('xchange', [ExchangeController::class, 'index'])->name('exchange.index');
Route::post('xchange/saveCart', [ExchangeController::class, 'saveCart'])->name('exchange.saveCart');
Route::group(['middleware' => ['auth']], function() {
    Route::get('xchange/checkout/', [ExchangeController::class, 'checkOut'])->name('exchange.checkOut');
});

Route::group(['prefix' => 'admin','middleware' => ['auth', 'admin']], function()
{

    Route::resource('/privateSale', PrivateSaleController::class);
    Route::get('/privateSale/delete/{privateSale}', [PrivateSaleController::class, 'delete'])->name('privateSale.delete');
    Route::post('/privateSale/default/{privateSale}', [PrivateSaleController::class, 'default'])->name('privateSale.default');

    Route::resource('/genre', GenreController::class);
    Route::get('/genre/delete/{genre}', [GenreController::class, 'delete'])->name('genre.delete');
    Route::resource('/blockchain', BlockChainController::class);
    Route::get('/blockchain/delete/{blockchain}', [BlockChainController::class, 'delete'])->name('blockchain.delete');

    Route::get('/game/delete/{game}', [GameController::class, 'delete'])->name('game.delete');
    Route::get('/game/approve/{game}', [GameController::class, 'approve'])->name('game.approve');
    Route::put('/game/approveGame/{game}', [GameController::class, 'approveGame'])->name('game.approveGame');

    Route::resource('/banner', BannerController::class);
    Route::get('/banner/delete/{banner}', [BannerController::class, 'delete'])->name('banner.delete');

    Route::resource('/coin', CoinController::class);
    Route::get('/coin/delete/{coin}', [CoinController::class, 'delete'])->name('coin.delete');
    Route::post('/coin/default/{coin}', [CoinController::class, 'default'])->name('coin.default');

    Route::resource('/paymentMethod', PaymentMethodController::class);
    Route::get('/paymentMethod/delete/{paymentMethod}', [PaymentMethodController::class, 'delete'])->name('paymentMethod.delete');
    Route::post('/paymentMethod/default/{paymentMethod}', [PaymentMethodController::class, 'default'])->name('paymentMethod.default');

    Route::resource('/systemSetting', SystemSettingController::class);
    Route::get('/review', [ReviewController::class ,'index'])->name('review.index');
    Route::get('/review/{review}', [ReviewController::class ,'show'])->name('review.show');
    Route::post('/review/approve/{review}', [ReviewController::class ,'approve'])->name('review.approve');
    Route::delete('/review/{review}', [ReviewController::class ,'destroy'])->name('review.destroy');
    Route::get('/review/delete/{review}', [ReviewController::class ,'delete'])->name('review.delete');

});

Route::group(['middleware' => ['auth']], function()
{
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/review', [ReviewController::class ,'store'])->name('review.store');
    Route::get('profile/settings/', [UserController::class, 'settings'])->name('profile.settings');
    Route::post('profile/update/{type}', [UserController::class, 'update'])->name('profile.update');
    Route::resource('/order', OrderController::class);
    Route::get('order/paymentproof/{order}', [OrderController::class, 'getPaymentProof'])->name('order.getPaymentProof');
    Route::post('order/confirmReceipt/{order}', [OrderController::class, 'confirmReceipt'])->name('order.confirmReceipt')->middleware('admin');
    Route::post('order/cancel/{order}', [OrderController::class, 'cancel'])->name('order.cancel')->middleware('admin');
    Route::get('/order/delete/{order}', [OrderController::class, 'delete'])->name('order.delete')->middleware('admin');
    Route::post('/useful/{review}', [UsefulController::class, 'useful'])->name('useful.useful');
    Route::get('/pte/', [PrivateSaleController::class, 'create'])->name('privateSale.add');
    Route::post('/pte/', [PrivateSaleController::class, 'store'])->name('privateSale.submit');
    Route::get('game/show/{game}', [GameController::class, 'show'])->name('game.show.login');
});
Route::get('profile/{user}/', [UserController::class, 'profile'])->name('user.profile');


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


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');