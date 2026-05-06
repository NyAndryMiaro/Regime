<?php

namespace App\Models;
use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'Utilisateur';
    protected $allowedFields = ['id_user', 'nom_user', 'password_user', 'email'];

}