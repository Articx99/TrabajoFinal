<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\AuxRolModel;

class usuarios extends Controller
{
    private $userModel;
    private $validation;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->validation = \Config\Services::validation();
    }
    public function getUsers()
    {
        $rolModel = new AuxRolModel();
        $datos['usuarios'] = $this->userModel->getAll();
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');
        $datos['roles'] = $rolModel->getAll();
        return view('users', $datos);


    }

    public function deleteUser()
    {

        $id_usuario = $this->request->getVar('id');
        if ($id_usuario == $_SESSION['id']) {
            $_SESSION['mensaje']['texto'] = "No te puedes eliminar a ti mismo.";
            $_SESSION['mensaje']['class'] = "danger";
        } else {

            if ($this->userModel->deleteUser($id_usuario)) {
                $_SESSION['mensaje']['texto'] = "Se ha borrado el usuario con éxito.";
                $_SESSION['mensaje']['class'] = "success";
            } else {
                $_SESSION['mensaje']['texto'] = "No se ha podido borrar el usuario por un error desconocido.";

                $_SESSION['mensaje']['class'] = "warning";
            }
        }
        return redirect()->to('/usuarios');
    }

    public function saveUser()
    {
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'username' => 'required|is_unique[usuarios.username]',
                'pass' => 'required',
                'pass-repeat' => 'required|matches[pass]',
            ];

            $errors = [
                'username' => [
                    'required' => 'El nombre de usuario es obligatorio',
                    'is_unique' => 'Este nombre de usuario ya está en uso',
                ],
                'pass' => [
                    'required' => 'La contraseña es obligatoria',
                ],
                'pass-repeat' => [
                    'required' => 'Por favor repita la contraseña',
                    'matches' => 'Las contraseñas no coinciden',
                ],
            ];

            if (!$this->validation->setRules($rules, $errors)->run($this->request->getPost())) {
                $datos['error'] = $this->validation->getErrors();
            } else {
                $datos = [
                    $this->request->getVar('username'),
                    password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT),
                    $this->request->getVar('id_rol')
                ];
                if ($this->userModel->createUser($datos)) {
                    session()->setFlashdata('mensaje', ['texto' => 'Se ha guardado el usuario con éxito.', 'class' => 'success']);
                } else {
                    session()->setFlashdata('mensaje', ['texto' => 'No se ha podido guardar el usuario por un error desconocido.', 'class' => 'warning']);
                }
            }
            
        }
        $rolModel = new AuxRolModel();
        $datos['usuarios'] = $this->userModel->getAll();
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');
        $datos['roles'] = $rolModel->getAll();
        return view('users', $datos);

    }

}