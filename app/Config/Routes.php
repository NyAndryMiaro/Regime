<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Utilisateur::showLogin');
$routes->get('/showSignUp1', 'Utilisateur::showSignup');
$routes->post('/showSignUp2', 'Utilisateur::showSignup2');

$routes->post('/login', 'Utilisateur::login');

$routes->get('/list', 'EtudiantController::getEtudiants');
$routes->get('/notes', 'NoteController::index');
$routes->post('/notes', 'NoteController::store');
$routes->get('/notes/(:segment)', 'NoteController::getNotesByEtudiant/$1');

$routes->get('/form', 'NoteController::index');

$routes->get('/modifiernote/(:segment)', 'NoteController::getNotesByEtudiantAndSemestre/$1/1');
$routes->get('/modifiernote/(:segment)/(:num)', 'NoteController::getNotesByEtudiantAndSemestre/$1/$2');
$routes->post('/modifiernote/(:segment)/(:num)', 'NoteController::updateSemester/$1/$2');

$routes->get('/supprimernote/(:segment)', 'NoteController::getNotesByEtudiantAndSemestre/$1/1');
$routes->post('/supprimernote/(:segment)/(:num)', 'NoteController::removeSemester/$1/$2');

$routes->get('/register-sante', 'Utilisateur::showRegister');
