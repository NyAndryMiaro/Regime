<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifModel extends Model
{
    protected $table = 'Objectif';
    protected $primaryKey = 'id_Objectif';
    protected $allowedFields = ['id_Objectif', 'libelle'];
}

