<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
class usuarios extends Controller{
    public function getUsers(){  
        
        $usuarios = new UserModel();
        
        $datos['usuarios'] = $usuarios->getAll();
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');
        return view('users',$datos);


    }

    public function deleteUsuario($id_usuario){
        $tarea = new UserModel();
        
        if($tarea->deleteUsuario($id_usuario)){
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