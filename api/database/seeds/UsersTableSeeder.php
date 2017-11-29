<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'root',
            'email' => 'root@gmail.com',
            'password' => bcrypt('root')
        ]);
        DB::table('users')->insert([
            'username' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('user1')
        ]);
        DB::table('users')->insert([
            'username' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('user2')
        ]);
    }
}