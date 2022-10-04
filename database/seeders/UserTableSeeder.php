<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'THE ONE PIECE IS REAL',
            'email' => 'mamapopay@ops.com',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(20)
        ]);
    }
}
