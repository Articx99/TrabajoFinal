<?php 
namespace App\Models;

use CodeIgniter\Model;

class Tarea extends Model{
   

    protected $table = 'tareas';
    // Uncomment below if you want add primary key

    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'id_usuario', 'tarea', 'id_estado'];
    function getAll(){      
        $result= $this->query('SELECT tareas.*, aux_estados.nombre_estado, usuarios.username FROM tareas LEFT JOIN aux_estados ON tareas.id_estado = aux_estados.id_estado LEFT JOIN usuarios ON tareas.id_usuario = usuarios.id_usuario')->getResultArray();           
        return $result;
    }

}