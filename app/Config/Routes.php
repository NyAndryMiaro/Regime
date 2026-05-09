<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Utilisateur::showLogin');
$routes->get('/login', 'Utilisateur::showLogin');
$routes->post('/login', 'Utilisateur::login');

$routes->get('/showSignUp1', 'Utilisateur::showSignup');
$routes->post('/showSignUp2', 'Utilisateur::showSignup2');

$routes->post('/register', 'Utilisateur::register');
$routes->get('/logout', 'Utilisateur::logout');

$routes->get('/accueil', 'Utilisateur::accueil');
$routes->get('/accueilAdmin', 'Utilisateur::accueilAdmin');

$routes->post('/objectif', 'Utilisateur::choixObjectif');

//admin
$routes->get('/admin/activites', 'Activites::listeActivites');
$routes->get('/admin/activite-insert', 'Activites::showForm');
$routes->post('/admin/activite-save', 'Activites::save');
$routes->get('/admin/activite-delete/(:num)', 'Activites::remove/$1');
$routes->get('/admin/activite-update/(:num)', 'Activites::showUpdateForm/$1');
$routes->post('/admin/activite-modify', 'Activites::update');

$routes->get('/admin/regimes', 'Regimes::listeRegimes');
$routes->get('/admin/regime-insert', 'Regimes::showForm');
$routes->post('/admin/regime-save', 'Regimes::save');
$routes->get('/admin/regime-delete/(:num)', 'Regimes::remove/$1');
$routes->get('/admin/regime-update/(:num)', 'Regimes::showUpdateForm/$1');
$routes->post('/admin/regime-modify', 'Regimes::update');

// $routes->group('admin', ['filter' => 'role'],
//     function ($routes) {
//         $routes->get('/activites', 'Activites::listeActivites');
//     }
// );
