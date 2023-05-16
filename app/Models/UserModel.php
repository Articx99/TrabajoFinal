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
    function getUserByUsername($username){
        $query = $this->query( 'SELECT * FROM usuarios WHERE username = ?', $username)->getResultArray();
        return $query;
    }
    function edit($username,$id_usuario, $pass,$id_rol){
        $securePass = password_hash($pass, PASSWORD_DEFAULT);
        $query = $this->query('UPDATE usuarios SET username = ?, id_rol = ?, pass = ? WHERE id_usuario = ?', [$username, $id_rol,$securePass, $id_usuario]);
        return $query;

    }
}