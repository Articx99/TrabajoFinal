<?php 
namespace App\Models;

use CodeIgniter\Model;

class Tarea extends Model{
   
    const SELECT = "SELECT HEX(tareas.id) as id, tareas.id_tarea,tareas.id_estado, tareas.tarea, tareas.id_etiqueta, tareas.id_usuario, aux_estados.nombre_estado, usuarios.username, aux_etiquetas.nombre_etiqueta, aux_etiquetas.color_etiqueta ";
    const FROM = "FROM tareas LEFT JOIN aux_estados ON tareas.id_estado = aux_estados.id_estado LEFT JOIN usuarios ON tareas.id_usuario = usuarios.id_usuario LEFT JOIN aux_etiquetas ON tareas.id_etiqueta = aux_etiquetas.id ";
    const SELECTFROM = self::SELECT.self::FROM;
    protected $table = 'tareas';
    // Uncomment below if you want add primary key

    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'id_tarea','id_usuario', 'tarea', 'id_estado'];
    function getActive(){      
        $result= $this->query(self::SELECTFROM.'WHERE tareas.id_estado != 3 AND tareas.id_estado != 2 ORDER BY id_usuario, id')->getResultArray();           
        return $result;
    }

    function getAll(){      
        $result= $this->query(self::SELECTFROM.'WHERE tareas.id_estado != 3 ORDER BY id_usuario, id')->getResultArray();           
        return $result;
    }   
    function getTareasEtiqueta($id_etiqueta, $id_usuario, $active){ 
        $query = $active ? self::SELECTFROM.'WHERE tareas.id_estado != 3 AND tareas.id_etiqueta = ? AND tareas.id_usuario = ? ORDER BY id_usuario, id' : self::SELECTFROM.'WHERE tareas.id_estado != 3 AND tareas.id_estado != 2 AND tareas.id_etiqueta = ? AND tareas.id_usuario = ?  ORDER BY id_usuario, id';    
        $result= $this->query($query, [$id_etiqueta, $id_usuario])->getResultArray();           
        return $result;
    }
    function getTareasEtiquetaAdmin($id_etiqueta, $active){ 
        $query = $active ? self::SELECTFROM.'WHERE tareas.id_estado != 3 AND tareas.id_etiqueta = ? ORDER BY id_usuario, id' : self::SELECTFROM.'WHERE tareas.id_estado != 3 AND tareas.id_estado != 2 AND tareas.id_etiqueta = ?  ORDER BY id_usuario, id';    
        $result= $this->query($query, [$id_etiqueta])->getResultArray();           
        return $result;

    }
    function getEdit($id){      
        $result= $this->query(self::SELECTFROM.'WHERE tareas.id_estado != 3 AND tareas.id = UNHEX(?) ORDER BY id_usuario, id', [$id])->getResultArray()[0];           
        return $result;
    }
    function updateTask($tarea,$id,$id_etiqueta){
        $query = $this->query('UPDATE tareas SET tarea = ?, id_etiqueta = ? WHERE id = UNHEX(?)', [$tarea, $id_etiqueta,$id]);
        return $query;

    }
    function getDeleted(){
        $result= $this->query(self::SELECTFROM.'WHERE tareas.id_estado = 3 ORDER BY id_usuario, id_tarea')->getResultArray();           
        return $result;    
    }
    function getLastTask($id_tarea){       
        $query = $this->query('SELECT MAX(id_tarea) as max FROM tareas WHERE id_usuario = ?', $id_tarea)->getResultArray();
        $max_id = $query[0]['max']+1;
        return $max_id;
                 
    }
    
    function deleteTask ($id){
        $query = $this->query('UPDATE tareas SET id_estado = 3 WHERE id = UNHEX(?) ', [$id]);
        return $query;

    }
    function saveTask($datos){
        $query = $this->query('INSERT INTO tareas(id,id_tarea, id_usuario, tarea, id_estado, id_etiqueta) VALUES (UUID_SHORT(),?,?,?,?,?)', $datos);
        return $query;
    }
    function recoverTask($id){
        $query = $this->query('UPDATE tareas SET id_estado = 1 WHERE id = UNHEX(?)', [$id]);
        return $query;

    }
    function completeTask($id, $id_estado){
        $query = $this->query('UPDATE tareas SET id_estado = ? WHERE id = UNHEX(?)', [$id_estado, $id]);
        return $query;

    }

    function permaDelete($id){
        $query = $this->query("DELETE FROM tareas WHERE id = unhex(?)", [$id]);
        return $query;

    }

}