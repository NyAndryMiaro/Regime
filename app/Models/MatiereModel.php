<?php

namespace App\Models;

use CodeIgniter\Model;

class MatiereModel extends Model
{
    protected $table = 'Matieres';
    protected $primaryKey = 'idMatiere';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'idMatiere',
        'Nom',
        'Credit',
        'idParcours',
        'idSemestre'
    ];
}
