<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\MenuController;
use App\Http\Controllers\Admin\DishController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\Admin\AdminAuthController;

//--Client--
Route::get('/', [\App\Http\Controllers\Front\MenuController::class, 'dishes']);
// Корзина
Route::prefix('cart')->group(function () {
    Route::get('/', [\App\Http\Controllers\Front\CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{id}', [\App\Http\Controllers\Front\CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{id}', [\App\Http\Controllers\Front\CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{id}', [\App\Http\Controllers\Front\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/clear', [\App\Http\Controllers\Front\CartController::class, 'clear'])->name('cart.clear');
    Route::post('/decrement/{id}', [\App\Http\Controllers\Front\CartController::class, 'decrement'])->name('decrement');
    Route::post('/increment/{id}', [\App\Http\Controllers\Front\CartController::class, 'increment'])->name('increment');
});

// Оформление заказа
Route::get('/checkout', [\App\Http\Controllers\Front\CheckoutController::class, 'showForm'])->name('checkout.form');
Route::post('/checkout', [\App\Http\Controllers\Front\CheckoutController::class, 'store'])->name('checkout.store');
Route::post('/cart/add-multiple', [CartController::class, 'addMultiple'])->name('cart.add-multiple');

// Мои заказы
Route::get('/my-orders', [\App\Http\Controllers\Front\OrderHistoryController::class, 'index'])->name('my.orders');
Route::get('/my-orders/{order}', [\App\Http\Controllers\Front\OrderHistoryController::class, 'show'])->name('my.orders.show');


Route::get('/menu', [\App\Http\Controllers\Front\MenuController::class, 'dishes'])->name('menu');
Route::post('/menu/add/{id}', [\App\Http\Controllers\Front\CartController::class, 'add'])->name('cart.add');



//логин/логаут
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');




//--Admin--
Route::prefix('admin')->middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
//Блюдо
    Route::get('/dishes', [\App\Http\Controllers\Admin\DishController::class, 'index'])->name('admin.dishes');
    Route::get('/dishes/create', [\App\Http\Controllers\Admin\DishController::class, 'create'])->name('admin.dishes.create');
    Route::post('/dishes', [\App\Http\Controllers\Admin\DishController::class, 'store'])->name('admin.dishes.store');
    Route::get('/dishes/{id}/edit', [\App\Http\Controllers\Admin\DishController::class, 'edit'])->name('admin.dishes.edit');
    Route::put('/dishes/{id}', [\App\Http\Controllers\Admin\DishController::class, 'update'])->name('admin.dishes.update');
    Route::delete('/dishes/{id}/delete', [\App\Http\Controllers\Admin\DishController::class, 'destroy'])->name('admin.dishes.destroy');

//Заказы
    Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders');
    Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');
    Route::post('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    Route::get('/dashboard', function() {return view('admin.dashboard');})->name('admin.dashboard');

    // register
Route::get('/register', [\App\Http\Controllers\Admin\AdminRegisterController::class, 'showForm'])->name('admin.register');
Route::post('/register', [\App\Http\Controllers\Admin\AdminRegisterController::class, 'register']);

Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});