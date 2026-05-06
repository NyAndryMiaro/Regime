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

        if (!$user || $user['password_user'] != $password) {
            return view('login', [
                'user' => null,
                'error' => 'Email ou mot de passe incorrect'
            ]);
        }
        // Stocker uniquement les données non sensibles en session
        session()->set('user', [
            'id' => $user['id_user'],
            'nom' => $user['nom_user'],
            'email' => $user['email'],
        ]);
        
        return redirect()->to('/list');
    }

    public function showLogin() {
        $model = new UtilisateurModel();
        $user = $model->orderBy('id_user', 'ASC')->first();

        return view('login', [
            'user' => $user,
        ]);
        
    }

    public function showSignUp() {
        return view('signup');
    }
}
