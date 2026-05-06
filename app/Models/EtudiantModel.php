<?php

namespace App\Models;

use CodeIgniter\Model;

class EtudiantModel extends Model
{
    protected $table = 'Etudiants';
    protected $primaryKey = 'ETU';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'ETU',
        'Nom',
        'Prenom',
        'DateNaissance',
        'domaine'
    ];
}