<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Register extends Controller
{
    public function index()
    {
        helper(['form']);

        $data = [];

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'username'      => 'required|is_unique[usuarios.username]',
                'pass'          => 'required',
                'pass-repeat'   => 'required|matches[pass]',
            ];

            $errors = [
                'username' => [
                    'required'      => 'El nombre de usuario es obligatorio',
                    'is_unique'     => 'Este nombre de usuario ya está en uso',
                ],
                'pass' => [
                    'required' => 'La contraseña es obligatoria',
                ],
                'pass-repeat' => [
                    'required' => 'Por favor repita la contraseña',
                    'matches'  => 'Las contraseñas no coinciden',
                ],
            ];

            if (!$this->validate($rules, $errors)) {
                $data['error'] = $this->validator->getErrors();
            } else {
                $model = new UserModel();

                $newData = [
                    'username' => $this->request->getVar('username'),
                    'pass' => password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT),
                    'id_rol'  => 2, // Por defecto, los usuarios registrados tendrán rol 2 (Usuario)
                ];

                $model->save($newData);

                return redirect()->to('/login');
            }
        }

        return view('register', $data);
    }
}