<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TaskController;
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

Route::get('/', [PostsController::class, 'index'])->name('posts.index');
Route::get('post/{id}', [PostsController::class, 'showPost'])->name('posts.show');
Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('dashboard/posts', [DashboardController::class, 'posts'])->middleware(['auth'])->name('dashboard.posts');
Route::get('dashboard/posts/create/{id}', [DashboardController::class, 'createPost'])->middleware(['auth'])->name('dashboard.posts.create');
Route::post('dashboard/posts/store', [DashboardController::class, 'storePost'])->middleware(['auth'])->name('dashboard.posts.store');
Route::post('dashboard/posts/update', [DashboardController::class, 'updatePost'])->middleware(['auth'])->name('dashboard.posts.update');
Route::delete('dashboard/posts/delete', [DashboardController::class, 'deletePost'])->middleware(['auth'])->name('dashboard.posts.delete');

Route::get('dashboard/users', [DashboardController::class, 'users'])->middleware(['auth'])->name('dashboard.users');



// Route::get('/', function () {
//     return view('welcome');
// })->middleware(['auth'])->name('welcome');


// Route::get('/tasks',[TaskController::class,'index'])->middleware(['auth'])->name('tasks.index');
// Route::get('/tasks/show/{id}',[TaskController::class,'show'])->middleware(['auth'])->name('tasks.show');
// Route::get('/tasks/edit/{id}',[TaskController::class,'edit'])->middleware(['auth'])->name('tasks.edit');
// Route::post('/tasks/destroy/{id}',[TaskController::class,'destroy'])->middleware(['auth'])->name('tasks.destroy');
// Route::post('/tasks/update/{id}',[TaskController::class,'update'])->middleware(['auth'])->name('tasks.update');


// Route::post('/tasks/store',[TaskController::class,'store'])->middleware(['auth'])->name('tasks.store');

require __DIR__ . '/auth.php';
