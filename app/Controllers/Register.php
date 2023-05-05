<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Register extends Controller
{
    protected $validation;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        helper(['form']);

        $data = [];

        if ($this->request->getMethod() == 'post') {
            $rules = ['username' => 'required|min_length[4]|is_unique[usuarios.username]', 'pass' => 'required|min_length[6]|regex_match[/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/]', 'pass-repeat' => 'required|matches[pass]',];

            $errors = [
                'username' => ['required' => 'El nombre de usuario es obligatorio', 'min_length' => 'El nombre de usuario debe tener al menos 4 caracteres', 'is_unique' => 'Este nombre de usuario ya está en uso',
                ],
                'pass' => ['required' => 'La contraseña es obligatoria', 'min_length' => 'La contraseña debe tener al menos 6 caracteres', 'regex_match' => 'La contraseña debe contener al menos una letra y un número',
                ],
                'pass-repeat' => ['required' => 'Por favor repita la contraseña', 'matches' => 'Las contraseñas no coinciden',
                ],
            ];

            if (!$this->validation->setRules($rules, $errors)->run($this->request->getPost())) {
                $data['error'] = $this->validation->getErrors();
            } else {
                $model = new UserModel();

                $newData = [
                    $this->request->getVar('username'),
                    password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT),
                    2
                ];

                $model->createUser($newData);

                return redirect()->to('/login');
            }
        }

        return view('register', $data);
    }
}