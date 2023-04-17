<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table = 'usuarios';
	protected $allowedFields = ['username', 'pass'];

	function getAll(){      
        $result= $this->query('SELECT usuarios.*, aux_roles.nombre_rol FROM usuarios LEFT JOIN aux_roles ON usuarios.id_rol = aux_roles.id_rol  ORDER BY id_usuario')->getResultArray();           
        return $result;
    }
    
    function deleteUsuario($id_usuario){
        $query = $this->query('DELETE usuarios WHERE id_usuario = ?', [$id_usuario]);
        return $query;

    }
}