<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Tarea;

class Tareas extends Controller
{
    public function index()
    {
        $tareas = new Tarea();
        if ($_SESSION['showAll'] == 'true') {
            $datos['tareas'] = $tareas->getAll();
        } else {

            $datos['tareas'] = $tareas->getActive();
        }

        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');
        return view('index', $datos);
    }
    public function about()
    {
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');
        return view('about', $datos);
    }
    public function getCompleted()
    {
        $showAll = $this->request->getVar('showAll');
        session()->set('showAll', $showAll);
        return $this->response->redirect(site_url('/'));
    }
    public function borrador()
    {
        $tareas = new Tarea();
        $datos['tareas'] = $tareas->getDeleted();
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');
        $datos['borrador'] = true;
        return view('index', $datos);
    }

    public function guardar()
    {

        $tarea = new Tarea();
        $contenidoTarea = $this->request->getVar('task');
        $id_usuario = $this->request->getVar('id_usuario');
        $datos = [
            'id' => $tarea->getLastTask($id_usuario),
            'tarea' => $contenidoTarea,
            'id_usuario' => $id_usuario,

        ];
        if ($tarea->insert($datos) == 0) {
            $_SESSION['mensaje']['texto'] = "Se ha guardado la tarea con éxito.";
            $_SESSION['mensaje']['class'] = "success";
        } else {
            $_SESSION['mensaje']['texto'] = "No se ha podido guardar la tarea por un error desconocido.";
            $_SESSION['mensaje']['class'] = "warning";
        }

        return $this->response->redirect(site_url('/'));

    }
    public function complete()
    {

        $tarea = new Tarea();
        $id = $this->request->getVar('id');
        $id_usuario = $this->request->getVar('id_usuario');
        $id_estado = $this->request->getVar('id_estado');

        if ($tarea->completeTask($id_usuario, $id, $id_estado)) {
            $_SESSION['mensaje']['texto'] = "Se ha completado la tarea con éxito.";
            $_SESSION['mensaje']['class'] = "success";
        } else {
            $_SESSION['mensaje']['texto'] = "No se ha podido completar la tarea por un error desconocido.";
            $_SESSION['mensaje']['class'] = "warning";
        }

        return $this->response->redirect(site_url('/'));

    }

    public function delete()
    {
        $tarea = new Tarea();
        $id = $this->request->getVar('id');
        $id_usuario = $this->request->getVar('id_usuario');
        if ($tarea->deleteTarea($id_usuario, $id)) {
            $_SESSION['mensaje']['texto'] = "Se ha eliminado la tarea con éxito.";
            $_SESSION['mensaje']['class'] = "success";
        } else {
            $_SESSION['mensaje']['texto'] = "No se ha podido eliminar la tarea por un error desconocido.";
            $_SESSION['mensaje']['class'] = "warning";
        }

        return $this->response->redirect(site_url('/'));
    }
    public function permaDelete()
    {
        $tarea = new Tarea();
        $id = $this->request->getVar('id');
        $id_usuario = $this->request->getVar('id_usuario');
        if ($tarea->permaDelete($id_usuario, $id)) {
            $_SESSION['mensaje']['texto'] = "Se ha eliminado la tarea con éxito.";
            $_SESSION['mensaje']['class'] = "success";
        } else {
            $_SESSION['mensaje']['texto'] = "No se ha podido eliminar la tarea por un error desconocido.";
            $_SESSION['mensaje']['class'] = "warning";
        }

        return $this->response->redirect(site_url('/borrador'));
    }

    public function recuperarTarea($id_usuario, $id)
    {
        $tarea = new Tarea();

        if ($tarea->recuperarTarea($id_usuario, $id)) {
            $_SESSION['mensaje']['texto'] = "Se ha recuperado la tarea con éxito.";
            $_SESSION['mensaje']['class'] = "success";
        } else {
            $_SESSION['mensaje']['texto'] = "No se ha podido recuperar la tarea por un error desconocido.";
            $_SESSION['mensaje']['class'] = "warning";
        }

        return $this->response->redirect(site_url('/borrador'));
    }
    public function viewEdit($id_usuario, $id)
    {
        $tareas = new Tarea();

        $datos['tareas'] = $tareas->getEdit($id_usuario, $id);
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');
        return view('editTarea', $datos);
    }
    public function edit()
    {
        $tarea = new Tarea();
        $contenidoTarea = $this->request->getVar('task');
        $id = $this->request->getVar('id');
        $id_usuario = $this->request->getVar('id_usuario');
        if ($tarea->updateTarea($contenidoTarea, $id_usuario, $id)) {
            $_SESSION['mensaje']['texto'] = "Se ha atualizado la tarea con éxito.";
            $_SESSION['mensaje']['class'] = "success";
        } else {
            $_SESSION['mensaje']['texto'] = "No se ha podido actualizar la tarea por un error desconocido.";
            $_SESSION['mensaje']['class'] = "warning";
        }

        return $this->response->redirect(site_url('/'));
    }

}