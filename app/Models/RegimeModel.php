<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'Regime';
    protected $primaryKey = 'id_Regime';
    protected $allowedFields = ['id_Regime', 'id_objectif', 'libelle', 'duree', 'variation_poids', 'prix_unitaire', 'pourcentage_viande', 'pourcentage_poisson', 'pourcentage_legume'];


    function getRegimeObjectid()
    {
        return $this->db->table($this->table)
            ->select('Regime.*, Objectif.libelle lib_objectif')
            ->join('Objectif', 'Objectif.id_Objectif = Regime.id_Objectif')
            ->get()
            ->getResultArray();
    }
}
