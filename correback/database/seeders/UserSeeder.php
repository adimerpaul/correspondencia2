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
            ['name'=>'administrador','carnet'=>'1010','email'=>'admin@test.com','password'=>Hash::make('admin'),'fechalimite'=>'9999/01/01','unit_id'=>16],
        ]);
    }
}
