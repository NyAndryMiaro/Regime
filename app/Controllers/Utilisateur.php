<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

class Utilisateur extends BaseController
{
    public function login()
    {
        $model = new UtilisateurModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if (!$user || $user['motdepasse'] != $password) {
            return view('login', [
                'user' => null,
                'error' => 'Email ou mot de passe incorrect'
            ]);
        }
        // Stocker uniquement les données non sensibles en session
        session()->set('user', [
            'id' => $user['id_Utilisateur'],
            'nom' => $user['nom'],
            'email' => $user['email'],
        ]);
        
        // return redirect()->to('/list');
        return view('logged');
    }

    public function showLogin()
    {
        $model = new UtilisateurModel();
        $user = $model->orderBy('id_Utilisateur', 'ASC')->first();

        return view('login', [
            'user' => $user,
        ]);
    }

    public function showSignUp(){
        return view('signup');
    }

    public function showSignUp2(){
        $data = [
            'nom' => $this->request->getPost('nom'),
            'genre' => $this->request->getPost('genre'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];

        $errors = [];
        if (!$data['nom'] || strlen(trim($data['nom'])) < 3) {
            $errors['nom'] = "Votre nom doit avoir au moins 3 caractères.";
        }
        if (!$data['password'] || strlen($data['password']) < 8) {
            $errors['password'] = "Le mot de passe doit avoir au moins 8 caractères.";
        } elseif (!preg_match('/[^a-zA-Z0-9]/', $data['password'])) {
            $errors['password'] = "Le mot de passe doit contenir au moins un caractère spécial.";
        }
        if (!$data['email'] || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email obligatoire ou invalide.";
        }
        if (!$data['genre'] || ($data['genre'] !== 'M' && $data['genre'] !== 'F')) {
            $errors['genre'] = "Genre obligatoire.";
        }

        if (!empty($errors)) {
            return view('signup', [
                'errors' => $errors,
                'old' => [
                    'nom' => $data['nom'],
                    'genre' => $data['genre'],
                    'email' => $data['email'],
                ]
            ]);
        }

        return view('signup-sante', [
            'infos' => $data,
        ]);

    }

    public function register(){
        $infos= $this->request->getPost();
    }
}
