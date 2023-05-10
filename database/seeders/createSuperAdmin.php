<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class createSuperAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'SuperAdmin',
            'email' => 'kstikesmedistraindonesia@gmail.com',
            'password'=>bcrypt('isiadalah0'),
            'level'=>0,
        ]);
    }
}
