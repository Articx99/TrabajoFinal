<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Tarea;
class Tareas extends Controller{
    public function index(){  
        
        $tareas = new Tarea();
        $datos['tareas'] = $tareas->orderBy('id', 'AS')->findAll();
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');
        return view('tareas/ver',$datos);


    }

    public function guardar(){

        $tarea = new Tarea();
        $contenidoTarea=$this->request->getVar('task');
        $datos=[
            'tarea' => $contenidoTarea
        ];
        $tarea->insert($datos);

        echo "Ingresado a la base de datos.";

    }

    public function delete($id){
        $tarea = new Tarea();
        $datos = [];
        if($tarea->delete($id)){
            $datos['mensaje']['texto'] = "Se ha eliminado la tarea con éxito.";
            $datos['mensaje']['class'] = "success";
        }
        else{
            $datos['mensaje']['texto'] = "No se ha podido eliminar la tarea por un error desconocido."; 
            $datos['mensaje']['class'] = "warning";  
        }
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');
        return view('tareas/ver',$datos);
    }

}