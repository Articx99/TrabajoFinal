<?php 
namespace App\Models;

use CodeIgniter\Model;

class Etiqueta extends Model{
   

    protected $table = 'aux_etiquetas';
    // Uncomment below if you want add primary key

    protected $primaryKey = 'id_etiqueta';
    protected $allowedFields = ['id', 'id_etiqueta', 'nombre_etiqueta', 'id_usuario'];
    function getAll(){      
        $result= $this->query('SELECT aux_etiquetas.*, usuarios.username FROM aux_etiquetas LEFT JOIN usuarios ON aux_etiquetas.id_usuario = usuarios.id_usuario  ORDER BY id_etiqueta, id_usuario')->getResultArray();           
        return $result;
    }
    functioN getLastEtiqueta(){       
        $query = $this->query('SELECT MAX(id_etiqueta) as max FROM aux_etiquetas ')->getResultArray();
        $max_id = $query[0]['max']+1;
        return $max_id;
                 
    }
    function guardarEtiqueta($datos){
        $query = $this->query('INSERT INTO aux_etiquetas(id,id_etiqueta, nombre_etiqueta, id_usuario, color_etiqueta) VALUES (UUID_SHORT(),?,?,?,?)', $datos);
        return $query;
    }

    function deletEtiqueta($id){
        $query = $this->query("DELETE FROM aux_etiquetas WHERE id = ?", [$id]);
        return $query;

    }

    function getEdit($id){      
        $result= $this->query('SELECT * FROM aux_etiquetas WHERE  id = ? ORDER BY id, nombre_etiqueta', [$id])->getResultArray()[0];           
        return $result;
    }

    function edit($nombre_etiqueta,$color_etiqueta, $id){
        $query = $this->query('UPDATE aux_etiquetas SET nombre_etiqueta = ?, color_etiqueta = ? WHERE id = ?', [$nombre_etiqueta, $color_etiqueta, $id]);
        return $query;

    }

    

}