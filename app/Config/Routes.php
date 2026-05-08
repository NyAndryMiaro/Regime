<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Utilisateur::showLogin');
$routes->get('/login', 'Utilisateur::showLogin');
$routes->get('/showSignUp1', 'Utilisateur::showSignup');
$routes->post('/showSignUp2', 'Utilisateur::showSignup2');
$routes->post('/register', 'Utilisateur::register');
$routes->post('/login', 'Utilisateur::login');
$routes->get('/logout', 'Utilisateur::logout');
$routes->get('/accueil', 'Utilisateur::accueil');
$routes->get('/accueilAdmin', 'Utilisateur::accueilAdmin');


//admin
$routes->get('/admin/activites', 'Activites::listeActivites');

// $routes->group('admin', ['filter' => 'role'],
//     function ($routes) {
//         $routes->get('/activites', 'Activites::listeActivites');
//     }
// );
