<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeModel extends Model
{
    protected $table = 'Codes';
    protected $primaryKey = 'idCode';
    protected $allowedFields = ['idCode', 'code', 'montant', 'utilise'];
}

