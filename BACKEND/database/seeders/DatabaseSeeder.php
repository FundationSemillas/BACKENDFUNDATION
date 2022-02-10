<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rols')->insert([
            'name' => 'Admin',
            'description' => 'Tiene todos los permisos'
        ]);
        DB::table('users')->insert([
            'name' => 'Anthony',
            'last_name' => 'Intriago',
            'email' => 'afc.intriago@gmail.com',
            'password' => Hash::make(123456),
            'permission' => 'Admin',
            'rol_id' => 1
        ]);
    }
}
