<?php

use App\Controllers\AuthenticationController;
use App\Controllers\CategoryController;
use App\Controllers\DashboardController;
use App\Controllers\TransactionController;
use App\Controllers\ProductController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('', ['filter' => 'unauth'], function ($routes) {
    // Route Authentication
    $routes->get('register', function () {
        return view('register');
    });

    $routes->get('/', function () {
        return view('index');
    });

    $routes->post('auth/register', [AuthenticationController::class, 'register']);
    $routes->post('auth/login', [AuthenticationController::class, 'login']);
});

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/admin', [DashboardController::class, 'index']);
    $routes->get('/admin/category/new', [CategoryController::class, 'new']);
    $routes->post('/admin/category', [CategoryController::class, 'store']);
    $routes->get('/admin/category', [CategoryController::class, 'index']);
    $routes->get('/admin/category/(:segment)', [CategoryController::class, 'show']);
    $routes->get('/admin/category/(:segment)/edit', [CategoryController::class, 'edit']);
    $routes->put('admin/category/(:segment)', [CategoryController::class, 'update']);
    $routes->delete('admin/category/(:segment)', [CategoryController::class, 'delete']);

    $routes->resource('admin/product', ['controller' => 'ProductController']);

    // Route Transaction
    $routes->get('admin/trx', [TransactionController::class, 'index']);
    $routes->get('admin/trx/new', [TransactionController::class, 'new']);
    $routes->post('admin/trx/import', [TransactionController::class, 'import']);
    $routes->get('admin/trx/export', [TransactionController::class, 'export']);

    $routes->get('auth/logout', [AuthenticationController::class, 'logout']);
});


