<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_names = ['student', 'agent', 'admin', 'employee'];

        foreach ($role_names as $role_name) {
            $role = Role::create([
                'role_name' => $role_name
            ]);
        }
    }
}
