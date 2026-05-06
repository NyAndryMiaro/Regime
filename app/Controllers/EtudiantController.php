<?php

namespace App\Controllers;

use App\Models\EtudiantModel;

class EtudiantController extends BaseController{
    public function getEtudiants(){
        $etudiantModel = new EtudiantModel();
        $etudiants = $etudiantModel->findAll();

        return view('list', ['etudiants' => $etudiants]);
    }
}
