<?php

namespace App\Models;

use CodeIgniter\Model;

class SemestreModel extends Model
{
    protected $table = 'Semestres';
    protected $primaryKey = 'idSemestre';
    protected $allowedFields = [
        'idSemestre',
        'libelle'
    ];
}
