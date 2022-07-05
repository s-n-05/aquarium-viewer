<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [PostController::class, 'index']);

Route::get('/random', [PostController::class, 'random']);
Route::get('/hashtag/{hashtag}', [PostController::class, 'hashtag']);
Route::get('/random/hashtag/{hashtag}', [PostController::class, 'hashtag_random']);
Route::get('/user/{twitter_username}', [PostController::class, 'user']);
Route::post('/tweetinquiry', [PostController::class, 'send_inquiry']);

Auth::routes();

