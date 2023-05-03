<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Login extends Controller
{
	const ADMINISTADOR = 1;
    
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function index()
    {
        helper(['form']);

        $data = [];

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'username' => 'required',
                'pass'     => 'required',
        ];

        $errors = [
            'username' => [
                'required' => 'El nombre de usuario es obligatorio',
            ],
            'pass' => [
                'required' => 'La contraseña es obligatoria',
        ],
            ];

            if (!$this->validate($rules, $errors)) {
                $data['error'] = $this->validator->getErrors();
            } else {
                

                $user = $this->userModel->where('username', $this->request->getVar('username'))
                    ->first();

                if (!$user || !password_verify($this->request->getVar('pass'), $user['pass'])) {
                    $data['error']['pass'] = 'El nombre de usuario o la contraseña son incorrectos';
                } else {
                    $this->setUserSession($user);
					
                    return redirect()->to('/');
                }
            }
        }

        echo view('login', $data);
    }

    private function setUserSession($user)
    {
        $data = [
            'id'         => $user['id_usuario'],
            'username'   => $user,
            'admin_panel' => '',
            'id_etiqueta' => 0
            
        ];
		if($user['id_rol'] == self::ADMINISTADOR){
			$data['admin_panel'] = 'rwd';
		}
        session()->set($data);
    }

	public function logout(){
        
		session()->destroy();
        
		return redirect()->to('/');
	}

    

}