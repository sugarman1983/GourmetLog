<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('restaurants')->middleware(['auth'])->group(function () {
    Route::get( '/', [App\Http\Controllers\RestaurantController::class, 'index' ])->name( 'restaurants.index' );

    Route::get('/form', [App\Http\Controllers\RestaurantController::class, 'show'])->name('form.show');
    Route::post('/form', [App\Http\Controllers\RestaurantController::class, 'post'])->name('form.post');
    Route::post('/form/confirm', [App\Http\Controllers\RestaurantController::class, 'send'])->name('form.send');
    Route::get('/form/complete', [App\Http\Controllers\RestaurantController::class, 'complete'])->name('form.complete');

    Route::post('/delete/{id}', [App\Http\Controllers\RestaurantController::class, 'destroy'])->name('delete');
    
    Route::get('/detail/{id}', [App\Http\Controllers\RestaurantController::class, 'detail'])->name('detail');
    Route::post('/detail/{id}/comment', [App\Http\Controllers\CommentController::class, 'comment'])->name('comment');
    
    Route::get('/edit/{id}', [App\Http\Controllers\RestaurantController::class, 'call'])->name('edit.call');
    Route::post('/edit/{id}', [App\Http\Controllers\RestaurantController::class, 'update'])->name('edit.update');
    Route::post('/edit/{id}/confirm', [App\Http\Controllers\RestaurantController::class, 'upload'])->name('edit.upload');
    Route::get('/edit/{id}/complete', [App\Http\Controllers\RestaurantController::class, 'finish'])->name('edit.finish');
});

Route::prefix('categories')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\CategoryController::class, 'index'])->name( 'categories.index' );
    Route::get('/cat_add', [App\Http\Controllers\CategoryController::class, 'add']);
    Route::post('/cat_add', [App\Http\Controllers\CategoryController::class, 'add']);
    Route::post('/delete/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.delete');
    Route::get('/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name( 'categories.edit' );
    Route::post('/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit']);
});
