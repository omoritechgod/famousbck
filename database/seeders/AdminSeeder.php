<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'info@fam.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Suportfam$11'),
            ]
        );
    }
}
