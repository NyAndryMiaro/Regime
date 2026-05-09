<?php

namespace App\Controllers;

use App\Models\ActivitesModel;

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
}
