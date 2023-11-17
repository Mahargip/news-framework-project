<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthenticationController;

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
    return view('welcome');
});

Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/posts2/{id}', [PostController::class, 'show2']);
    Route::get('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/me', [AuthenticationController::class, 'me']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::patch('/posts/{id}', [PostController::class, 'update'])->middleware('post-user');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->middleware('post-user');

    Route::post('/comment', [CommentController::class, 'store']);
    Route::patch('/comment/{id}', [CommentController::class, 'update'])->middleware('comment-user');
    Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->middleware('comment-user');
});

Route::get('/dashboard', [PostController::class, 'indexView'])->name('dashboard');

Route::get('/', [PostController::class, 'indexView']);
Route::get('/posts/{id}', [PostController::class, 'show'])->name('post.show');
Route::get('/posts/{id}', [PostController::class, 'showView'])->name('post.show');
Route::post('/login', [AuthenticationController::class, 'login']);


require __DIR__.'/auth.php';
