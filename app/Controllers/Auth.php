<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $employeesModel = model('App\Models\Employees');

        $employee = $employeesModel->where('email', $email)->first();

        if (!$employee) {
            return redirect()->back()->withInput()->with('errors', ['email' => 'El usuario o contraseña son invalidos. Intentelo de nuevo.']);
        }

        if (!password_verify($password, $employee->password)) {
            return redirect()->back()->withInput()->with('errors', ['password' => 'El usuario o contraseña son invalidos. Intentelo de nuevo.']);
        }

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/');
    }

}