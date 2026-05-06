<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model
{
    protected $table = 'Notes';
    protected $primaryKey = 'idNote';
    protected $allowedFields = [
        'idEtudiant',
        'idMatiere',
        'idParcours',
        'valeur',
        'resultat',
    ];
    
}
