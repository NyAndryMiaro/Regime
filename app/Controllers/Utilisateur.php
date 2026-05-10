<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use App\Models\ObjectifModel;
use App\Models\UtilisateurObjectifModel;
use App\Models\CodeModel;
use App\Models\RegimeModel;

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
            'argent' => $user['argent'],
            'estAdmin' => $user['estAdmin']
        ]);

        if ($user['estAdmin'] == 1) {
            $users = $model->findAll();
            return view('/backoffice/accueil-admin', ['users' => $users]);
        }

        $utiliObj = new UtilisateurObjectifModel();
        $verifier = $utiliObj->where('id_Utilisateur', $user['id_Utilisateur'])->first();

        $objectif = new ObjectifModel();
        $obj = $objectif->findAll();

        if ($verifier != null) {
            $but = $objectif->find($verifier['id_Objectif']);
            return view('frontoffice/accueil', ['user' => $user, 'objectifs' => $obj, 'objectif' => $but]);
        } else {
            return view('frontoffice/accueil', ['user' => $user, 'objectifs' => $obj]);
        }
    }

    public function showLogin()
    {
        return view('login');
    }

    public function showSignUp()
    {
        return view('signup');
    }

    public function showSignUp2()
    {
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

    public function register()
    {
        $infos = $this->request->getPost();
        $sante = [
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
        } else {
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

        $objectif = new ObjectifModel();
        $obj = $objectif->findAll();

        $utiliObj = new UtilisateurObjectifModel();
        $verifier = $utiliObj->where('id_Utilisateur', $user['id'])->first();

        if ($verifier != null) {
            $but = $objectif->find($verifier['id_Objectif']);
            return view('frontoffice/accueil', ['user' => $userData, 'objectifs' => $obj, 'objectif' => $but]);
        } else {
            return view('frontoffice/accueil', ['user' => $userData, 'objectifs' => $obj]);
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

    public function objectif()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login');
        }

        $model = new UtilisateurModel();
        $userData = $model->find($user['id']);

        $objectifModel = new ObjectifModel();
        $objectifs = $objectifModel->findAll();

        $utiliObj = new UtilisateurObjectifModel();
        $verifier = $utiliObj->where('id_Utilisateur', $user['id'])->first();

        $objectifActuel = null;
        if ($verifier != null) {
            $objectifActuel = $objectifModel->find($verifier['id_Objectif']);
        }

        return view('frontoffice/objectif', [
            'user' => $userData,
            'objectifs' => $objectifs,
            'objectifActuel' => $objectifActuel
        ]);
    }

    public function choixObjectif()
    {
        $user = session()->get('user');

        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non authentifié']);
        }

        $objectifId = $this->request->getPost('objectif');

        if (!$objectifId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Objectif manquant']);
        }

        $utiliObj = new UtilisateurObjectifModel();
        $objectifModel = new ObjectifModel();
        $objectif = $objectifModel->find($objectifId);

        try {
            $verifier = $utiliObj->where('id_Utilisateur', $user['id'])->first();

            $infos = [
                'id_Utilisateur' => $user['id'],
                'id_Objectif' => $objectifId
            ];

            if ($verifier != null) {
                $utiliObj->update($verifier['id_UtilisateurObjectif'], $infos);
            } else {
                $utiliObj->insert($infos);
            }

            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => true, 'message' => 'Objectif mis à jour']);
            } else {
                $successMsg = 'Objectif modifié avec succès! Vous avez maintenant pour objectif: ' . esc($objectif['libelle']);
                return redirect()->to('/objectif')->with('success', $successMsg);
            }
        } catch (\Exception $e) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function porteMonnaie()
    {
        $user = session()->get('user');

        $util = new UtilisateurModel();
        $utilisateur = $util->find($user['id']);

        return view('frontoffice/porte-monnaie', ['user' => $utilisateur]);
    }

    public function entrerCode()
    {
        $user = session()->get('user');

        $util = new UtilisateurModel();
        $utilisateur = $util->find($user['id']);

        $code = $this->request->getPost('codeArgent');

        $codemodel = new CodeModel();
        $argent = $codemodel->where('code', $code)->first();

        $data = [
            'argent' => $user['argent'] + $argent['montant']
        ];

        $data2 = [
            'utilise' => 1
        ];


        if ($argent['utilise'] == 0) {

            $codemodel->update($argent['idCode'], $data2);
            $util->update($user['id'], $data);

            return redirect()->to('/monnaie')->with('success', "L'argent a été ajouté sur votre compte !");
        } else {
            return redirect()->to('/monnaie')->with('error', "Le code n'est plus disponible");
        }
    }

    /**
     * Calcule le poids idéal basé sur la taille et un IMC cible
     * 
     * @param float $taille Taille en centimètres
     * @param float $imcCible IMC cible (par défaut 22, au milieu de la plage saine 18.5-25)
     * @return array Tableau contenant ['poids_ideal' => float, 'imc_min' => float, 'imc_max' => float, 'poids_min' => float, 'poids_max' => float]
     */
    public function calculerPoidsIdeal($taille = null, $imcCible = 22)
    {
        if ($taille === null) {
            return [
                'error' => 'Taille requise',
                'poids_ideal' => null
            ];
        }

        // Convertir la taille de cm en mètres
        $tailleEnMetres = $taille / 100;

        // Calcul: Poids = IMC × (Taille en m)²
        $poidsIdeal = round($imcCible * ($tailleEnMetres ** 2), 1);
        
        // Plage saine d'IMC (18.5 à 25)
        $imcMin = 18.5;
        $imcMax = 25;
        
        $poidsMin = round($imcMin * ($tailleEnMetres ** 2), 1);
        $poidsMax = round($imcMax * ($tailleEnMetres ** 2), 1);

        return [
            'poids_ideal' => $poidsIdeal,
            'poids_min' => $poidsMin,
            'poids_max' => $poidsMax,
            'imc_min' => $imcMin,
            'imc_max' => $imcMax,
            'taille' => $taille
        ];
    }

    /**
     * Retourne le poids idéal pour un utilisateur via AJAX ou paramètre
     * Accessible via GET /poids-ideal?taille=170 ou /poids-ideal?id_user=1
     */
    public function poidsIdeal()
    {
        $taille = $this->request->getGet('taille');
        $userId = $this->request->getGet('id_user');

        // Si l'ID utilisateur est fourni, récupérer sa taille
        if ($userId) {
            $model = new UtilisateurModel();
            $user = $model->find($userId);
            if ($user) {
                $taille = $user['taille'];
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Utilisateur non trouvé'
                ]);
            }
        }

        if (!$taille) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Taille requise'
            ]);
        }

        $resultat = $this->calculerPoidsIdeal((float)$taille);

        return $this->response->setJSON([
            'success' => true,
            'data' => $resultat
        ]);
    }

    public function regimes()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login');
        }

        $model = new UtilisateurModel();
        $userData = $model->find($user['id']);

        // Récupérer l'objectif actuel
        $utiliObj = new UtilisateurObjectifModel();
        $verifier = $utiliObj->where('id_Utilisateur', $user['id'])->first();

        $objectifActuel = null;
        if ($verifier != null) {
            $objectifModel = new ObjectifModel();
            $objectifActuel = $objectifModel->find($verifier['id_Objectif']);
        }

        // Récupérer tous les régimes
        $regimeModel = new RegimeModel();
        $allRegimes = $regimeModel->findAll();

        // Filtrer les régimes selon l'objectif
        $regimesAffichables = [];
        $infoObjectif = null;

        if ($objectifActuel) {
            $objectifId = $objectifActuel['id_Objectif'];

            if ($objectifId == 1) {
                // Objectif 1: Augmenter son poids
                $regimesAffichables = array_filter($allRegimes, function ($regime) {
                    return $regime['id_objectif'] == 1; // Prendre only les regimes augmentant le poids
                });
                $infoObjectif = 'Augmenter son poids';
            } elseif ($objectifId == 2) {
                // Objectif 2: Réduire son poids
                $regimesAffichables = array_filter($allRegimes, function ($regime) {
                    return $regime['id_objectif'] == 2; // Prendre only les regimes diminuant le poids
                });
                $infoObjectif = 'Réduire son poids';
            } elseif ($objectifId == 3) {
                // Objectif 3: Atteindre son IMC idéal
                $poidsIdeal = $this->calculerPoidsIdeal($userData['taille']);
                $poidsCible = $poidsIdeal['poids_ideal'];
                $poidsActuel = $userData['poids'];
                $ecart = $poidsActuel - $poidsCible;

                if ($ecart > 0) {
                    // Utilisateur doit perdre du poids - Objectif 2
                    $regimesAffichables = array_filter($allRegimes, function ($regime) {
                        return $regime['id_objectif'] == 2;
                    });
                    $infoObjectif = 'Atteindre votre IMC idéal (Perte de poids)';
                } else {
                    // Utilisateur doit prendre du poids - Objectif 1
                    $regimesAffichables = array_filter($allRegimes, function ($regime) {
                        return $regime['id_objectif'] == 1;
                    });
                    $infoObjectif = 'Atteindre votre IMC idéal (Augmentation de poids)';
                }

                return view('frontoffice/regimes', [
                    'user' => $userData,
                    'objectifActuel' => $objectifActuel,
                    'regimes' => $regimesAffichables,
                    'infoObjectif' => $infoObjectif,
                    'poidsIdeal' => $poidsIdeal,
                    'ecart' => abs($ecart)
                ]);
            }
        }

        $poidsIdeal = $this->calculerPoidsIdeal($userData['taille']);

        return view('frontoffice/regimes', [
            'user' => $userData,
            'objectifActuel' => $objectifActuel,
            'regimes' => $regimesAffichables,
            'infoObjectif' => $infoObjectif,
            'poidsIdeal' => $poidsIdeal,
            'ecart' => 0
        ]);
    }
}
