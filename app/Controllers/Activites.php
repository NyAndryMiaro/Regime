<?php

namespace App\Controllers;

use App\Models\ActivitesModel;
use App\Models\ObjectifModel;

class Activites extends BaseController
{

    function listeActivites()
    {
        $model = new ActivitesModel();
        $liste = $model->getActiviteObjectid();
        
        return view('/backoffice/activites', [
            'liste' => $liste
        ]);
    }

    function showForm() {
        $objectif = new ObjectifModel(); 
        $objectives = $objectif->findAll();

        return view('/backoffice/ajout-activite', [
            'objectifs' => $objectives
        ]);

    }

    function save() {
        $nom = $this->request->getPost('nom');
        $id_objectif = $this->request->getPost('id_objectif');
        $mois = $this->request->getPost('mois');
        $jours = $this->request->getPost('jours');
        $heures = $this->request->getPost('heures');
        $poids = $this->request->getPost('variation_poids');
        //traitement et validations des champs

        // $errors = [];
        // if (empty($nom)) {
        //     $errors["nom"] = "Cette champ est obligatoire"
        // }

        // if(!empty($errors)) {
        //     return view('/backoffice/ajout-activite', [
        //         'errors' => $errors,
        //         'old' => [
        //             'nom' => $data['nom'],
        //             'genre' => $data['genre'],
        //             'email' => $data['email'],
        //         ]
        //     ]);
        // }

        $duree = ($mois * 30 + $jours)*24 + $heures;
        
        $data = [
            'id_Objectif' => $id_objectif,
            'libelle' => $nom,
            'duree' => $duree,
            'variation_poids' => $poids
        ];

        $model = new ActivitesModel();
        $model->insert($data);

        return redirect()->to('/admin/activites');
    }

    function remove($id_activite) {
        $model = new ActivitesModel();
        $model->delete($id_activite);

        return redirect()->to('/admin/activites');
    }

    function showUpdateForm($id_activite) {
        $model = new ActivitesModel();
        $activite = $model->find($id_activite);

        $objectif = new ObjectifModel();
        $objectives = $objectif->findAll();
        return view('/backoffice/update-activite', [
            'activite' => $activite,
            'objectifs' => $objectives,
        ]);
    }

    function update(){
        $nom = $this->request->getPost('nom');
        $id_objectif = $this->request->getPost('id_objectif');
        $mois = $this->request->getPost('mois');
        $jours = $this->request->getPost('jours');
        $heures = $this->request->getPost('heures');
        $poids = $this->request->getPost('variation_poids');
        $id_activite = $this->request->getPost('id_activite');

        $duree = ($mois * 30 + $jours)*24 + $heures;
        
        $data = [
            'id_Objectif' => $id_objectif,
            'libelle' => $nom,
            'duree' => $duree,
            'variation_poids' => $poids
        ];

        $model = new ActivitesModel();
        $model->update($id_activite, $data);
        
        return redirect()->to('/admin/activite-update/'. $id_activite);
    }

}
