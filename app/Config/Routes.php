<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Routes untuk Kategori
$routes->group('kategori', function($routes) {
    $routes->get('/', 'Kategori::index');
    $routes->get('create', 'Kategori::create');
    $routes->post('store', 'Kategori::store');
    $routes->get('edit/(:num)', 'Kategori::edit/$1');
    $routes->post('update/(:num)', 'Kategori::update/$1');
    $routes->post('delete/(:num)', 'Kategori::delete/$1');
});

// Routes untuk Produk
$routes->group('produk', function($routes) {
    $routes->get('/', 'Produk::index');
    $routes->get('data', 'Produk::data');
    $routes->get('create', 'Produk::create');
    $routes->post('store', 'Produk::store');
    $routes->get('edit/(:num)', 'Produk::edit/$1');
    $routes->post('update/(:num)', 'Produk::update/$1');
    $routes->post('delete/(:num)', 'Produk::delete/$1');
});