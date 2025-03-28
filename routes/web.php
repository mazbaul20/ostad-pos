<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\SessionAuthenticate;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\TokenVerificationMiddleware;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

//User all routes
Route::post('/user-registration', [UserController::class, 'UserRegistration'])->name('user.registration');
Route::post('/user-login', [UserController::class, 'UserLogin'])->name('user.login');
Route::post('/send-otp', [UserController::class, 'SendOTPCode'])->name('SendOTPCode');
Route::post('/verify-otp', [UserController::class, 'VerifyOTP'])->name('VerifyOTP');



Route::middleware(SessionAuthenticate::class)->group(function(){
    //reset password
    Route::post('/reset-password', [UserController::class, 'ResetPassword']);

    Route::get('/DashboardPage', [UserController::class, 'DashboardPage']);
    Route::get('/user-logout', [UserController::class, 'UserLogout']);

    //Category all routes
    Route::post('/create-category', [CategoryController::class, 'CreateCategory'])->name('category.create');
    Route::get('/list-category', [CategoryController::class, 'CategoryList'])->name('category.list');
    Route::post('/category-by-id', [CategoryController::class, 'CategoryById']);
    Route::post('/update-category', [CategoryController::class, 'CategoryUpdate'])->name('category.update');
    Route::get('/delete-category/{id}', [CategoryController::class, 'CategoryDelete'])->name('category.delete');
    Route::get('/CategoryPage', [CategoryController::class, 'CategoryPage'])->name('CategoryPage');
    Route::get('/CategorySavePage', [CategoryController::class, 'CategorySavePage'])->name('CategorySavePage');

    //Product all routes
    Route::post('/create-product', [ProductController::class, 'CreateProduct'])->name('CreateProduct');
    Route::get('/list-product', [ProductController::class, 'ProductList'])->name('ProductList');
    Route::post('/product-by-id', [ProductController::class, 'ProductById'])->name('ProductById');
    Route::post('/update-product', [ProductController::class, 'ProductUpdate'])->name('ProductUpdate');
    Route::get('/delete-product/{id}', [ProductController::class, 'ProductDelete'])->name('ProductDelete');
    Route::get('/ProductPage', [ProductController::class, 'ProductPage'])->name('product.page');
    Route::get('/ProductSavePage', [ProductController::class, 'ProductSavePage'])->name('ProductSavePage');

    //Profile all routes
    Route::post('/create-customer', [CustomerController::class, 'CreateCustomer'])->name('CreateCustomer');
    Route::get('/list-customer', [CustomerController::class, 'CustomerList'])->name('CustomerList');
    Route::post('/customer-by-id', [CustomerController::class, 'CustomerById'])->name('CustomerById');
    Route::post('/update-customer', [CustomerController::class, 'CustomerUpdate'])->name('CustomerUpdate');
    Route::get('/delete-customer/{id}', [CustomerController::class, 'CustomerDelete'])->name('CustomerDelete');
    Route::get('/CustomerPage', [CustomerController::class, 'CustomerPage'])->name('CustomerPage');
    Route::get('/CustomerSavePage', [CustomerController::class, 'CustomerSavePage'])->name('CustomerSavePage');

    //Invoice all routes
    Route::post('/invoice-create', [InvoiceController::class, 'InvoiceCreate'])->name('InvoiceCreate');
    Route::get('/invoice-list', [InvoiceController::class, 'InvoiceList'])->name('InvoiceList');
    Route::post('/invoice-details', [InvoiceController::class, 'InvoiceDetails'])->name('InvoiceDetails');
    Route::get('/invoice-delete/{id}', [InvoiceController::class, 'InvoiceDelete'])->name('InvoiceDelete');
    Route::get('/InvoiceListPage', [InvoiceController::class, 'InvoiceListPage'])->name('InvoiceListPage');

    //sale route
    Route::get('/create-sale', [SaleController::class, 'SalePage'])->name('SalePage');

    //Dashboard Summary
    Route::get('/dashboard-summary', [DashboardController::class, 'DashboardSummary'])->name('DashboardSummary');

    //Resetpassword page
    Route::get('/reset-password',[UserController::class, 'ResetPasswordPage']);

    Route::get('/ProfilePage', [UserController::class, 'ProfilePage']);
    Route::post('/user-update', [UserController::class, 'UserUpdate']);
});

//Pages all routes
Route::get('/login',[UserController::class, 'LoginPage'])->name('login.page');
Route::get('/registration',[UserController::class, 'RegistrationPage'])->name('registration.page');
Route::get('/send-otp',[UserController::class, 'SendOTPPage'])->name('sendotp.page');
Route::get('/verify-otp',[UserController::class, 'VerifyOTPPage'])->name('VerifyOTPPage');
