<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Public landing routes
$routes->get('/', 'Home::index');
$routes->get('catalog', 'Home::catalog');
$routes->get('asset/(:num)', 'Home::assetDetail/$1');

// Auth routes
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::storeRegister');
$routes->get('logout', 'AuthController::logout');

// Dashboard base route (redirects based on role)
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);

// Admin Area (Requires auth and admin filters)
$routes->group('admin', ['filter' => ['auth', 'admin']], function($routes) {
    $routes->get('/', 'DashboardController::admin');
    
    // Users Management
    $routes->get('users', 'UserController::index');
    $routes->post('users/ajax', 'UserController::ajaxList');
    $routes->post('users/store', 'UserController::store');
    $routes->post('users/update/(:num)', 'UserController::update/$1');
    $routes->post('users/delete/(:num)', 'UserController::delete/$1');
    
    // Categories Management
    $routes->get('categories', 'CategoryController::index');
    $routes->post('categories/ajax', 'CategoryController::ajaxList');
    $routes->post('categories/store', 'CategoryController::store');
    $routes->post('categories/update/(:num)', 'CategoryController::update/$1');
    $routes->post('categories/delete/(:num)', 'CategoryController::delete/$1');
    
    // Assets Management
    $routes->get('assets', 'AssetController::index');
    $routes->post('assets/ajax', 'AssetController::ajaxList');
    $routes->post('assets/store', 'AssetController::store');
    $routes->post('assets/update/(:num)', 'AssetController::update/$1');
    $routes->post('assets/delete/(:num)', 'AssetController::delete/$1');
    
    // Loans Management
    $routes->get('loans', 'LoanController::adminIndex');
    $routes->post('loans/ajax', 'LoanController::adminAjaxList');
    $routes->post('loans/approve/(:num)', 'LoanController::approve/$1');
    $routes->post('loans/reject/(:num)', 'LoanController::reject/$1');
    $routes->post('loans/borrow/(:num)', 'LoanController::borrow/$1');
    $routes->post('loans/return/(:num)', 'LoanController::returnLoan/$1');
    $routes->get('loans/detail/(:num)', 'LoanController::getLoanDetails/$1');
});

// Member Area (Requires auth filter)
$routes->group('member', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'DashboardController::member');
    
    // Catalog & Loans
    $routes->get('catalog', 'LoanController::memberCatalog');
    $routes->post('loans/store', 'LoanController::storeMemberLoan');
    
    // Loan History
    $routes->get('loans', 'LoanController::memberLoans');
    $routes->get('loans/detail/(:num)', 'LoanController::getLoanDetails/$1');
    
    // Account Profile
    $routes->get('profile', 'DashboardController::profile');
    $routes->post('profile/update', 'DashboardController::updateProfile');
});
