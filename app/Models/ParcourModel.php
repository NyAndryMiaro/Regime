<?php

namespace App\Models;

use CodeIgniter\Model;

class ParcourModel extends Model
{
    protected $table = 'Parcours';
    protected $primaryKey = 'idParcours';
    protected $allowedFields = [
        'idParcours',
        'parcours'
    ];
}
