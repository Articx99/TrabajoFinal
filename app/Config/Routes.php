<?php

namespace Config;

use App\Controllers\Tareas;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');

if (!session()->get('username')) {
    $routes->get('login', 'Login::index');
    $routes->post('login', 'Login::index');
    $routes->get('register', 'Register::index');
    $routes->post('register', 'Register::index');

    $routes->setAutoRoute(false);
    $routes->get('/', function () {
        $response = Services::response();
        return $response->redirect('login', 'auto', 302);
    });
    $routes->add('(:any)', function () {
        $response = Services::response();
        return $response->redirect('login', 'auto', 302);
    });
} else {
    $routes->get('logout', 'Login::logout');
    $routes->get('/', 'Tareas::index');
    $routes->get('etiquetas', 'Etiquetas::showAll');
    $routes->post('save', 'Tareas::save');
    $routes->post('delete', 'Tareas::delete');
    $routes->post('permaDelete', 'Tareas::permaDelete');
    $routes->get('recover/(:num)', 'Tareas::recoverTask/$1');
    $routes->get('edit/(:num)/(:num)', 'Tareas::viewEdit/$1/$2');
    $routes->post('edit', 'Tareas::edit');
    $routes->get('borrador', 'Tareas::borrador');
    $routes->get('about', 'Tareas::about');
    $routes->get('usuarios', 'Usuarios::getUsers');
    $routes->post('complete', 'Tareas::complete');
    $routes->post('getCompleted', 'Tareas::getCompleted'); 
    $routes->post('saveEtiqueta', 'Etiquetas::saveEtiqueta');  
    $routes->post('deleteEtiqueta', 'Etiquetas::delete');
    $routes->get('editEtiqueta/(:num)', 'Etiquetas::viewEdit/$1');
    $routes->post('editEtiqueta', 'Etiquetas::edit');
    $routes->post('deleteUser', 'Usuarios::deleteUser');
    $routes->post('saveUser', 'Usuarios::saveUser');
}




// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}