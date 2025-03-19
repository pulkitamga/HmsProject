<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'name' => 'Super Admin', 'status' => 1],
            ['name' => 'Administrator', 'status' => 1],
            ['name' => 'Manager', 'status' => 1],
            ['name' => 'Doctor', 'status' => 1],
            ['name' => 'Nurse', 'status' => 1],
            ['name' => 'Receptionist', 'status' => 1],
            ['name' => 'Pharmacist', 'status' => 1],
            ['name' => 'Lab Technician', 'status' => 1],
            ['name' => 'Radiologist/Imaging Technician', 'status' => 1],
            ['name' => 'Billing/Accounts Staff', 'status' => 1],
            ['name' => 'IT Support/Technician', 'status' => 1],
            ['name' => 'Maintenance/Security Staff', 'status' => 1],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], ['status' => $role['status']]);
        }
    }
}
