<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\BlogController as FrontendBlogController;
use App\Http\Controllers\Frontend\UserController as FrontendUserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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
    return view('frontend.home');
})->name('home');
// Auth frontend
Route::get('/login',[AuthController::class, 'getLogin'])->name('login');
Route::post('/login',[AuthController::class, 'postLogin'])->name('login');
Route::get('/register',[AuthController::class, 'getRegister'])->name('register');
Route::post('/register',[AuthController::class, 'postRegister'])->name('register');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
// Profile
Route::get('/profile',[FrontendUserController::class, 'profile'])->name('profile');
Route::put('/profile',[FrontendUserController::class, 'updateProfile'])->name('profile');
// Blog
Route::get('/blogs',[FrontendBlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{id}',[FrontendBlogController::class, 'show'])->name('blogs.show');
Route::post('/ajaxBlog',[FrontendBlogController::class, 'ajaxBlog'])->middleware('auth')->name('blogs.ajaxBlog');
// Blog comment
Route::post('/ajaxComment', [FrontendBlogController::class, 'ajaxComment'])->middleware('auth')->name('blogs.ajaxComment');
Route::post('/ajaxCommentChild', [FrontendBlogController::class, 'ajaxCommentChild'])->middleware('auth')->name('blogs.ajaxCommentChild');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
    Auth::routes();
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // User Profile
    Route::get('/profile', [UserController::class, 'index'])->name('user.profile');
    Route::put('/profile/update', [UserController::class, 'update'])->name('user.profile.update');
    // Countries routes
    Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');
    Route::get('/countries/create', [CountryController::class, 'create'])->name('countries.create');
    Route::post('/countries', [CountryController::class, 'store'])->name('countries.store');
    Route::delete('/countries/{id}', [CountryController::class, 'destroy'])->name('countries.destroy');

    Route::resource('/blogs', BlogController::class)->except(['show']);

    Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

    Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');
});

