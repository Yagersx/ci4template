<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Role extends BaseController
{
    private $roleModel;
    public function __construct()
    {
        $this->roleModel = model('App\Models\Roles');
    }
    public function index()
    {
        $data = [
            'title' => 'Roles',
            'subtitle' => 'Lista de roles',
            'roles' => $this->roleModel->findAll()
        ];

        return view('roles/list', $data);
    }

}