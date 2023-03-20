<?php

namespace App\Controllers;

use App\Models\TareasModel;

class Tareas extends BaseController
{
    public function index()
    {
        $model = model(TareasModel::class);

        $data = [
            'tareas'  => $model->getTareas(),
            'title' => 'Gestor de tareas',
        ];

        return view('templates/header', $data)
            . view('pages/tareas')
            . view('templates/footer');
    }
    

    public function view($slug = null)
    {
        $model = model(TareasModel::class);
        
        $data['tareas'] = $model->getTareas($slug);
        
        if (empty($data['tareas'])) {
            throw new PageNotFoundException('Cannot find the tareas item: ' . $slug);
        }

        $data['title'] = "Gestor tareas";

        return view('templates/header', $data)
            . view('pages/tareas')
            . view('templates/footer');
    }
}