<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RegimeModel;
use App\Models\ObjectifModel;

class Regimes extends BaseController
{
    function listeRegimes()
    {
        $model = new RegimeModel();
        $liste = $model->getRegimeObjectid();

        return view("/backoffice/regimes", [
            'liste' => $liste,
        ]);
    }

    function showForm()
    {
        $objectif = new ObjectifModel();
        $objectives = $objectif->findAll();

        return view('/backoffice/ajout-regime', [
            'objectifs' => $objectives
        ]);
    }

    function save()
    {
        $libelle = $this->request->getPost('libelle');
        $id_objectif = $this->request->getPost('id_objectif');
        $duree = $this->request->getPost('duree');
        $variation_poids = $this->request->getPost('variation_poids');
        $prix_unitaire = $this->request->getPost('prix_unitaire');
        $pourcentage_viande = $this->request->getPost('pourcentage_viande');
        $pourcentage_poisson = $this->request->getPost('pourcentage_poisson');
        $pourcentage_legume = $this->request->getPost('pourcentage_legume');

        $errors = [];
        if (empty($libelle)) {
            $errors[] = "Le nom est obligatoire";
        }
        if (empty($id_objectif)) {
            $errors[] = "L'objectif est obligatoire";
        }
        if ($duree === null || $duree === '') {
            $errors[] = "La durée est obligatoire";
        }
        if ($variation_poids === null || $variation_poids === '') {
            $errors[] = "La variation du poids est obligatoire";
        }
        if ($prix_unitaire === null || $prix_unitaire === '') {
            $errors[] = "Le prix unitaire est obligatoire";
        }
        if ($pourcentage_viande === null || $pourcentage_viande === '') {
            $errors[] = "Le pourcentage de viande est obligatoire";
        }
        if ($pourcentage_poisson === null || $pourcentage_poisson === '') {
            $errors[] = "Le pourcentage de poisson est obligatoire";
        }
        if ($pourcentage_legume === null || $pourcentage_legume === '') {
            $errors[] = "Le pourcentage de légume est obligatoire";
        }

        if ($pourcentage_viande != null && $pourcentage_poisson != null && $pourcentage_legume != null) {
            $somme = $pourcentage_legume + $pourcentage_poisson + $pourcentage_viande;
            if ($somme > 100) {
                $errors[] = "Pourcentage invalide";
            }
        }

        $old = [
            'libelle' => $libelle,
            'id_objectif' => $id_objectif,
            'duree' => $duree,
            'variation_poids' => $variation_poids,
            'prix_unitaire' => $prix_unitaire,
            'pourcentage_viande' => $pourcentage_viande,
            'pourcentage_poisson' => $pourcentage_poisson,
            'pourcentage_legume' => $pourcentage_legume,
        ];

        if (!empty($errors)) {
            $objectif = new ObjectifModel();
            $objectives = $objectif->findAll();
            return view('/backoffice/ajout-regime', [
                'errors' => $errors,
                'old' => $old,
                'objectifs' => $objectives,
            ]);
        }

        $data = [
            'id_objectif' => $id_objectif,
            'libelle' => $libelle,
            'duree' => $duree,
            'variation_poids' => $variation_poids,
            'prix_unitaire' => $prix_unitaire,
            'pourcentage_viande' => $pourcentage_viande,
            'pourcentage_poisson' => $pourcentage_poisson,
            'pourcentage_legume' => $pourcentage_legume,
        ];

        $model = new RegimeModel();
        $model->insert($data);

        return redirect()->to('/admin/regimes');
    }

    function remove($id_regime)
    {
        $model = new RegimeModel();
        $model->delete($id_regime);

        return redirect()->to('/admin/regimes');
    }

    function showUpdateForm($id_regime)
    {
        $model = new RegimeModel();
        $regime = $model->find($id_regime);

        $objectif = new ObjectifModel();
        $objectives = $objectif->findAll();
        return view('/backoffice/update-regime', [
            'regime' => $regime,
            'objectifs' => $objectives,
        ]);
    }

    function update()
    {
        $libelle = $this->request->getPost('libelle');
        $id_objectif = $this->request->getPost('id_objectif');
        $duree = $this->request->getPost('duree');
        $variation_poids = $this->request->getPost('variation_poids');
        $prix_unitaire = $this->request->getPost('prix_unitaire');
        $pourcentage_viande = $this->request->getPost('pourcentage_viande');
        $pourcentage_poisson = $this->request->getPost('pourcentage_poisson');
        $pourcentage_legume = $this->request->getPost('pourcentage_legume');
        $id_regime = $this->request->getPost('id_regime');

        $errors = [];
        if (empty($libelle)) {
            $errors[] = "Le nom est obligatoire";
        }
        if (empty($id_objectif)) {
            $errors[] = "L'objectif est obligatoire";
        }
        if ($duree === null || $duree === '') {
            $errors[] = "La durée est obligatoire";
        }
        if ($variation_poids === null || $variation_poids === '') {
            $errors[] = "La variation du poids est obligatoire";
        }
        if ($prix_unitaire === null || $prix_unitaire === '') {
            $errors[] = "Le prix unitaire est obligatoire";
        }
        if ($pourcentage_viande === null || $pourcentage_viande === '') {
            $errors[] = "Le pourcentage de viande est obligatoire";
        }
        if ($pourcentage_poisson === null || $pourcentage_poisson === '') {
            $errors[] = "Le pourcentage de poisson est obligatoire";
        }
        if ($pourcentage_legume === null || $pourcentage_legume === '') {
            $errors[] = "Le pourcentage de légume est obligatoire";
        }

        if ($pourcentage_viande != null && $pourcentage_poisson != null && $pourcentage_legume != null) {
            $somme = $pourcentage_legume + $pourcentage_poisson + $pourcentage_viande;
            if ($somme > 100) {
                $errors[] = "Pourcentage invalide";
            }
        }
        $old = [
            'libelle' => $libelle,
            'id_objectif' => $id_objectif,
            'duree' => $duree,
            'variation_poids' => $variation_poids,
            'prix_unitaire' => $prix_unitaire,
            'pourcentage_viande' => $pourcentage_viande,
            'pourcentage_poisson' => $pourcentage_poisson,
            'pourcentage_legume' => $pourcentage_legume,
        ];

        if (!empty($errors)) {
            $model = new RegimeModel();
            $regime = $model->find($id_regime);
            $objectif = new ObjectifModel();
            $objectives = $objectif->findAll();
            return view('/backoffice/update-regime', [
                'errors' => $errors,
                'old' => $old,
                'regime' => $regime,
                'objectifs' => $objectives,
            ]);
        }

        $data = [
            'id_Objectif' => $id_objectif,
            'libelle' => $libelle,
            'duree' => $duree,
            'variation_poids' => $variation_poids,
            'prix_unitaire' => $prix_unitaire,
            'pourcentage_viande' => $pourcentage_viande,
            'pourcentage_poisson' => $pourcentage_poisson,
            'pourcentage_legume' => $pourcentage_legume,
        ];

        $model = new RegimeModel();
        $model->update($id_regime, $data);

        return redirect()->to('/admin/regimes');
    }
}
