<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //USUARIO ADMIN
        DB::table('users')->insert([
            'name' => 'Usuario - admin',
            'user' => 'admin',
            'email' => 'admin@google.com',
            'password' => Hash::make('admin123'),
            'user_type_id' => 1,
            'last_name' => 'admin',
            'second_surname' => 'admin',
            'status' => 1,
        ]);
    }
}
