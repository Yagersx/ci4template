<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Position extends BaseController
{
    private $positionModel;
    public function __construct()
    {
        $this->positionModel = model('App\Models\Positions');
    }
    public function index()
    {
        $data = [
            'title' => 'Posiciones',
            'subtitle' => 'Lista de posiciones',
            'positions' => $this->positionModel->findAll()
        ];

        return view('positions/list', $data);
    }

}