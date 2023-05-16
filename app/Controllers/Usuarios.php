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
    public function viewEdit($id)
    {
        $rolModel = new AuxRolModel();
        $datos['usuarios'] = $this->userModel->getUser($id)[0];
        $datos['roles'] = $rolModel->getAll();
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');
        return view('editUser', $datos);
    }

    public function edit()
    {
        $id_usuario = $this->request->getPost('id_usuario');
        $id_rol = $this->request->getPost('id_rol');
        $pass = $this->request->getPost('pass');
        $passRepeat = $this->request->getPost('pass-repeat');
        $username = $this->request->getPost('username');

        // Validar el formulario manualmente
        $errors = $this->checkForm($id_usuario, $id_rol, $pass, $username, $passRepeat);

        if (empty($errors)) {
            if ($this->userModel->edit($username, $id_usuario, $pass, $id_rol)) {
                $_SESSION['mensaje']['texto'] = 'Se ha actualizado el usuario con éxito.';
                $_SESSION['mensaje']['class'] = 'success';

            } else {
                $_SESSION['mensaje']['texto'] = 'No se ha podido actualizar el usuario debido a un error desconocido.';
                $_SESSION['mensaje']['class'] = 'warning';
            }
            return redirect()->to('/usuarios');
        } else {
            // Mostrar errores en la vista
            $datos['errors'] = $errors;
        }
        $rolModel = new AuxRolModel();
        $datos['usuarios'] = $this->userModel->getUser($id_usuario)[0];
        $datos['roles'] = $rolModel->getAll();
        $datos['header'] = view('templates/header');
        $datos['footer'] = view('templates/footer');
        // Cargar la vista con los datos
        return view('editUser', $datos);
    }

    public function checkForm($id_usuario, $id_rol, $pass, $username, $passRepeat)
    {
        $errors = [];

        if (empty($id_usuario) || !is_numeric($id_usuario)) {
            $errors['id_usuario'] = 'El ID de usuario es inválido.';
        } 

        if (empty($id_rol) || !is_numeric($id_rol)) {
            $errors['id_rol'] = 'El ID de rol es inválido.';
        } elseif ($this->validate_role($id_rol)) {
            $errors['id_rol'] = 'El ID de rol no existe.';
        }

        if (empty($pass) || !preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/', $pass)) {
            $errors['pass'] = 'La contraseña debe tener 6 caracteres, una letra y un número.';
        }
        if ($passRepeat !== $pass) {
            $errors['pass-repeat'] = 'Las contraseñas deben coincidir.';
        }

        // Verificar si el nombre de usuario ya está en uso por otro usuario
        $existingUser = $this->userModel->getUser($id_usuario);
        if (!empty($existingUser) && $existingUser[0]['username'] !== $username && !$this->validate_username($username)) {
            $errors['username'] = 'El nombre de usuario ya está en uso.';
        } elseif (empty($username) || strlen($username) < 5) {
            $errors['username'] = 'El nombre de usuario es inválido.';
        }

        return $errors;
    }

    
    private function validate_role($id_rol)
    {
        $rolModel = new AuxRolModel();
        $rol = $rolModel->getRol($id_rol);
        return empty($rol);

    }

    private function validate_username($username)
    {
        $username = $this->userModel->getUserByUsername($username);
        return empty($username);
    }


}