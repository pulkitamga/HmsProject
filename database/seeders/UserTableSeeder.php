<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('id', 1)->first(); 

        if ($adminRole) {
            User::firstOrCreate([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('jinh24uk'),
                'role_id' => $adminRole->id, // Ensure it's assigned correctly
            ]);
        }
    }
}
