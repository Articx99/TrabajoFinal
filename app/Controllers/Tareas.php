<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Tarea;
use App\Models\Etiqueta;

class Tareas extends Controller
{
    private $tarea;

    public function __construct()
    {
        $this->tarea = new Tarea();
    }

    public function index()
    {
       
        //$tareas = $showAll === 'true' ? $this->tarea->getAll() : $this->tarea->getActive();
        $tareas = [];
        $etiquetaModel = new Etiqueta();
        $etiquetas = $etiquetaModel->getAll(); 
        foreach($etiquetas as $etiqueta){
            $showAll = session('showAll'.$etiqueta['id_etiqueta']);
            $active = $showAll == 'true' ? true : false;
            $tareas[$etiqueta['nombre_etiqueta']] = $this->tarea->getTareasEtiqueta($etiqueta['id_etiqueta'], $active);
        }
        return view('index', [
            'header' => view('templates/header'),
            'footer' => view('templates/footer'),
            'etiquetas' => $etiquetas,
            'tareas' => $tareas
        ]);
    }

    public function etiquetas()
    {


        return view('etiquetas', [
            'header' => view('templates/header'),
            'footer' => view('templates/footer'),
        ]);
    }

    public function about()
    {
        return view('about', [
            'header' => view('templates/header'),
            'footer' => view('templates/footer'),
        ]);
    }
    
    public function getCompleted()
    {
        session()->set('showAll', $this->request->getVar('showAll'));

        return redirect()->to(site_url('/'));
    }

    public function borrador()
    {
        return view('borrador', [
            'header' => view('templates/header'),
            'footer' => view('templates/footer'),
            'tareas' => $this->tarea->getDeleted(),
            'borrador' => true,
        ]);
    }

    public function guardar()
    {
        $contenidoTarea = $this->request->getVar('task');
        $id_usuario = $this->request->getVar('id_usuario');
        $id_etiqueta = $this->request->getVar('id_etiqueta');
        
        $datos = [
            $this->tarea->getLastTask($id_usuario),
            $id_usuario,
            $contenidoTarea,        
            1,
            $id_etiqueta
        ];
       
        if ($this->tarea->guardarTarea($datos)) {
            session()->setFlashdata('mensaje', ['texto' => 'Se ha guardado la tarea con éxito.', 'class' => 'success']);
        } else {
            session()->setFlashdata('mensaje', ['texto' => 'No se ha podido guardar la tarea por un error desconocido.', 'class' => 'warning']);
        }
        return redirect()->to(site_url('/'));
       
    }

    public function complete()
    {
        $id = $this->request->getVar('id');
        $id_usuario = $this->request->getVar('id_usuario');
        $id_estado = $this->request->getVar('id_estado');

        if ($this->tarea->completeTask($id_usuario, $id, $id_estado)) {
            session()->setFlashdata('mensaje', ['texto' => 'Se ha completado la tarea con éxito.', 'class' => 'success']);
        } else {
            session()->setFlashdata('mensaje', ['texto' => 'No se ha podido completar la tarea por un error desconocido.', 'class' => 'warning']);
        }

        return redirect()->to(site_url('/'));
    }

    public function delete()
    {
        $id = $this->request->getVar('id');
        $id_usuario = $this->request->getVar('id_usuario');

        if ($this->tarea->deleteTarea($id_usuario, $id)) {
            session()->setFlashdata('mensaje', ['texto' => 'Se ha eliminado la tarea con éxito.', 'class' => 'success']);
        } else {
            session()->setFlashdata('mensaje', ['texto' => 'No se ha podido eliminar la tarea por un error desconocido.', 'class' => 'warning']);
        }

        return redirect()->to(site_url('/'));
    }
    public function permaDelete()
    {
        $id = $this->request->getVar('id');
        $id_usuario = $this->request->getVar('id_usuario');

        if ($this->tarea->permaDelete($id_usuario, $id)) {
            $texto = "Se ha eliminado la tarea con éxito.";
            $class = "success";
        } else {
            $texto = "No se ha podido eliminar la tarea por un error desconocido.";
            $class = "warning";
        }

        $_SESSION['mensaje']['texto'] = $texto;
        $_SESSION['mensaje']['class'] = $class;

        return redirect()->to($this->request->getServer('HTTP_REFERER'));
    }

    public function recuperarTarea($id_usuario, $id)
    {
        if ($this->tarea->recuperarTarea($id_usuario, $id)) {
            $texto = "Se ha recuperado la tarea con éxito.";
            $class = "success";
        } else {
            $texto = "No se ha podido recuperar la tarea por un error desconocido.";
            $class = "warning";
        }

        $_SESSION['mensaje']['texto'] = $texto;
        $_SESSION['mensaje']['class'] = $class;

        return redirect()->to($this->request->getServer('HTTP_REFERER'));
    }

    public function viewEdit($id_usuario, $id)
    {
        $datos['tareas'] = $this->tarea->getEdit($id_usuario, $id);
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');

        return view('editTarea', $datos);
    }
    public function edit()
    {     
        $contenidoTarea = $this->request->getVar('task');
        $id = $this->request->getVar('id');
        $id_usuario = $this->request->getVar('id_usuario');
        if ($this->tarea->updateTarea($contenidoTarea, $id_usuario, $id)) {
            $_SESSION['mensaje']['texto'] = "Se ha atualizado la tarea con éxito.";
            $_SESSION['mensaje']['class'] = "success";
        } else {
            $_SESSION['mensaje']['texto'] = "No se ha podido actualizar la tarea por un error desconocido.";
            $_SESSION['mensaje']['class'] = "warning";
        }

        return $this->response->redirect(site_url('/'));
    }

}