<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\Password;
use App\Models\Employees;

class Employee extends BaseController
{

    private $employeesModel;
    public function __construct()
    {
        $this->employeesModel = new Employees();
    }

    public function index()
    {
        $data = [
            'title' => 'Lista de Empleados'
        ];

        $data['employees'] = $this->employeesModel->findAll();

        return view('employees/list', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Crear Empleado',
            'action' => 'create',
            'positions' => model('App\Models\Positions')->findAll()
        ];

        if ($this->request->is('get')) {
            return view('employees/create_update', $data);
        }

        $rules = [
            'name' => [
                'label' => 'Nombre',
                'rules' => 'required|alpha_numeric_space',
            ],
            'last_name' => [
                'label' => 'Apellido',
                'rules' => 'required|alpha_numeric_space',
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
            ],
            'phone' => [
                'label' => 'Teléfono',
                'rules' => 'required|numeric',
            ],
            'address' => [
                'label' => 'Dirección',
                'rules' => 'alpha_numeric_punct',
            ],
            'position' => [
                'label' => 'Posición',
                'rules' => 'numeric',
            ],
            'password' => [
                'label' => 'Contraseña',
                'rules' => 'required|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/]',
                'errors' => [
                    'required' => 'El campo Contraseña es requerido.',
                    'regex_match' => 'El campo Contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.'
                ]
            ],
            'password_confirm' => [
                'label' => 'Confirmar Contraseña',
                'rules' => 'required|matches[password]',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $hashedPassword = Password::generatePassword($this->request->getPost('password'));

        $employee = [
            'name' => $this->request->getPost('name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'position' => $this->request->getPost('position'),
            'password' => $hashedPassword
        ];

        $this->employeesModel->insert($employee);

        $this->session->setFlashdata('msg', ['type' => 'success', 'body' => 'El empleado se ha creado correctamente.']);

        return redirect()->to('/employees');
    }

    public function edit($id = null)
    {

        $id = $id ?? $this->request->getPost('id') ?? null;

        if (!isset($id) && !is_numeric($id)) {
            $this->session->setFlashdata('msg', ['type' => 'error', 'body' => 'El id del empleado es requerido.']);
            return redirect()->to('/employees');
        }

        $data = [
            'title' => 'Editar Empleado',
            'action' => 'edit',
            'id' => $id,
            'positions' => model('App\Models\Positions')->findAll()
        ];

        if ($this->request->is('get')) {
            $employee = $this->employeesModel->find($id);

            if (!$employee) {
                $this->session->setFlashdata('msg', ['type' => 'error', 'body' => 'El empleado no existe.']);
                return redirect()->to('/employees');
            }

            $data['employee'] = $employee;
            return view('employees/create_update', $data);
        }

        $rules = [
            'name' => [
                'label' => 'Nombre',
                'rules' => 'required|alpha_numeric_space',
            ],
            'last_name' => [
                'label' => 'Apellido',
                'rules' => 'required|alpha_numeric_space',
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
            ],
            'phone' => [
                'label' => 'Teléfono',
                'rules' => 'required|numeric',
            ],
            'address' => [
                'label' => 'Dirección',
                'rules' => 'alpha_numeric_punct',
            ],
            'position' => [
                'label' => 'Posición',
                'rules' => 'numeric',
            ]
        ];

        // If password is not empty, add password rules
        // If password is empty, it means that the user doesn't want to change the password
        if (!empty($this->request->getPost('password'))) {
            $rules['password'] = [
                'label' => 'Contraseña',
                'rules' => 'required|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/]',
                'errors' => [
                    'required' => 'El campo Contraseña es requerido.',
                    'regex_match' => 'El campo Contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.'
                ]
            ];

            $rules['password_confirm'] = [
                'label' => 'Confirmar Contraseña',
                'rules' => 'required|matches[password]',
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updatedEmployee = [
            'name' => $this->request->getPost('name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'position' => $this->request->getPost('position')
        ];

        if (!empty($this->request->getPost('password'))) {
            $updatedEmployee['password'] = Password::generatePassword($this->request->getPost('password'));
        }

        $this->employeesModel->update($id, $updatedEmployee);

        $this->session->setFlashdata('msg', ['type' => 'success', 'body' => 'El empleado se ha actualizado correctamente.']);

        return redirect()->to('/employees');
    }

    public function delete($id)
    {
        $employee = $this->employeesModel->find($id);

        if (!$employee) {
            $this->session->setFlashdata('msg', ['type' => 'error', 'body' => 'El empleado no existe.']);
            return redirect()->to('/employees');
        }

        $this->employeesModel->delete($id);

        $this->session->setFlashdata('msg', ['type' => 'success', 'body' => 'El empleado se ha eliminado correctamente.']);

        return redirect()->to('/employees');
    }
}