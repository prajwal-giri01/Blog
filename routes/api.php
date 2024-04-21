<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EmailVerficationController;

use App\Http\Controllers\PostController;
use App\Http\Controllers\TagsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user()->getRoleNames();
//})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

//Route::post('email/verification-notification', [EmailVerficationController::class, "sendVerificationEmail"])->middleware('auth:sanctum');
Route::group(['middleware'=> ['auth:sanctum','isAdmin']],function(){

    //category
    Route::post('category/create',[CategoryController::class, 'store'])->name('category.create');
    Route::PUT('category/{id}/edit',[CategoryController::class, 'update'])->name('category.update');
    Route::DELETE('category/{id}/delete',[CategoryController::class, 'destroy'])->name('category.destroy');

    //tags
    Route::post('tags/create',[TagsController::class, 'store'])->name('tags.create');
    Route::put('tags/{id}/edit',[TagsController::class, 'update'])->name('tags.update');
    Route::DELETE('tags/{id}/delete',[TagsController::class, 'destroy'])->name('tags.destroy');
});


Route::group(['middleware'=> 'auth:sanctum'],function(){
    //profile
    Route::post('/profile/update', [AuthController::class, 'update'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    //posts
    Route::post('post/create',[PostController::class, 'store'])->name('post.create');
    Route::put('post/{id}/edit',[PostController::class, 'update'])->name('post.update');
    Route::DELETE('post/{id}/delete',[PostController::class, 'destroy'])->name('post.destroy');

    //comment
    Route::post('post/create/{post_id}',[CommentController::class, 'store'])->name('post.create');
    Route::put('post/{id}/edit',[CommentController::class, 'update'])->name('post.update');
    Route::DELETE('post/{id}/delete',[CommentController::class, 'destroy'])->name('post.destroy');


});
