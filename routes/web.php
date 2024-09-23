<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('books/bookdetail/{id}',[HomeController::class,'detail'])->name('books.detail');
Route::post('save-book-review',[HomeController::class,'saveReview'])->name('books.saveReview');
Route::get('about',[HomeController::class,'about'])->name('about');


Route::group(['preifix' => 'account'],function(){
    Route::group(['middleware' => 'guest'],function(){
        Route::get('account/login',[AccountController::class,'login'])->name('account.login');
        Route::get('account/register',[AccountController::class,'register'])->name('account.register');
        Route::post('account/register',[AccountController::class,'processRegister'])->name('account.processRegister');
        Route::post('account/login',[AccountController::class,'authenticate'])->name('account.authenticate');
   });

    Route::group(['middleware' => 'auth'],function(){
        Route::get('account/profile',[AccountController::class,'profile'])->name('account.profile');
        Route::get('account/about',[AccountController::class,'about'])->name('account.about');
        Route::get('account/logout',[AccountController::class,'logout'])->name('account.logout');
        Route::post('account/update-profile',[AccountController::class,'updateprofile'])->name('account.updateprofile');
        Route::get('books/list',[BookController::class,'index'])->name('books.index');
        Route::get('books/create',[BookController::class,'create'])->name('books.create');
        Route::post('books',[BookController::class,'store'])->name('books.store');
        Route::get('books/edit/{id}',[BookController::class,'edit'])->name('books.edit');
        Route::post('books/edit/{id}',[BookController::class,'update'])->name('books.update');
        Route::get('books/destroy/{id}',[BookController::class,'destroy'])->name('books.destroy');
        Route::get('account/reviews/list',[ReviewController::class,'index'])->name('account.reviews.list');
        Route::get('account/reviews/edit/{id}',[ReviewController::class,'edit'])->name('account.reviews.edit');
        Route::post('account/reviews/updateReview/{id}',[ReviewController::class,'updateReview'])->name('account.reviews.updateReview');
        Route::get('account/reviews/destroy/{id}',[ReviewController::class,'destroy'])->name('account.reviews.destroy');
        Route::get('account/myReviews/myReview',[ReviewController::class,'myReview'])->name('account.myReviews.myReview');
        Route::get('account/myReviews/delete/{id}',[ReviewController::class,'delete'])->name('account.myReviews.delete');
        Route::get('account/myReviews/edit/{id}',[ReviewController::class,'update'])->name('account.myReviews.edit');
        Route::post('account/myReviews/edit/{id}',[ReviewController::class,'updateProcess'])->name('account.myReviews.updateProcess');
        Route::get('account/reviews/changePassPage',[AccountController::class,'changePassword'])->name('account.reviews.changePassPage');
        Route::post('account/reviews/updatepassword',[AccountController::class,'updatepassword'])->name('account.reviews.updatepassword');
        
       
    });
});