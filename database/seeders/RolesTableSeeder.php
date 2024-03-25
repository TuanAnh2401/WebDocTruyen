<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Thêm vai trò "admin"
        Role::create([
            'name' => 'admin',
        ]);

        // Thêm vai trò "user"
        Role::create([
            'name' => 'user',
        ]);
    }
}
