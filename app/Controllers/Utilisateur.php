<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use App\Models\ObjectifModel;
use App\Models\UtilisateurObjectifModel;

class Utilisateur extends BaseController
{
    public function login()
    {
        $model = new UtilisateurModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if (!$user || $password != $user['motdepasse']) {
            return view('login', [
                'user' => null,
                'error' => 'Email ou mot de passe incorrect'
            ]);
        }
        
        session()->set('user', [
            'id' => $user['id_Utilisateur'],
            'nom' => $user['nom'],
            'email' => $user['email'],
            'estAdmin' => $user['estAdmin']
        ]);
        
        if($user['estAdmin'] == 1){
            $users = $model->findAll();
            return view('/backoffice/accueil-admin', ['users' => $users]);
        }
        
        $verifier= $this->ObjectifUtilisateur($user['id_Utilisateur']);

        $objectif= new ObjectifModel();
        $obj= $objectif->findAll();

        
        if($verifier != null){
            $but= $objectif -> find($verifier['id_Objectif']);
            return view('frontoffice/accueil', ['user' => $user, 'objectifs' => $obj, 'objectif' => $but]);
        } else{
            return view('frontoffice/accueil', ['user' => $user, 'objectifs' => $obj]);
        }
    }

    public function showLogin()
    {
        return view('login');
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

        return view('signupSante', [
            'infos' => $data,
        ]);

    }

    public function register(){
        $infos= $this->request->getPost();
        $sante=[
            'nom' => $infos['nom'],
            'genre' => $infos['genre'],
            'email' => $infos['email'],
            'motdepasse' => $infos['password'],
            'taille' => $this->request->getPost('taille'),
            'poids' => $this->request->getPost('poids'),
            'estAdmin' => 0
        ];

        $utilisateurmodel = new UtilisateurModel();
        
        if (!$utilisateurmodel->insert($sante)) {
            return view('signup', [
                'errors' => $utilisateurmodel->errors(),
                'old' => $infos
            ]);
        } else{
            return redirect()->to('/');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function accueil()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login');
        }
        
        $model = new UtilisateurModel();
        $userData = $model->find($user['id']);
        
        $objectif= new ObjectifModel();
        $obj= $objectif->findAll();
        
        $verifier= $this->ObjectifUtilisateur($user['id']);
        if($verifier != null){
            $but= $objectif -> find($verifier['id_Objectif']);
            return view('frontoffice/accueil', ['user' => $user, 'objectifs' => $obj, 'objectif' => $but]);
        } else{
            return view('frontoffice/accueil', ['user' => $user, 'objectifs' => $obj]);
        }

    }

    public function accueilAdmin()
    {
        $user = session()->get('user');
        if (!$user || !$user['estAdmin']) {
            return redirect()->to('/login');
        }
        
        $model = new UtilisateurModel();
        $users = $model->findAll();
        
        return view('backoffice/accueil', ['users' => $users]);
    }

    public function choixObjectif(){
        $user = session()->get('user');
        
        $verifier= $this->ObjectifUtilisateur($user['id']);

        $infos= [
            'id_Utilisateur' => $user['id'],
            'id_Objectif' => $this->request->getPost('objectif')
        ];

        $utiliObj= new UtilisateurObjectifModel();

        $model = new UtilisateurModel();
        $userData = $model->find($user['id']);
        
        $objectif= new ObjectifModel();
        $obj= $objectif->findAll();

        $utiliObj->insert($infos);
        $but= $objectif -> find($verifier['id_Objectif']);

        return view('frontoffice/accueil', ['user' => $userData, 'objectifs' => $obj, 'objectif' => $but]);
    }

    public function ObjectifUtilisateur($user){

        $utiliObj = new UtilisateurObjectifModel();
        $obj = $utiliObj -> find($user);
    
        return $obj;
    }
}
