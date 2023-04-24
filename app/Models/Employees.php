<?php

namespace App\Models;

use CodeIgniter\Model;

class Employees extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = 'object';
    protected $useSoftDeletes = true;
    protected $protectFields = false;
    protected $allowedFields = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['insertedBy'];
    protected $afterInsert = [];
    protected $beforeUpdate = ['updatedBy'];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = ['deletedBy'];
    protected $afterDelete = [];


    protected function insertedBy(array $data)
    {
        $data['data']['created_by'] = session()->get('employee')['employee_id'];
        return $data;
    }

    protected function updatedBy(array $data)
    {
        $data['data']['updated_by'] = session()->get('employee')['employee_id'];
        return $data;
    }

    protected function deletedBy(array $data)
    {
        $data['data']['deleted_by'] = session()->get('employee')['employee_id'];
        return $data;
    }
}