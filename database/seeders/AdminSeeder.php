<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin1',
            'password' => bcrypt('030808')
        ]);

        Admin::create([
            'name' => 'Admin2',
            'password' => bcrypt('030303')
        ]);

        Admin::create([
            'name' => 'Admin3',
            'password' => bcrypt('080808')
        ]);
    }
}