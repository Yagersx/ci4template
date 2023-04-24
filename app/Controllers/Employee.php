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
            'title' => 'Empleados',
            'subtitle' => 'Lista de Empleados'
        ];

        $data['employees'] = $this->employeesModel->findAll();

        return view('employees/list', $data);
    }

    public function create()
    {
        if ($this->request->is('get')) {
            $data = [
                'title' => 'Empleados',
                'subtitle' => 'Crear Empleado'
            ];

            return view('employees/create_update', $data);
        }

        $rules = [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|valid_email',
            'phone' => 'required|numeric',
            'address' => 'string',
            'position' => 'numeric',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]'
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

    public function edit($id)
    {

        if ($this->request->is('get')) {
            $data = [
                'title' => 'Empleados',
                'subtitle' => 'Editar Empleado',
                'id' => $id
            ];

            $employee = model('App\Models\Employees')->find($id);

            if (!$employee) {
                $this->session->setFlashdata('msg', ['type' => 'error', 'body' => 'El empleado no existe.']);
                return redirect()->to('/employees');
            }

            $data['employee'] = $employee;

            return view('employees/create_update', $data);
        }
    }

    public function delete($id)
    {
        $employee = model('App\Models\Employees')->find($id);

        if (!$employee) {
            $this->session->setFlashdata('msg', ['type' => 'error', 'body' => 'El empleado no existe.']);
            return redirect()->to('/employees');
        }

        model('App\Models\Employees')->delete($id);

        $this->session->setFlashdata('msg', ['type' => 'success', 'body' => 'El empleado se ha eliminado correctamente.']);

        return redirect()->to('/employees');
    }
}