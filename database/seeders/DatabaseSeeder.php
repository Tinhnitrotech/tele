<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Staff 1',
                'email' => 'staff1@gmail.com',
                'password' => bcrypt('staff123'),
                'birthday' => '1990-01-21',
                'tel' => '0900000000',
            ],
            [
                'name' => 'Staff 2',
                'email' => 'staff2@gmail.com',
                'password' => bcrypt('staff123'),
                'birthday' => '1990-01-21',
                'tel' => '0900000000',
            ]
        ]);

        DB::table('admins')->insert([
            [
                'name' => 'Admin 1',
                'name_kana' => 'admin_kana',
                'email' => 'admin1@gmail.com',
                'birthday' => '1990-01-21',
                'gender' => 1,
                'password' => bcrypt('admin123'),
            ],
            [
                'name' => 'Admin 2',
                'name_kana' => 'admin_kana',
                'email' => 'admin2@gmail.com',
                'birthday' => '1990-01-21',
                'gender' => 1,
                'password' => bcrypt('admin123'),
            ]
        ]);
    }
}
