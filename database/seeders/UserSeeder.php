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
    }
}
