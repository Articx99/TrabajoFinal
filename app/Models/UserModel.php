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
    
    function deleteUser($id_usuario){
        $query = $this->query('DELETE FROM usuarios WHERE id_usuario = ?', [$id_usuario]);
        return $query;
    }

    function createUser($data){
        $query = $this->query( 'INSERT INTO usuarios (username, pass, id_rol) VALUES (?,?,?)', $data);
        return $query;
    }
    function getUser($id_usuario){
        $query = $this->query( 'SELECT * FROM usuarios WHERE id_usuario = ?', $id_usuario)->getResultArray();
        return $query;
    }
}