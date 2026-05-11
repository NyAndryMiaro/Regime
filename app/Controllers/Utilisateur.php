<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use App\Models\ObjectifModel;
use App\Models\UtilisateurObjectifModel;
use App\Models\CodeModel;
use App\Models\RegimeModel;
use App\Models\GoldModel;

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
            'estAdmin' => $user['estAdmin'],
            'estGold' => $user['estGold']
        ]);

        if ($user['estAdmin'] == 1) {
            $users = $model->findAll();
            return view('/backoffice/accueil-admin', ['users' => $users]);
        }

        $utiliObj = new UtilisateurObjectifModel();
        $verifier = $utiliObj->where('id_Utilisateur', $user['id_Utilisateur'])->first();

        $objectif = new ObjectifModel();
        $obj = $objectif->findAll();

        $objectif = new ObjectifModel();
        $obj = $objectif->findAll();

        $utiliObj = new UtilisateurObjectifModel();
        $verifier = $utiliObj->where('id_Utilisateur', $user['id'])->first();

        $objectifActuel = null;
        if ($verifier != null) {
            $objectifActuel = $objectif->find($verifier['id_Objectif']);
        }

        $regimeModel = new RegimeModel();
        $regimes = $regimeModel->findAll();
        
        $activiteModel = new \App\Models\ActivitesModel();
        $activites = $activiteModel->findAll();

        if ($verifier != null) {
            $but = $objectif->find($verifier['id_Objectif']);
        return view('frontoffice/accueil', [
            'user' => $user,
            'objectifs' => $obj,
            'objectif' => $objectifActuel,
            'regimes' => $regimes,
            'activites' => $activites
        ]);
        } else {
        return view('frontoffice/accueil', [
            'user' => $user,
            'objectifs' => $obj,
            'objectif' => $objectifActuel,
            'regimes' => $regimes,
            'activites' => $activites
        ]);
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

        $objectifActuel = null;
        if ($verifier != null) {
            $objectifActuel = $objectif->find($verifier['id_Objectif']);
        }

        $regimeModel = new RegimeModel();
        $regimes = $regimeModel->findAll();
        
        $activiteModel = new \App\Models\ActivitesModel();
        $activites = $activiteModel->findAll();

        return view('frontoffice/accueil', [
            'user' => $userData,
            'objectifs' => $obj,
            'objectif' => $objectifActuel,
            'regimes' => $regimes,
            'activites' => $activites
        ]);
    }

    public function accueilAdmin()
    {
        $user = session()->get('user');
        if (!$user || !$user['estAdmin']) {
            return redirect()->to('/login');
        }

        $userModel = new UtilisateurModel();
        $codeModel = new CodeModel();

        $users = $userModel->findAll();
        $codesEnAttente = $codeModel->where('utilise', 1)->findAll();

        foreach ($codesEnAttente as &$code) {
            $owner = !empty($code['id_Utilisateur']) ? $userModel->find($code['id_Utilisateur']) : null;
            $code['nom_utilisateur'] = $owner['nom'] ?? 'Utilisateur inconnu';
            $code['email_utilisateur'] = $owner['email'] ?? '—';
        }
        unset($code);

        return view('backoffice/accueil-admin', [
            'users' => $users,
            'codesEnAttente' => $codesEnAttente,
            'nbCodesEnAttente' => count($codesEnAttente),
        ]);
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
            return redirect()->to('/login');
        }

        $objectifId = $this->request->getPost('objectif');

        if (!$objectifId) {
            return redirect()->back()->with('error', 'Veuillez sélectionner un objectif.');
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

            $successMsg = 'Objectif modifié avec succès ! Vous avez maintenant pour objectif : ' . ($objectif['libelle'] ?? '');
            return redirect()->to('/accueil')->with('success', $successMsg);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function porteMonnaie()
    {
        $user = session()->get('user');

        if (!$user) {
            return redirect()->to('/login');
        }

        $util = new UtilisateurModel();
        $utilisateur = $util->find($user['id']);

        return view('frontoffice/porte-monnaie', ['user' => $utilisateur]);
    }

    public function entrerCode()
    {
        $user = session()->get('user');

        if (!$user) {
            return redirect()->to('/login');
        }

        $code = trim((string) $this->request->getPost('codeArgent'));

        if ($code === '') {
            return redirect()->to('/monnaie')->with('error', 'Veuillez saisir un code.');
        }

        $codemodel = new CodeModel();
        $argent = $codemodel->where('code', $code)->first();

        if (!$argent) {
            return redirect()->to('/monnaie')->with('error', 'Le code inscrit n’est pas disponible.');
        }

        $statut = (int) ($argent['utilise'] ?? 0);

        if ($statut === 2) {
            return redirect()->to('/monnaie')->with('error', 'Ce code a déjà été utilisé.');
        }

        if ($statut === 1) {
            return redirect()->to('/monnaie')->with('error', 'Ce code est déjà en attente de validation.');
        }

        $codemodel->update($argent['idCode'], [
            'utilise' => 1,
            'id_Utilisateur' => $user['id'],
        ]);

        return redirect()->to('/monnaie')->with('success', 'Votre code a été envoyé à l’administration. En attente de réponse.');
    }

    public function accepterCode($idCode)
    {
        $user = session()->get('user');
        if (!$user || !$user['estAdmin']) {
            return redirect()->to('/login');
        }

        $codeModel = new CodeModel();
        $userModel = new UtilisateurModel();
        $code = $codeModel->find($idCode);

        if (!$code || (int) ($code['utilise'] ?? 0) !== 1) {
            return redirect()->to('/accueilAdmin')->with('error', 'Ce code n’est pas en attente de validation.');
        }

        $idUtilisateur = (int) ($code['id_Utilisateur'] ?? 0);
        $utilisateur = $userModel->find($idUtilisateur);

        if (!$utilisateur) {
            return redirect()->to('/accueilAdmin')->with('error', 'Utilisateur introuvable pour ce code.');
        }

        $nouvelArgent = (float) ($utilisateur['argent'] ?? 0) + (float) ($code['montant'] ?? 0);

        $userModel->update($idUtilisateur, [
            'argent' => $nouvelArgent,
        ]);

        $codeModel->update($idCode, [
            'utilise' => 2,
        ]);

        return redirect()->to('/accueilAdmin')->with('success', 'Code accepté et crédit ajouté.');
    }

    public function rejeterCode($idCode)
    {
        $user = session()->get('user');
        if (!$user || !$user['estAdmin']) {
            return redirect()->to('/login');
        }

        $codeModel = new CodeModel();
        $code = $codeModel->find($idCode);

        if (!$code || (int) ($code['utilise'] ?? 0) !== 1) {
            return redirect()->to('/accueilAdmin')->with('error', 'Ce code n’est pas en attente de validation.');
        }

        $codeModel->update($idCode, [
            'utilise' => 0,
            'id_Utilisateur' => null,
        ]);

        return redirect()->to('/accueilAdmin')->with('success', 'Code refusé et remis disponible.');
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

        $tailleEnMetres = $taille / 100;
        $poidsIdeal = round($imcCible * ($tailleEnMetres ** 2), 1);
        
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

    public function poidsIdeal()
    {
        $taille = $this->request->getGet('taille');
        $userId = $this->request->getGet('id_user');

        if ($userId) {
            $model = new UtilisateurModel();
            $user = $model->find($userId);
            if ($user) {
                $taille = $user['taille'];
            } else {
                return redirect()->to('/accueil')->with('error', 'Utilisateur non trouvé.');
            }
        }

        if (!$taille) {
            return redirect()->to('/accueil')->with('error', 'Taille requise.');
        }

        $resultat = $this->calculerPoidsIdeal((float) $taille);

        return redirect()->to('/accueil')->with('poidsIdeal', $resultat);
    }

    public function regimes()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login');
        }

        $model = new UtilisateurModel();
        $userData = $model->find($user['id']);

        $utiliObj = new UtilisateurObjectifModel();
        $verifier = $utiliObj->where('id_Utilisateur', $user['id'])->first();

        $objectifActuel = null;
        if ($verifier != null) {
            $objectifModel = new ObjectifModel();
            $objectifActuel = $objectifModel->find($verifier['id_Objectif']);
        }

        $regimeModel = new RegimeModel();
        $allRegimes = $regimeModel->findAll();

        $poidsIdeal = $this->calculerPoidsIdeal($userData['taille']);

        $isGold = !empty($userData['estGold']);
        $remise = 0;
        if ($isGold) {
            $gold = (new GoldModel())->first();
            if ($gold) {
                $remise = (float) $gold['remise'];
            }
        }

        $regimesAffichables = [];
        $infoObjectif = null;
        $regimeRecommandeIndex = -1;

        if ($objectifActuel) {
            $objectifId = $objectifActuel['id_Objectif'];

            if ($objectifId == 1) {
                $regimesAffichables = array_filter($allRegimes, function ($regime) {
                    return $regime['id_objectif'] == 1;
                });
                $infoObjectif = 'Augmenter son poids';
                $regimeRecommandeIndex = $this->trouverRegimeRecommande($regimesAffichables, $userData['poids'], $poidsIdeal['poids_ideal']);
            } elseif ($objectifId == 2) {
                $regimesAffichables = array_filter($allRegimes, function ($regime) {
                    return $regime['id_objectif'] == 2;
                });
                $infoObjectif = 'Réduire son poids';
                $regimeRecommandeIndex = $this->trouverRegimeRecommande($regimesAffichables, $userData['poids'], $poidsIdeal['poids_ideal']);
            } elseif ($objectifId == 3) {
                $poidsCible = $poidsIdeal['poids_ideal'];
                $poidsActuel = $userData['poids'];
                $ecart = $poidsActuel - $poidsCible;

                if ($ecart > 0) {
                    $regimesAffichables = array_filter($allRegimes, function ($regime) {
                        return $regime['id_objectif'] == 2;
                    });
                    $infoObjectif = 'Atteindre votre IMC idéal (Perte de poids)';
                } else {
                    $regimesAffichables = array_filter($allRegimes, function ($regime) {
                        return $regime['id_objectif'] == 1;
                    });
                    $infoObjectif = 'Atteindre votre IMC idéal (Augmentation de poids)';
                }

                $regimeRecommandeIndex = $this->trouverRegimeRecommande($regimesAffichables, $userData['poids'], $poidsIdeal['poids_ideal']);

                return view('frontoffice/regimes', [
                    'user' => $userData,
                    'objectifActuel' => $objectifActuel,
                    'regimes' => $regimesAffichables,
                    'infoObjectif' => $infoObjectif,
                    'poidsIdeal' => $poidsIdeal,
                    'ecart' => abs($ecart),
                    'regimeRecommandeIndex' => $regimeRecommandeIndex,
                    'isGold' => $isGold,
                    'remise' => $remise
                ]);
            }
        }

        return view('frontoffice/regimes', [
            'user' => $userData,
            'objectifActuel' => $objectifActuel,
            'regimes' => $regimesAffichables,
            'infoObjectif' => $infoObjectif,
            'poidsIdeal' => $poidsIdeal,
            'ecart' => 0,
            'regimeRecommandeIndex' => $regimeRecommandeIndex,
            'isGold' => $isGold,
            'remise' => $remise
        ]);
    }

    private function trouverRegimeRecommande($regimes, $poidsActuel, $poidsIdeal)
    {
        $meilleureIndex = -1;
        $meilleureEcart = PHP_FLOAT_MAX;

        foreach ($regimes as $index => $regime) {
            $poidsFinal = $poidsActuel + $regime['variation_poids'];
            $ecart = abs($poidsFinal - $poidsIdeal);
            
            if ($ecart < $meilleureEcart) {
                $meilleureEcart = $ecart;
                $meilleureIndex = $index;
            }
        }

        return $meilleureIndex;
    }

    public function activites()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login');
        }

        $model = new UtilisateurModel();
        $userData = $model->find($user['id']);

        $utiliObj = new UtilisateurObjectifModel();
        $verifier = $utiliObj->where('id_Utilisateur', $user['id'])->first();

        $objectifActuel = null;
        if ($verifier != null) {
            $objectifModel = new ObjectifModel();
            $objectifActuel = $objectifModel->find($verifier['id_Objectif']);
        }

        $activiteModel = new \App\Models\ActivitesModel();
        $allActivites = $activiteModel->findAll();

        $poidsIdeal = $this->calculerPoidsIdeal($userData['taille']);

        $activitesAffichables = [];
        $infoObjectif = null;
        $activiteRecommandeIndex = -1;

        if ($objectifActuel) {
            $objectifId = $objectifActuel['id_Objectif'];

            if ($objectifId == 1) {
                $activitesAffichables = array_filter($allActivites, function ($activite) {
                    return $activite['id_Objectif'] == 1;
                });
                $infoObjectif = 'Augmenter son poids';
                $activiteRecommandeIndex = $this->trouverActiviteRecommande($activitesAffichables, $userData['poids'], $poidsIdeal['poids_ideal']);
            } elseif ($objectifId == 2) {
                $activitesAffichables = array_filter($allActivites, function ($activite) {
                    return $activite['id_Objectif'] == 2;
                });
                $infoObjectif = 'Réduire son poids';
                $activiteRecommandeIndex = $this->trouverActiviteRecommande($activitesAffichables, $userData['poids'], $poidsIdeal['poids_ideal']);
            } elseif ($objectifId == 3) {
                $poidsCible = $poidsIdeal['poids_ideal'];
                $poidsActuel = $userData['poids'];
                $ecart = $poidsActuel - $poidsCible;

                if ($ecart > 0) {
                    $activitesAffichables = array_filter($allActivites, function ($activite) {
                        return $activite['id_Objectif'] == 2;
                    });
                    $infoObjectif = 'Atteindre votre IMC idéal (Perte de poids)';
                } else {
                    $activitesAffichables = array_filter($allActivites, function ($activite) {
                        return $activite['id_Objectif'] == 1;
                    });
                    $infoObjectif = 'Atteindre votre IMC idéal (Augmentation de poids)';
                }

                $activiteRecommandeIndex = $this->trouverActiviteRecommande($activitesAffichables, $userData['poids'], $poidsIdeal['poids_ideal']);

                return view('frontoffice/activites', [
                    'user' => $userData,
                    'objectifActuel' => $objectifActuel,
                    'activites' => $activitesAffichables,
                    'infoObjectif' => $infoObjectif,
                    'poidsIdeal' => $poidsIdeal,
                    'ecart' => abs($ecart),
                    'activiteRecommandeIndex' => $activiteRecommandeIndex
                ]);
            }
        }

        return view('frontoffice/activites', [
            'user' => $userData,
            'objectifActuel' => $objectifActuel,
            'activites' => $activitesAffichables,
            'infoObjectif' => $infoObjectif,
            'poidsIdeal' => $poidsIdeal,
            'ecart' => 0,
            'activiteRecommandeIndex' => $activiteRecommandeIndex
        ]);
    }

    private function trouverActiviteRecommande($activites, $poidsActuel, $poidsIdeal)
    {
        $meilleureIndex = -1;
        $meilleureEcart = PHP_FLOAT_MAX;

        foreach ($activites as $index => $activite) {
            $poidsFinal = $poidsActuel + $activite['variation_poids'];
            $ecart = abs($poidsFinal - $poidsIdeal);
            
            if ($ecart < $meilleureEcart) {
                $meilleureEcart = $ecart;
                $meilleureIndex = $index;
            }
        }

        return $meilleureIndex;
    }

    public function plan()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login');
        }

        $model = new UtilisateurModel();
        $userData = $model->find($user['id']);

        $utiliObj = new UtilisateurObjectifModel();
        $verifier = $utiliObj->where('id_Utilisateur', $user['id'])->first();

        if (!$verifier) {
            return redirect()->to('/objectif')->with('error', 'Veuillez d\'abord choisir un objectif');
        }

        $objectifModel = new ObjectifModel();
        $objectif = $objectifModel->find($verifier['id_Objectif']);

        $poidsIdeal = $this->calculerPoidsIdeal($userData['taille']);
        $poidsCible = $poidsIdeal['poids_ideal'];
        $poidsActuel = $userData['poids'];
        $ecart = $poidsActuel - $poidsCible;

        $regimeModel = new RegimeModel();
        $activiteModel = new \App\Models\ActivitesModel();

        if ($objectif['id_Objectif'] == 3) {
            if ($ecart > 0) {
                $regimesAffichables = $regimeModel->where('id_objectif', 2)->findAll();
                $activitesAffichables = $activiteModel->where('id_Objectif', 2)->findAll();
            } else {
                $regimesAffichables = $regimeModel->where('id_objectif', 1)->findAll();
                $activitesAffichables = $activiteModel->where('id_Objectif', 1)->findAll();
            }
        } else {
            $regimesAffichables = $regimeModel->where('id_objectif', $objectif['id_Objectif'])->findAll();
            $activitesAffichables = $activiteModel->where('id_Objectif', $objectif['id_Objectif'])->findAll();
        }

        $regimeRecommandeIndex = $this->trouverRegimeRecommande($regimesAffichables, $userData['poids'], $poidsCible);
        $activiteRecommandeIndex = $this->trouverActiviteRecommande($activitesAffichables, $userData['poids'], $poidsCible);

        $regime = $regimesAffichables[$regimeRecommandeIndex] ?? $regimesAffichables[0];
        $activite = $activitesAffichables[$activiteRecommandeIndex] ?? $activitesAffichables[0];

        return view('frontoffice/plan', [
            'user' => $userData,
            'objectif' => $objectif,
            'regime' => $regime,
            'activite' => $activite,
            'poidsIdeal' => $poidsIdeal,
            'ecart' => abs($ecart)
        ]);
    }
}
