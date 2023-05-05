<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Tarea;
use App\Models\Etiqueta;
use App\Models\UserModel;

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
        $etiquetas = $_SESSION['admin_panel'] == 'rwd' ? $etiquetaModel->getAll() : $etiquetaModel->getUserTag($_SESSION['id']);
        $id_usuario = session('id');
        foreach ($etiquetas as $etiqueta) {
            if ($etiqueta['id_usuario'] === session('id') || session('admin_panel') == 'rwd') {
                $showAll = session('showAll' . $etiqueta['id']);
                $active = $showAll == 'true' ? true : false;
                $tareas[$etiqueta['nombre_etiqueta']] = session('admin_panel') == 'rwd' ? $this->tarea->getTareasEtiquetaAdmin($etiqueta['id'], $active) : $this->tarea->getTareasEtiqueta($etiqueta['id'], $id_usuario, $active);
            }
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
        session()->set('showAll' . $this->request->getVar('etiqueta'), $this->request->getVar('showAll'));
        return redirect()->to('/');
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

    public function save()
    {
       
        $usuario = new UserModel();
        $etiqueta = new Etiqueta();
        $contenidoTarea = $this->request->getVar('task');
        $id_usuario = $this->request->getVar('id_usuario');
        $id_etiqueta = $this->request->getVar('id_etiqueta');

        // Validar que el contenido de la tarea, el id de usuario y el id de etiqueta no estén vacíos o nulos
        if (empty($contenidoTarea) || is_null($id_usuario) || is_null($id_etiqueta)) {
            session()->setFlashdata('mensaje', ['texto' => 'El contenido de la tarea no puede estar vacio.', 'class' => 'warning']);
            return redirect()->to('/');
        }

        // Validar que el id de usuario y el id de etiqueta existan en la base de datos
        $usuarioExiste = $usuario->getUser($id_usuario);
        $etiquetaExiste = $etiqueta->getTag($id_etiqueta);
       
        if (count($usuarioExiste) === 0 || count($etiquetaExiste) === 0) {
            session()->setFlashdata('mensaje', ['texto' => count($etiquetaExiste), 'class' => 'warning']);
            return redirect()->to('/');
        }
        $datos = [
            $this->tarea->getLastTask($id_usuario,$id_etiqueta),
            $id_usuario,
            $contenidoTarea,
            1,
            $id_etiqueta
        ];
        session()->set(['id_etiqueta' => $id_etiqueta]);
        if ($this->tarea->saveTask($datos)) {
            session()->setFlashdata('mensaje', ['texto' => 'Se ha guardado la tarea con éxito.', 'class' => 'success']);
        } else {
            session()->setFlashdata('mensaje', ['texto' => 'No se ha podido guardar la tarea por un error desconocido.', 'class' => 'warning']);
        }
        return redirect()->to('/');

    }

    public function complete()
    {

        $id = $this->request->getVar('id');
        $id_estado = $this->request->getVar('id_estado');

        if ($this->tarea->completeTask($id, $id_estado)) {
            session()->setFlashdata('mensaje', ['texto' => 'Se ha completado la tarea con éxito.', 'class' => 'success']);
        } else {
            session()->setFlashdata('mensaje', ['texto' => 'No se ha podido completar la tarea por un error desconocido.', 'class' => 'warning']);
        }

        return redirect()->to('/');
    }

    public function delete()
    {
        $id = $this->request->getVar('id');
        if ($this->tarea->deleteTask($id)) {
            session()->setFlashdata('mensaje', ['texto' => 'Se ha eliminado la tarea con éxito.', 'class' => 'success']);
        } else {
            session()->setFlashdata('mensaje', ['texto' => 'No se ha podido eliminar la tarea por un error desconocido.', 'class' => 'warning']);
        }

        return redirect()->to('/');
    }
    public function permaDelete()
    {
        $id = $this->request->getVar('id');
        if ($this->tarea->permaDelete($id)) {
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

    public function recoverTask($id)
    {
        if ($this->tarea->recoverTask($id)) {
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

    public function viewEdit($id, $id_etiqueta)
    {
        $etiquetaModel = new Etiqueta();
        $etiquetas = $etiquetaModel->getAll();
        $datos['tareas'] = $this->tarea->getEdit($id);
        $datos['id_etiqueta'] = $id_etiqueta;
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');
        $datos['etiquetas'] = $etiquetas;

        return view('editTarea', $datos);
    }
    public function edit()
    {
        $contenidoTarea = $this->request->getVar('task');
        $id_etiqueta = $this->request->getVar('id_etiqueta');
        $id = $this->request->getVar('id');

        if ($this->tarea->updateTask($contenidoTarea, $id, $id_etiqueta)) {
            $_SESSION['mensaje']['texto'] = "Se ha atualizado la tarea con éxito.";
            $_SESSION['mensaje']['class'] = "success";
        } else {
            $_SESSION['mensaje']['texto'] = "No se ha podido actualizar la tarea por un error desconocido.";
            $_SESSION['mensaje']['class'] = "warning";
        }

        return $this->response->redirect('/');
    }


}