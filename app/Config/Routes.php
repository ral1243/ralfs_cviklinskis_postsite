<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');

$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//Page routing------------------------
use App\Controllers\Pages;

$routes->get('/', 'Pages::view/home');
$routes->get('(:segment)', [Pages::class, 'view']);
$routes->get('detail/(:segment)', [Pages::class, 'post']);
//------------------------------------

$routes->post('post/add', 'PostController::add');
$routes->get('post/fetch/(:segment)', 'PostController::fetch/$1');
$routes->post('post/edit', 'PostController::edit');
$routes->get('post/delete/(:segment)', 'PostController::delete/$1');
$routes->get('post/fetchTags', 'PostController::fetchTags');
$routes->post('account/login/(:segment)', 'AccountController::login/$1');
$routes->post('account/signup', 'AccountController::signup');
$routes->post('account/logout/(:segment)', 'AccountController::logout/$1');
$routes->post('account/fetch', 'AccountController::fetchAccount');
$routes->post('account/delete/(:segment)', 'AccountController::delete/$1');
$routes->post('account/edit', 'AccountController::editAccount');
$routes->post('comment/add/(:segment)', 'CommentController::add/$1');
$routes->get('comment/fetch/(:segment)', 'CommentController::fetch/$1');
$routes->post('comment/delete/(:segment)', 'CommentController::delete/$1');
$routes->post('comment/edit/(:segment)', 'CommentController::edit/$1');



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}