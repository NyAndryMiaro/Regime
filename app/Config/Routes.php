<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Utilisateur::showLogin');
$routes->get('/showSignUp1', 'Utilisateur::showSignup');
$routes->post('/showSignUp2', 'Utilisateur::showSignup2');


$routes->post('/login', 'Utilisateur::login');
