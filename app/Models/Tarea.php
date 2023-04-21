<?php 
namespace App\Models;

use CodeIgniter\Model;

class Tarea extends Model{
   
    const SELECT = "SELECT tareas.*, aux_estados.nombre_estado, usuarios.username, aux_etiquetas.nombre_etiqueta, aux_etiquetas.color_etiqueta ";
    const FROM = "FROM tareas LEFT JOIN aux_estados ON tareas.id_estado = aux_estados.id_estado LEFT JOIN usuarios ON tareas.id_usuario = usuarios.id_usuario LEFT JOIN aux_etiquetas ON tareas.id_etiqueta = aux_etiquetas.id_etiqueta ";
    const SELECTFROM = self::SELECT.self::FROM;
    protected $table = 'tareas';
    // Uncomment below if you want add primary key

    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'id_usuario', 'tarea', 'id_estado'];
    function getActive(){      
        $result= $this->query(self::SELECTFROM.'WHERE tareas.id_estado != 3 AND tareas.id_estado != 2 ORDER BY id_usuario, id')->getResultArray();           
        return $result;
    }

    function getAll(){      
        $result= $this->query(self::SELECTFROM.'WHERE tareas.id_estado != 3 ORDER BY id_usuario, id')->getResultArray();           
        return $result;
    }   
    function getTareasEtiqueta($id_etiqueta, $active){ 
        $query = $active ? self::SELECTFROM.'WHERE tareas.id_estado != 3 AND tareas.id_estado != 2 AND tareas.id_etiqueta = ?  ORDER BY id_usuario, id' : self::SELECTFROM.'WHERE tareas.id_estado != 3 AND tareas.id_etiqueta = ? ORDER BY id_usuario, id';    
        $result= $this->query($query, [$id_etiqueta])->getResultArray();           
        return $result;
    }

    function getEdit($id_usuario, $id){      
        $result= $this->query(self::SELECTFROM.'WHERE tareas.id_estado != 3 AND tareas.id_usuario = ? AND tareas.id = ? ORDER BY id_usuario, id', [$id_usuario, $id])->getResultArray()[0];           
        return $result;
    }
    function updateTarea($tarea,$id_usuario,$id){
        $query = $this->query('UPDATE tareas SET tarea = ? WHERE id_usuario = ? AND id = ?', [$tarea, $id_usuario, $id]);
        return $query;

    }
    function getDeleted(){
        $result= $this->query(self::SELECTFROM.'WHERE tareas.id_estado = 3 ORDER BY id_usuario, id')->getResultArray();           
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
    function guardarTarea($datos){
        $query = $this->query('INSERT INTO tareas(id, id_usuario, tarea, id_estado, id_etiqueta) VALUES (?,?,?,?,?)', $datos);
        return $query;
    }
    function recuperarTarea($id_usuario,$id){
        $query = $this->query('UPDATE tareas SET id_estado = 1 WHERE id_usuario = ? AND id = ?', [$id_usuario, $id]);
        return $query;

    }
    function completeTask($id_usuario,$id, $id_estado){
        $query = $this->query('UPDATE tareas SET id_estado = ? WHERE id_usuario = ? AND id = ?', [$id_estado,$id_usuario, $id]);
        return $query;

    }

    function permaDelete($id_usuario,$id){
        $query = $this->query("DELETE FROM tareas WHERE id_usuario = ? AND id = ?", [$id_usuario, $id]);
        return $query;

    }

}