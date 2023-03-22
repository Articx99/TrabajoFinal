<?php 
namespace App\Models;

use CodeIgniter\Model;

class Tarea extends Model{
    protected $table      = 'tareas';
    // Uncomment below if you want add primary key

    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'id_usuario', 'tarea', 'id_estado'];

    


}