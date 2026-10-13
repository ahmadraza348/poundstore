<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;

Route::name('frontend.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/categories', [PageController::class, 'categories'])->name('categories');
    Route::get('/category', [PageController::class, 'category'])->name('category');
    Route::get('/outlets', [PageController::class, 'outlets'])->name('outlets');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/franchise', [PageController::class, 'franchise'])->name('franchise');
    Route::get('/sourcing', [PageController::class, 'sourcing'])->name('sourcing');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
});


// Admin Panel Routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('login/submit', [AuthController::class, 'login_submit'])->name('admin.login.submit');
    Route::get('login/forget-password', [AuthController::class, 'forgetpass'])->name('admin.forgetpass');
    Route::post('login/forget-password/submit', [AuthController::class, 'submitforgetpass'])->name('admin.forgetpass.submit');
    Route::get('login/reset-password/{token}', [AuthController::class, 'show_reset_pass_form'])->name('reset.password.get');
    Route::post('login/reset-password/{token}', [AuthController::class, 'submit_reset_pass_form'])->name('reset.password.post');
});

Route::prefix('admin')->middleware('adminauth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');  
        
         Route::prefix('category')->name('category.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
                Route::get('create', [CategoryController::class, 'create'])->name('create');
                Route::post('store', [CategoryController::class, 'store'])->name('store');
                Route::post('/import', [CategoryController::class, 'import'])->name('import');
                Route::get('edit/{category}', [CategoryController::class, 'edit'])->name('edit');
                Route::post('update/{category}', [CategoryController::class, 'update'])->name('update');
                Route::delete('delete/{category}', [CategoryController::class, 'destroy'])->name('destroy');
                Route::post('/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('bulk-delete');
        });

    }
);
