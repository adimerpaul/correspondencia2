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
            ['name'=>'ADMINISTRADOR','carnet'=>'1010','email'=>'admin@test.com','password'=>Hash::make('admin'),'fechalimite'=>'9999/01/01','unit_id'=>16],
            ['name'=>'ADIMER PAUL CHAMBI AJATA','carnet'=>'7336199','email'=>'adimer101@gmail.com','password'=>Hash::make('7336199'),'fechalimite'=>'9999/01/01','unit_id'=>1],
            ['name'=>'ALEJANDRO LOPEZ','carnet'=>'2020','email'=>'aler@gmail.com','password'=>Hash::make('2020'),'fechalimite'=>'9999/01/01','unit_id'=>2],
        ]);
    }
}
