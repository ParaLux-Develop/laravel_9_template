<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/**
 * ツイート管理
 */
Route::group(['prefix' => 'tweet', 'controller' => TweetController::class], function () {
    Route::get('/',                 'index')->name('tweet.index')->middleware('auth');
  
    Route::middleware('auth')->group(function (){
      Route::get('/create',           'create')->name('tweet.create');
      Route::post('/store',           'store')
      ->middleware('auth')
      ->name('tweet.store');
      Route::get('/{tweetId}',          'show')->name('tweet.show');
    
      Route::get('/{tweetId}/edit',     'edit')->name('tweet.edit'); 
      // 編集ページ
    
      // Route::get('{tweetId}/update',  'update')->name('tweet.update.index');
      Route::put('/{tweetId}/update',  'update')->name('tweet.update');
    
      // Route::get('/{tweetId}/update',  'update')->name('tweet.update');
      // Route::put('/{tweetId}/update',  'update')->name('tweet.update');
      // putに変えた
      Route::post('/{tweetId}/destroy', 'destroy')->name('tweet.destroy');
      //削除機能
    });
  });

// Route::get('/', function () {
//     $user = User::first();

//     Mail::send(new ContactMail($user));

//     return view('welcome');
// });