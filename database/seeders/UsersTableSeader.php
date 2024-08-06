<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeader extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = [
            ['name'  => 'User','email' => 'user@user.com','password' => bcrypt('password')],
            ['name'  => 'User2','email' => 'user2@user.com','password' => bcrypt('password')],
            ['name'  => 'User3','email' => 'user3@user.com','password' => bcrypt('password')],
            ['name'  => 'User4','email' => 'user4@user.com','password' => bcrypt('password')],
            ['name'  => 'User5','email' => 'user5@user.com','password' => bcrypt('password')],
            ['name'  => 'User6','email' => 'user6@user.com','password' => bcrypt('password')],
            ['name'  => 'User7','email' => 'user7@user.com','password' => bcrypt('password')],
            ['name'  => 'User8','email' => 'user8@user.com','password' => bcrypt('password')],
            ['name'  => 'User9','email' => 'user9@user.com','password' => bcrypt('password')],
            ['name'  => 'User10','email' => 'user10@user.com','password' => bcrypt('password')],
        ];
        User::insert($user);
    }
}
