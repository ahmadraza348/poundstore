<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FranchiseEnquiryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OutletController;
use App\Http\Controllers\Frontend\FormController;
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

    // Form submissions (max 5 per minute per visitor to limit spam)
    Route::post('/franchise/enquiry', [FormController::class, 'franchise'])->middleware('throttle:5,1')->name('franchise.submit');
    Route::post('/contact/message', [FormController::class, 'contact'])->middleware('throttle:5,1')->name('contact.submit');
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

        Route::prefix('city')->name('city.')->group(function () {
            Route::get('/', [CityController::class, 'index'])->name('index');
            Route::get('create', [CityController::class, 'create'])->name('create');
            Route::post('store', [CityController::class, 'store'])->name('store');
            Route::get('edit/{city}', [CityController::class, 'edit'])->name('edit');
            Route::put('update/{city}', [CityController::class, 'update'])->name('update');
            Route::delete('delete/{city}', [CityController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('outlet')->name('outlet.')->group(function () {
            Route::get('/', [OutletController::class, 'index'])->name('index');
            Route::get('create', [OutletController::class, 'create'])->name('create');
            Route::post('store', [OutletController::class, 'store'])->name('store');
            Route::get('edit/{outlet}', [OutletController::class, 'edit'])->name('edit');
            Route::put('update/{outlet}', [OutletController::class, 'update'])->name('update');
            Route::delete('delete/{outlet}', [OutletController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('franchise-enquiries')->name('franchise-enquiry.')->group(function () {
            Route::get('/', [FranchiseEnquiryController::class, 'index'])->name('index');
            Route::get('{enquiry}', [FranchiseEnquiryController::class, 'show'])->name('show');
            Route::delete('{enquiry}', [FranchiseEnquiryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('contact-messages')->name('contact-message.')->group(function () {
            Route::get('/', [ContactMessageController::class, 'index'])->name('index');
            Route::get('{message}', [ContactMessageController::class, 'show'])->name('show');
            Route::delete('{message}', [ContactMessageController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('product')->name('product.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('create', [ProductController::class, 'create'])->name('create');
            Route::post('store', [ProductController::class, 'store'])->name('store');
            Route::get('edit/{product}', [ProductController::class, 'edit'])->name('edit');
            Route::post('update/{product}', [ProductController::class, 'update'])->name('update');
            Route::delete('delete/{product}', [ProductController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [ProductController::class, 'bulkDelete'])->name('bulk-delete');
        });

    }
);
