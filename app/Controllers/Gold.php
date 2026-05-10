<?php 

namespace App\Controllers;

use App\Models\GoldModel;
use App\Models\UtilisateurModel;

class Gold extends BaseController{

    function showGold() {
        $model = new GoldModel();
        $config = $model->findAll(1);

        return view('/frontoffice/option-gold', [
            'parametre' => $config[0]
        ]);
    }

    function becomeGold($id_Utilisateur) {
        $user = new UtilisateurModel();
        $user->toGold($id_Utilisateur);

        session()->set('user', [
            'estGold' => TRUE
        ]);
    
        return redirect()->to('/show-gold');    
    }

}