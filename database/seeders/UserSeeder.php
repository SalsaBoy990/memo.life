<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's clear the users table first
        User::truncate();

        $admin = Role::where('slug', 'administrator')->first();
        $superAdmin = Role::where('slug', 'super-administrator')->first();

        $user1 = new User();
        $user1->name = 'Gulácsi András';
        $user1->email = 'gulandras90@gmail.com';
        $user1->password = bcrypt('D3#^b&&q94k02z');
        $user1->role()->associate($superAdmin);
        $user1->save();

        $user2 = new User();
        $user2->name = 'John Doe';
        $user2->email = 'john@doe.com';
        $user2->password = bcrypt('password');
        $user2->save();
        $user2->role()->associate($admin);

    }
}
