<?php

use App\Controllers\CategoryController;
use App\Controllers\DashboardController;
use App\Controllers\ProductController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/test', function(){
    return view('test', ['name' => 'test']);
});

$routes->get('/admin', [DashboardController::class, 'index']);
$routes->get('/admin/category/new', [CategoryController::class, 'new']);
$routes->post('/admin/category', [CategoryController::class, 'store']);
$routes->get('/admin/category', [CategoryController::class, 'index']);
$routes->get('/admin/category/(:segment)',  [CategoryController::class, 'show']);
$routes->get('/admin/category/(:segment)/edit', [CategoryController::class, 'edit']);
$routes->put('admin/category/(:segment)', [CategoryController::class, 'update']);
$routes->delete('admin/category/(:segment)', [CategoryController::class, 'delete']);

$routes->resource('admin/product',['controller' => 'ProductController']);




