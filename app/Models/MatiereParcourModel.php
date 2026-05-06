<?php

namespace App\Models;

use CodeIgniter\Model;

class MatiereParcourModel extends Model
{
    protected $table = 'MatiereParcours';
    protected $primaryKey = null;
    protected $compositeKey = ['idMatiere', 'idParcours'];
    protected $allowedFields = [
        'idMatiere',
        'idParcours',
        'Credit',
        'estObligatoire'
    ];
}
