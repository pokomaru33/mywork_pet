<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StripeController;

use App\Http\Livewire\Input;
use App\Http\Livewire\Confirm;
use App\Http\Livewire\Complete;

use App\Http\Controllers\AlldataController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\WeightController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\DateController;
use App\Http\Controllers\FoodController;

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


// ソーシャル・ログイン
Route::prefix('login/{provider}')->where(['provider' => '(line|github)'])->group(function () {

    Route::get('/', 'App\Http\Controllers\Auth\LoginController@redirectToProvider')->name('social_login.redirect');
    Route::get('/callback', 'App\Http\Controllers\Auth\LoginController@handleProviderCallback')->name('social_login.callback');
});


Route::prefix('json')->group(function () {

    Route::get('/alldata', [AlldataController::class, 'index'])->name('json_alldata');
    Route::post('/alldata', [AlldataController::class, 'store']);

    Route::get('/pets', [AnimalController::class, 'index'])->name('json_animals');
    Route::post('/pets/{animal}', [AnimalController::class, 'update']);
    Route::delete('/pets/{animal}', [AnimalController::class, 'destroy']);

    Route::get('/foods', [FoodController::class, 'index'])->name('json_foods');
    Route::post('/foods', [FoodController::class, 'store']);
    Route::post('/foods/{food}', [FoodController::class, 'destroy']);

    Route::get('/weight/{weight}', [WeightController::class, 'show']);
    Route::post('/weight/{weight}', [WeightController::class, 'update']);
    Route::delete('/weight/{weight}', [WeightController::class, 'destroy']);
    Route::get('/note/{note}', [NoteController::class, 'show']);
    Route::post('/note/{note}', [NoteController::class, 'update']);
    Route::delete('/note/{note}', [NoteController::class, 'destroy']);

    Route::post('/date_n_title', [DateController::class, 'destroy']);
});

//stripe
Route::middleware(['auth:sanctum', 'verified'])->get('/donation', [StripeController::class, 'stripe']);
Route::middleware(['auth:sanctum', 'verified'])->post('/donation', [StripeController::class, 'stripeCharge'])->name('stripe.charge');
Route::middleware(['auth:sanctum', 'verified'])->get('/donation/complete', [StripeController::class, 'stripeComplite'])->name('stripe.complete');


//お問い合わせ
Route::middleware(['auth:sanctum', 'verified'])->get('/contact/input', Input::class)->name('contact_input');
Route::middleware(['auth:sanctum', 'verified'])->get('/contact/confirm', Confirm::class)->name('contact_confirm');
Route::middleware(['auth:sanctum', 'verified'])->get('/contact/complete', Complete::class)->name('contact_complete');

//リダイレクト
Route::middleware(['auth:sanctum', 'verified'])->get('/js/v-calendar.umd.min.js.map', function () {
    return redirect('/top');
});
Route::middleware(['auth:sanctum', 'verified'])->get('/js/vueLoading.common.js.map', function () {
    return redirect('/top');
});
Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return redirect('/top');
});

//router-vue
Route::middleware(['auth:sanctum', 'verified'])->get('/{any}', function () {
    return view('main');
})->where('any', '.*');
