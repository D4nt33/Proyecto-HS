<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PayPalController;


Route::get('/', [ProductController::class, 'showProducts'])->name('welcome');

//pago
Route::get('paypal/create', [PayPalController::class, 'createPayment'])->name('paypal.create');
Route::get('paypal/success', [PayPalController::class, 'handlePaymentSuccess'])->name('paypal.success');
Route::get('paypal/cancel', [PayPalController::class, 'handlePaymentCancel'])->name('paypal.cancel');

//vistas del carrito
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
//venta
Route::get('paypal/success', function () {
    session()->forget('cart'); // Vacía el carrito tras el pago
    return redirect()->route('products.index')->with('success', 'Payment successful!');
})->name('paypal.success');

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});
