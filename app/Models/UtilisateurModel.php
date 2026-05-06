<?php

namespace App\Models;
use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'Utilisateur';
    protected $allowedFields = ['id_Utilisateur', 'nom', 'email', 'genre', 'motdepasse', 'taille', 'poids', 'estAdmin'];

}