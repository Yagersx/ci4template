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

    /**
     * Ejecutar la consulta para obtener a los empleados para datatable segun los parametros enviados por el cliente
     * @param array $options
     * @return array
     */
    public function getEmployeesForDatatable(array $options)
    {
        $builder = $this->db->table('employees');
        $builder->select('employees.*, positions.description');
        $builder->join('positions', 'positions.position_id = employees.position_id');
        $builder->where('employees.deleted_at', null);
        $builder->limit($options['length'], $options['start']);

        if ($options['order']) {
            //dado que no siempre se requerira mostrar todas las columnas, 
            //se debe obtener el array de columnas renderizadas en el datatable,
            //obtener el indice y con ello el nombre de la columna por la que se ordenara

            // Obtener el array de columnas renderizadas en el datatable
            $columns = $options['columns'];

            //Obtener el indice de la columna por la que se ordenara
            $indexColumn = $options['order'][0]['column'];

            // Obtener el nombre de la columna por la que se ordenara
            $columnName = $columns[$indexColumn]['data'];

            // Obtener la direccion de la ordenacion (asc o desc)
            $dir = $options['order'][0]['dir'];
            $builder->orderBy($columnName, $dir);
        }

        if ($options['search']) {
            $builder->groupStart();
            $builder->like('employees.name', $options['search']);
            $builder->orLike('employees.last_name', $options['search']);
            $builder->orLike('employees.email', $options['search']);
            $builder->orLike('employees.phone', $options['search']);
            $builder->orLike('employees.address', $options['search']);
            $builder->orLike('employees.salary', $options['search']);
            $builder->groupEnd();
        }

        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }
}