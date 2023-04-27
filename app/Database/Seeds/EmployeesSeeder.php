<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployeesSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('es_ES');

        for ($j = 0; $j < 1000; $j++) {
            $newEmployee = [
                'name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'birthday' => $faker->dateTimeThisCentury->format('Y-m-d H:i:s'),
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'salary' => $faker->numberBetween(10000, 50000),
                'role_id' => $faker->numberBetween(1, 3),
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'token' => bin2hex(random_bytes(16)),
                'confirmed' => $faker->boolean,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => null,
                'updated_by' => null,
                'deleted_at' => null,
                'deleted_by' => null,
            ];
            $this->db->table('employees')->insert($newEmployee);
        }

    }
}