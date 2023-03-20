<?php

namespace App\Models;

use CodeIgniter\Model;

class TareasModel extends Model{
    protected $table = 'tareas';
    
    public function getTareas($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
    
}