<?php

namespace App\Models;

use CodeIgniter\Model;

class AuxRolModel extends Model
{
	protected $table = 'aux_roles';
	protected $allowedFields = ['id_rol', 'nombre_rol'];

	function getAll(){      
        $result= $this->query('SELECT * FROM aux_roles ORDER BY id_rol')->getResultArray();           
        return $result;
    }

    function getRol($id_rol){      
        $result= $this->query('SELECT * FROM aux_roles WHERE id_rol = ? ORDER BY id_rol', [$id_rol])->getResultArray();           
        return $result;
    }
    
}