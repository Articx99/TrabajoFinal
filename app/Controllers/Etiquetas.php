<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\etiqueta;

class Etiquetas extends Controller
{
    private $etiqueta;

    public function __construct()
    {
        $this->etiqueta = new Etiqueta();
    }

    public function showAll()
    {
        $etiquetas = $this->etiqueta->getAll();

        return view('etiquetas', [
            'header' => view('templates/header'),
            'footer' => view('templates/footer'),
            'etiquetas' => $etiquetas,
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
        return view('index', [
            'header' => view('templates/header'),
            'footer' => view('templates/footer'),
            'etiquetas' => $this->etiqueta->getDeleted(),
            'borrador' => true,
        ]);
    }

    public function saveEtiqueta()
    {
        $contenidoEtiqueta = $this->request->getVar('nombre_etiqueta');
        $id_usuario = $this->request->getVar('id_usuario');
        $color_etiqueta = $this->request->getVar('color_etiqueta');

        $datos = [
            $this->etiqueta->getLastEtiqueta(),
            $contenidoEtiqueta,
            $id_usuario,
            $color_etiqueta
        ];

        if ($this->etiqueta->guardarEtiqueta($datos)) {
            session()->setFlashdata('mensaje', ['texto' => 'Se ha guardado la etiqueta con éxito.', 'class' => 'success']);
        } else {
            session()->setFlashdata('mensaje', ['texto' => 'No se ha podido guardar la etiqueta por un error desconocido.', 'class' => 'warning']);
        }

        return redirect()->to(site_url('/etiquetas'));
    }

    public function complete()
    {
        $id = $this->request->getVar('id');
        $id_usuario = $this->request->getVar('id_usuario');
        $id_estado = $this->request->getVar('id_estado');

        if ($this->etiqueta->completeTask($id_usuario, $id, $id_estado)) {
            session()->setFlashdata('mensaje', ['texto' => 'Se ha completado la etiqueta con éxito.', 'class' => 'success']);
        } else {
            session()->setFlashdata('mensaje', ['texto' => 'No se ha podido completar la etiqueta por un error desconocido.', 'class' => 'warning']);
        }

        return redirect()->to(site_url('/'));
    }

    public function delete()
    {
        $id = $this->request->getVar('id');
        $id_usuario = $this->request->getVar('id_usuario');

        if ($this->etiqueta->deleteetiqueta($id_usuario, $id)) {
            session()->setFlashdata('mensaje', ['texto' => 'Se ha eliminado la etiqueta con éxito.', 'class' => 'success']);
        } else {
            session()->setFlashdata('mensaje', ['texto' => 'No se ha podido eliminar la etiqueta por un error desconocido.', 'class' => 'warning']);
        }

        return redirect()->to(site_url('/'));
    }
    public function permaDelete()
    {
        $id = $this->request->getVar('id');
        $id_usuario = $this->request->getVar('id_usuario');

        if ($this->etiqueta->permaDelete($id_usuario, $id)) {
            $texto = "Se ha eliminado la etiqueta con éxito.";
            $class = "success";
        } else {
            $texto = "No se ha podido eliminar la etiqueta por un error desconocido.";
            $class = "warning";
        }

        $_SESSION['mensaje']['texto'] = $texto;
        $_SESSION['mensaje']['class'] = $class;

        return redirect()->to($this->request->getServer('HTTP_REFERER'));
    }

    public function recuperaretiqueta($id_usuario, $id)
    {
        if ($this->etiqueta->recuperaretiqueta($id_usuario, $id)) {
            $texto = "Se ha recuperado la etiqueta con éxito.";
            $class = "success";
        } else {
            $texto = "No se ha podido recuperar la etiqueta por un error desconocido.";
            $class = "warning";
        }

        $_SESSION['mensaje']['texto'] = $texto;
        $_SESSION['mensaje']['class'] = $class;

        return redirect()->to($this->request->getServer('HTTP_REFERER'));
    }

    public function viewEdit($id_usuario, $id)
    {
        $datos['etiquetas'] = $this->etiqueta->getEdit($id_usuario, $id);
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');

        return view('editetiqueta', $datos);
    }
    public function edit()
    {     
        $contenidoetiqueta = $this->request->getVar('task');
        $id = $this->request->getVar('id');
        $id_usuario = $this->request->getVar('id_usuario');
        if ($this->etiqueta->updateetiqueta($contenidoetiqueta, $id_usuario, $id)) {
            $_SESSION['mensaje']['texto'] = "Se ha atualizado la etiqueta con éxito.";
            $_SESSION['mensaje']['class'] = "success";
        } else {
            $_SESSION['mensaje']['texto'] = "No se ha podido actualizar la etiqueta por un error desconocido.";
            $_SESSION['mensaje']['class'] = "warning";
        }

        return $this->response->redirect(site_url('/'));
    }
}
