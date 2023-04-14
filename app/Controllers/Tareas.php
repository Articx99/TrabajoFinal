<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Tarea;
class Tareas extends Controller{
    public function index(){  
        
        $tareas = new Tarea();
        
        $datos['tareas'] = $tareas->getAll();
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');
        return view('index',$datos);


    }

    public function guardar(){

        $tarea = new Tarea();
        $contenidoTarea=$this->request->getVar('task');
        $id_usuario=$this->request->getVar('id_usuario');
        $datos=[
            'tarea' => $contenidoTarea,
            'id_usuario' => $id_usuario,
            'id_estado' => 1
        ];
        if($tarea->insert($datos)){
            $_SESSION['mensaje']['texto'] = "Se ha guardado la tarea con éxito.";
            $_SESSION['mensaje']['class'] = "success";
        }
        else{
            $_SESSION['mensaje']['texto'] = "No se ha podido guardar la tarea por un error desconocido."; 
            $_SESSION['mensaje']['class'] = "warning";  
        }
       
        return $this->response->redirect(site_url('/'));

    }

    public function delete($id){
        $tarea = new Tarea();
        
        if($tarea->where('id',$id)->delete($id)){
            $tarea->
            $_SESSION['mensaje']['texto'] = "Se ha eliminado la tarea con éxito.";
            $_SESSION['mensaje']['class'] = "success";
        }
        else{
            $_SESSION['mensaje']['texto'] = "No se ha podido eliminar la tarea por un error desconocido."; 
            $_SESSION['mensaje']['class'] = "warning";  
        }
       
        return $this->response->redirect(site_url('/'));
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
       
        return $this->response->redirect(site_url('/'));
    }

}