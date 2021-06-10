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
        DB::table('users')->insert([
            'username' => '001',
            'status' => 'admin',
            'password' => Hash::make('password'),
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('users')->insert([
            'username' => '002',
            'status' => 'employee',
            'password' => Hash::make('password'),
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('employees')->insert([
            'user_id' => 2,
            'nip' => '002',
            'name' => 'Mohammad Hatta',
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('users')->insert([
            'username' => '003',
            'status' => 'student',
            'password' => Hash::make('password'),
            'created_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('students')->insert([
            'user_id' => 3,
            'nis' => '003',
            'name' => 'Rijal Rojaliii',
            'created_at' => \Carbon\Carbon::now(),
        ]);
    }
}
