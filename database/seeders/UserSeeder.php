<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 'active', // Gunakan bcrypt atau hash helper
            'role' => 'Admin',
        ]);

        User::create([
            'name' => 'Staff Pharmacist',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'status' => 'active', // Gunakan bcrypt atau hash helper
            'role' => 'Pharmacist',
        ]);

        User::create([
            'name' => 'Staff Tech',
            'email' => 'technician@example.com',
            'password' => Hash::make('password'),
            'status' => 'active', // Gunakan bcrypt atau hash helper
            'role' => 'Technician',
        ]);
    }
}
