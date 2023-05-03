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
        $id_estado = $this->request->getVar('id_estado');

        if ($this->etiqueta->completeTask($id, $id_estado)) {
            session()->setFlashdata('mensaje', ['texto' => 'Se ha completado la etiqueta con éxito.', 'class' => 'success']);
        } else {
            session()->setFlashdata('mensaje', ['texto' => 'No se ha podido completar la etiqueta por un error desconocido.', 'class' => 'warning']);
        }

        return redirect()->to(site_url('/'));
    }

    public function delete()
    {
        $id = $this->request->getVar('id');
        if ($this->etiqueta->deletEtiqueta($id)) {
            session()->setFlashdata('mensaje', ['texto' => 'Se ha eliminado la etiqueta con éxito.', 'class' => 'success']);
        } else {
            session()->setFlashdata('mensaje', ['texto' => 'No se ha podido eliminar la etiqueta por un error desconocido.', 'class' => 'warning']);
        }

        return redirect()->to(site_url('/'));
    }

    public function viewEdit($id)
    {
        $datos['etiquetas'] = $this->etiqueta->getEdit($id);
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');

        return view('editEtiqueta', $datos);
    }
    public function edit()
    {     
        $nombre_etiqueta = $this->request->getVar('nombre_etiqueta');
        $color_etiqueta = $this->request->getVar('color_etiqueta');
        $id = $this->request->getVar('id');
        
        if ($this->etiqueta->edit($nombre_etiqueta, $color_etiqueta, $id)) {
            $_SESSION['mensaje']['texto'] = "Se ha atualizado la etiqueta con éxito.";
            $_SESSION['mensaje']['class'] = "success";
        } else {
            $_SESSION['mensaje']['texto'] = "No se ha podido actualizar la etiqueta por un error desconocido.";
            $_SESSION['mensaje']['class'] = "warning";
        }

        return $this->response->redirect(site_url('/etiquetas'));
    }
}
