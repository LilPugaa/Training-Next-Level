<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator Sistem',
                'access_token' => 'ADM-2025'
            ],
            [
                'name' => 'coordinator',
                'description' => 'Coordinator',
                'access_token' => 'CRT-2025'
            ],
            [
                'name' => 'trainer',
                'description' => 'Trainer',
                'access_token' => 'TRN-2025'
            ],
            [
                'name' => 'branch_pic',
                'description' => 'Branch PIC',
                'access_token' => 'BPC-2025'
            ],
            [
                'name' => 'participant',
                'description' => 'Participant',
                'access_token' => null
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}