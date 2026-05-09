<?php

namespace App\Models;
use CodeIgniter\Model;

class UtilisateurObjectifModel extends Model
{
    protected $table = 'UtilisateurObjectif';
    protected $primaryKey = 'id_UtilisateurObjectif';
    protected $allowedFields = ['id_UtilisateurObjectif', 'id_Utilisateur', 'id_Objectif'];

    protected $returnType = 'array';
}