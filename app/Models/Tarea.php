<?php 
namespace App\Models;

use CodeIgniter\Model;

class Tarea extends Model{
   

    protected $table = 'tareas';
    // Uncomment below if you want add primary key

    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'id_usuario', 'tarea', 'id_estado'];
    function getAll(){      
        $result= $this->query('SELECT tareas.*, aux_estados.nombre_estado, usuarios.username FROM tareas LEFT JOIN aux_estados ON tareas.id_estado = aux_estados.id_estado LEFT JOIN usuarios ON tareas.id_usuario = usuarios.id_usuario WHERE tareas.id_estado != 3 ORDER BY id_usuario, id')->getResultArray();           
        return $result;
    }

    function getEdit($id_usuario, $id){      
        $result= $this->query('SELECT tareas.*, aux_estados.nombre_estado, usuarios.username FROM tareas LEFT JOIN aux_estados ON tareas.id_estado = aux_estados.id_estado LEFT JOIN usuarios ON tareas.id_usuario = usuarios.id_usuario WHERE tareas.id_estado != 3 AND tareas.id_usuario = ? AND tareas.id = ? ORDER BY id_usuario, id', [$id_usuario, $id])->getResultArray()[0];           
        return $result;
    }
    function updateTarea($tarea,$id_usuario,$id){
        $query = $this->query('UPDATE tareas SET tarea = ? WHERE id_usuario = ? AND id = ?', [$tarea, $id_usuario, $id]);
        return $query;

    }
    function getDeleted(){
        $result= $this->query('SELECT tareas.*, aux_estados.nombre_estado, usuarios.username FROM tareas LEFT JOIN aux_estados ON tareas.id_estado = aux_estados.id_estado LEFT JOIN usuarios ON tareas.id_usuario = usuarios.id_usuario WHERE tareas.id_estado = 3 ORDER BY id_usuario, id')->getResultArray();           
        return $result;    
    }
    function getLastTask($id){       
        $query = $this->query('SELECT MAX(id) as max FROM tareas WHERE id_usuario = ?', $id)->getResultArray();
        $max_id = $query[0]['max']+1;
        return $max_id;
                 
    }
    
    function deleteTarea($id_usuario,$id){
        $query = $this->query('UPDATE tareas SET id_estado = 3 WHERE id_usuario = ? AND id = ?', [$id_usuario, $id]);
        return $query;

    }
    function recuperarTarea($id_usuario,$id){
        $query = $this->query('UPDATE tareas SET id_estado = 1 WHERE id_usuario = ? AND id = ?', [$id_usuario, $id]);
        return $query;

    }

    function permaDelete($id_usuario,$id){
        $query = $this->query("DELETE FROM tareas WHERE id_usuario = ? AND id = ?", [$id_usuario, $id]);
        return $query;

    }

}