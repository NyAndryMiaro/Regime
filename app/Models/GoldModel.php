<?php

namespace App\Models;

use CodeIgniter\Model;

class GoldModel extends Model
{
    protected $table = 'Gold';
    protected $primaryKey = 'id_Gold';
    protected $allowedFields = ['id_Gold', 'remise', 'prix'];
}

