<?php

namespace App\Models;
use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'Utilisateur';
    protected $primaryKey = 'id_Utilisateur';
    protected $allowedFields = ['id_Utilisateur', 'nom', 'email', 'genre', 'motdepasse', 'taille', 'poids', 'argent', 'estAdmin'];

    function toGold($id, $prix) {
        $this->db->table($this->table)
            ->set('estGold', TRUE)
            ->set('argent', $prix)
            ->where('id_Utilisateur', $id)
            ->update();
    }
}