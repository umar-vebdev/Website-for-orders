<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\MenuController;
use App\Http\Controllers\Admin\DishController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
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
    Route::post('/cart/add-multiple', [\App\Http\Controllers\Front\CartController::class, 'addMultiple'])->name('cart.add-multiple');

    // Мои заказы
    Route::get('/my-orders', [\App\Http\Controllers\Front\OrderHistoryController::class, 'index'])->name('my.orders');
    Route::get('/my-orders/{order}', [\App\Http\Controllers\Front\OrderHistoryController::class, 'show'])->name('my.orders.show');

    Route::get('/menu', [\App\Http\Controllers\Front\MenuController::class, 'dishes'])->name('menu');
    Route::post('/menu/add/{id}', [\App\Http\Controllers\Front\CartController::class, 'add'])->name('cart.add');

    //логин
// форма логина админа
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login.form');

// обработка логина
Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login');



//--Admin--
Route::prefix('admin')->middleware([
    \App\Http\Middleware\AdminMiddleware::class,
    ])->group(function () {
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
    Route::delete('orders/destroy-all', [\App\Http\Controllers\Admin\OrderController::class, 'destroyAll'])->name('admin.orders.destroyAll');
    Route::delete('/admin/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'destroy']) ->name('admin.orders.destroy');


//----------
    Route::get('/admin/orders/{order}/export', [OrderController::class, 'export'])->name('admin.orders.export');

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');   
    
    Route::get('/register', [\App\Http\Controllers\Admin\AdminAuthController::class, 'showForm'])->name('admin.register');
    Route::post('/register', [\App\Http\Controllers\Admin\AdminAuthController::class, 'register']);

    Route::delete('/delete/{user}', [\App\Http\Controllers\Admin\AdminController::class, 'destroy'])->name('admin.delete');

Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});