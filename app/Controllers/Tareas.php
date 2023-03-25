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
        $datos['sidebar'] = view('templates/sidebar');
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
        
        if($tarea->where('id',$id)->delete($id)){
            $_SESSION['mensaje']['texto'] = "Se ha eliminado la tarea con éxito.";
            $_SESSION['mensaje']['class'] = "success";
        }
        else{
            $_SESSION['mensaje']['texto'] = "No se ha podido eliminar la tarea por un error desconocido."; 
            $_SESSION['mensaje']['class'] = "warning";  
        }
       
        return $this->response->redirect(site_url('/tareas'));
    }
    public function edit($id){
        $tarea = new Tarea();
        
        if($tarea->where('id',$id)->update($id)){
            $_SESSION['mensaje']['texto'] = "Se ha eliminado la tarea con éxito.";
            $_SESSION['mensaje']['class'] = "success";
        }
        else{
            $_SESSION['mensaje']['texto'] = "No se ha podido eliminar la tarea por un error desconocido."; 
            $_SESSION['mensaje']['class'] = "warning";  
        }
       
        return $this->response->redirect(site_url('/tareas'));
    }

}