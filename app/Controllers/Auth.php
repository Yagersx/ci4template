<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\Password;
use App\Libraries\CustomEmail;
use App\Models\Employees;

class Auth extends BaseController
{

    private $employeesModel;
    private $email;
    public function __construct()
    {
        $this->employeesModel = new Employees();
        $this->email = new CustomEmail();
    }

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

        $employee = $this->employeesModel->where('email', $email)->first();

        if (!$employee) {
            return redirect()->back()->withInput()->with('msg', ['type' => 'danger', 'body' => 'El usuario o contraseña son invalidos. Intentelo de nuevo.']);
        }

        if (!Password::verifyPassword($password, $employee->password)) {
            return redirect()->back()->withInput()->with('msg', ['type' => 'danger', 'body' => 'El usuario o contraseña son invalidos. Intentelo de nuevo.']);

        }

        $employeeSession = [
            'employee_id' => $employee->employee_id,
            'name' => $employee->name,
            'last_name' => $employee->last_name,
            'email' => $employee->email,
            'phone' => $employee->phone,
            'position_id' => $employee->position_id
        ];

        $this->session->set('isLoggedIn', true);
        $this->session->set('isAdmin', $employee->is_admin == 1 ? true : false);
        $this->session->set('employee', $employeeSession);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/');
    }

    public function resetPassword()
    {
        $token = $this->request->getGet('token') ?? $this->request->getPost('token') ?? null;

        if (!$token) {
            return redirect()->to('/')->with('msg', ['type' => 'danger', 'body' => 'El token es invalido.']);
        }

        $incomingData = [
            'token' => $token
        ];

        $tokenRules = [
            'token' => 'required|alpha_numeric'
        ];

        if (!$this->validateData($incomingData, $tokenRules)) {
            return redirect()->back()->withInput()->with('msg', ['type' => 'danger', 'body' => 'El token es invalido.']);
        }

        $employee = $this->employeesModel->where('token', $token, true)->first();

        if (!$employee) {
            return redirect()->to('/')->with('msg', ['type' => 'danger', 'body' => 'El token es invalido.']);
        }

        $data = [
            'title' => 'Restablecer Contraseña',
            'token' => $token
        ];

        if ($this->request->is('get')) {
            return view('auth/reset_password', $data);
        }

        $rules = [
            'password' => [
                'label' => 'Contraseña',
                'rules' => 'required|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/]',
                'errors' => [
                    'required' => 'El campo Contraseña es requerido.',
                    'regex_match' => 'El campo Contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.'
                ]
            ],
            'confirm_password' => [
                'label' => 'Confirmar Contraseña',
                'rules' => 'required|matches[password]',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $password = $this->request->getPost('password');

        $this->employeesModel->update($employee->employee_id, [
            'password' => Password::generateHashedPassword($password),
            'token' => null,
            'confirmed' => 1
        ]);

        return redirect()->to('/')->with('msg', ['type' => 'success', 'body' => 'La contraseña se ha reestablecido correctamente.']);
    }

    public function forgotPassword()
    {
        $data = [
            'title' => 'Recuperar Contraseña'
        ];

        if ($this->request->is('get')) {
            return view('auth/forgot_password', $data);
        }

        $rules = [
            'email' => [
                'label' => 'Correo Electrónico',
                'rules' => 'required|valid_email',
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');

        $employee = $this->employeesModel->where('email', $email)->first();

        if ($employee) {
            $token = Password::generateToken();

            $this->employeesModel->update($employee->employee_id, [
                'token' => $token
            ]);

            //No se retorna mensaje de error si el correo no se envia correctamente para evitar que se sepa si el correo existe o no.
            $this->email->sendResetPasswordEmail($employee->email, $token);
        }

        //Tampoco se retorna mensaje de exito para evitar que se sepa si el correo/usuario existe o no.
        return redirect()->to('/')->with('msg', ['type' => 'success', 'body' => 'Si hay una cuenta asociada al correo proporcionado, se enviara un enlace para reestablecer la contraseña.']);
    }
}