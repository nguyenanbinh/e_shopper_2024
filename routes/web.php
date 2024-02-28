<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\BlogController as FrontendBlogController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\UserController as FrontendUserController;
use App\Http\Controllers\Frontend\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
// Auth frontend
Route::get('/login',[AuthController::class, 'getLogin'])->name('login');
Route::post('/login',[AuthController::class, 'postLogin'])->name('login');
Route::get('/register',[AuthController::class, 'getRegister'])->name('register');
Route::post('/register',[AuthController::class, 'postRegister'])->name('register');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

// Blog
Route::get('/blogs',[FrontendBlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{id}',[FrontendBlogController::class, 'show'])->name('blogs.show');
Route::post('/ajaxRate',[FrontendBlogController::class, 'ajaxRate'])->middleware('auth')->name('blogs.ajaxRate');
// Blog comment
Route::post('/ajaxComment', [FrontendBlogController::class, 'ajaxComment'])->middleware('auth')->name('blogs.ajaxComment');
Route::post('/ajaxCommentChild', [FrontendBlogController::class, 'ajaxCommentChild'])->middleware('auth')->name('blogs.ajaxCommentChild');
// Account
Route::group(['prefix' => 'account', 'as' => 'account.'] , function () {
    // Profile
    Route::get('/profile', [FrontendUserController::class, 'profile'])->name('profile');
    Route::put('/update', [FrontendUserController::class, 'updateProfile'])->name('update');
    Route::get('/my-product', [ProductController::class, 'index'])->name('my-product');
    Route::get('/add-product', [ProductController::class, 'create'])->name('add-product');
    Route::post('/add-product', [ProductController::class, 'store'])->name('add-product');
    Route::get('/edit-product/{id}/update', [ProductController::class, 'edit'])->name('edit-product');
    Route::put('/edit-product/{id}', [ProductController::class, 'update'])->name('update-product');
});
// Product details
Route::get('/product/{id}', [ProductController::class, 'show'])->name('show-product');;

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
    Auth::routes();
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Left sidebar
    Route::get('/form-basic', fn() => view('admin.sidebar.form-basic'))->name('sidebar.form-basic');
    Route::get('/table-basic', fn() => view('admin.sidebar.table-basic'))->name('sidebar.table-basic');
    Route::get('/icon-material', fn() => view('admin.sidebar.icon-material'))->name('sidebar.icon-material');
    Route::get('/starter-kit', fn() => view('admin.sidebar.starter-kit'))->name('sidebar.starter-kit');
    Route::get('/error-404', fn() => view('admin.sidebar.error-404'))->name('sidebar.error-404');

    // User Profile
    Route::get('/profile', [UserController::class, 'index'])->name('user.profile');
    Route::put('/profile/update', [UserController::class, 'update'])->name('user.profile.update');
    // Countries routes
    Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');
    Route::get('/countries/create', [CountryController::class, 'create'])->name('countries.create');
    Route::post('/countries', [CountryController::class, 'store'])->name('countries.store');
    Route::delete('/countries/{id}', [CountryController::class, 'destroy'])->name('countries.destroy');

    Route::resource('/blogs', BlogController::class)->except(['show']);
    Route::resource('/categories', CategoryController::class)->except(['show', 'edit', 'update']);
    Route::resource('/brands', BrandController::class)->except(['show', 'edit', 'update']);

    Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

    Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');
});

