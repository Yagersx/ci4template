<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\Password;
use App\Models\Employees;
use App\Libraries\CustomEmail;

class Employee extends BaseController
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
        $data = [
            'title' => 'Lista de Empleados',
        ];

        $data['employees'] = $this->employeesModel
            ->select('employees.*, positions.*')
            ->join('positions', 'positions.position_id = employees.position_id')
            ->findAll();

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

        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $employee = [
            'name' => $this->request->getPost('name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'position_id' => $this->request->getPost('position'),
            'token' => Password::generateToken(),
            'confirmed' => 0,
        ];

        $insertedEmployeeId = $this->employeesModel->insert($employee);

        if (!$insertedEmployeeId) {
            $this->session->setFlashdata('msg', ['type' => 'error', 'body' => 'Ha ocurrido un error al crear el empleado.']);
            log_message('error', 'Error al crear el empleado: ' . $this->employeesModel->errors());
            return redirect()->back()->withInput();
        }

        $emailSent = $this->email->sendConfirmationEmail($employee['email'], $employee['token']);

        if (!$emailSent) {
            $this->session->setFlashdata('msg', ['type' => 'warning', 'body' => 'Se ha creado al empleado pero ha ocurrido un error al enviar el correo de confirmación. Compruebe que la direccion de email es valida e intente reestablecer su contraseña mediante el enlace de "Olvidé mi contraseña" en la página de inicio de sesión.']);
            log_message('error', 'Error al enviar el correo de confirmación');
        } else {
            $this->session->setFlashdata('msg', ['type' => 'success', 'body' => 'El empleado se ha creado correctamente.']);
        }


        return redirect()->to('/employees');
    }

    public function edit($id = null)
    {

        //If no parameter is passed, try to get it from the post request
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

        //If the request is a get request, show the edit form
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

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updatedEmployee = [
            'name' => $this->request->getPost('name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'position_id' => $this->request->getPost('position')
        ];

        $updatedEmployee = $this->employeesModel->update($id, $updatedEmployee);

        if (!$updatedEmployee) {
            $this->session->setFlashdata('msg', ['type' => 'error', 'body' => 'Ha ocurrido un error al actualizar el empleado.']);
            log_message('error', 'Error al actualizar el empleado: ' . $this->employeesModel->errors());
            return redirect()->back()->withInput();
        }

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