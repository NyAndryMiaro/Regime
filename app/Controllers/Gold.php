<?php

namespace App\Controllers;

use App\Models\GoldModel;
use App\Models\UtilisateurModel;

class Gold extends BaseController
{

    function showGold()
    {
        $model = new GoldModel();
        $config = $model->findAll(1);

        return view('/frontoffice/option-gold', [
            'parametre' => $config[0]
        ]);
    }

    // Endpoint AJAX pour devenir gold
    function becomeGoldAjax()
    {
        $request = $this->request;
        $id_Utilisateur = $request->getPost('id_Utilisateur');
        $user = new UtilisateurModel();
        $userID = $user->find($id_Utilisateur);

        $gold = new GoldModel();
        $prix = $gold->findAll(1)[0]["prix"];

        $reste = $userID["argent"] - $prix;
        if ($reste < 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Argent insuffisant'
            ]);
        }

        $user->toGold($id_Utilisateur, $reste);

        // Mettre à jour la session utilisateur
        $session = session();
        $userSession = $session->get('user');
        $userSession['estGold'] = true;
        $session->set('user', $userSession);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Vous êtes maintenant Premium Gold !'
        ]);
    }
}
