<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// my routeservicecprovider.php holds const HOME = '/home' and home is no longer available. why is it not returning error? because of the middleware? 
Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [PostController::class, 'index'])->name('index');
    // Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
    Route::group(['prefix' => 'post', 'as' => 'post.'], function() {
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{id}', [PostController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [PostController::class, 'update'])->name('update');
        Route::delete('/{id}/destroy', [PostController::class, 'destroy'])->name('destroy');
    });

    // Comment routes
    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function() {
        // Store a new comment
        Route::post('/{post_id}/store', [CommentController::class, 'store'])->name('store');
        // delete a single comment
        Route::delete('/{id}/destroy', [CommentController::class, 'destroy'])->name('destroy');
        // update a single comment
        Route::patch('/{id}/update', [CommentController::class, 'update'])->name('update');
    } );

    // User routes
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function() {
        // show a single user
        Route::get('/', [UserController::class, 'show'])->name('show');
        // edit a single user
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        // update a single user
        Route::patch('/update', [UserController::class, 'update'])->name('update');
        // delete a single user
        // Route::delete('/{id}/destroy', [UserController::class, 'destroy'])->name('destroy');
    } );
});
