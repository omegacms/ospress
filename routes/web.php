<?php

use App\Http\Controllers\ShowHomePageController;
use App\Http\Controllers\Products\OrderProductController;
use App\Http\Controllers\Products\ShowProductController;
use App\Http\Controllers\Users\LogInUserController;
use App\Http\Controllers\Users\LogOutUserController;
use App\Http\Controllers\Users\RegisterUserController;
use App\Http\Controllers\Users\ShowRegisterFormController;
use Framework\Support\Facades\Router;

return function() {
    Router::errorHandler(
        404, fn() => 'whoops!'
    );

    Router::add(
        'GET', '/',
        [ShowHomePageController::class, 'handle'],
    )->name('show-home-page');

    Router::add(
        'GET', '/products/view/{product}',
        [ShowProductController::class, 'handle'],
    )->name('view-product');

    Router::add(
        'POST', '/products/order/{product}',
        [OrderProductController::class, 'handle'],
    )->name('order-product');

    Router::add(
        'GET', '/register',
        [ShowRegisterFormController::class, 'handle'],
    )->name('show-register-form');

    Router::add(
        'POST', '/register',
        [RegisterUserController::class, 'handle'],
    )->name('register-user');

    Router::add(
        'POST', '/log-in',
        [LogInUserController::class, 'handle'],
    )->name('log-in-user');

    Router::add(
        'GET', '/log-out',
        [LogOutUserController::class, 'handle'],
    )->name('log-out-user');
};
