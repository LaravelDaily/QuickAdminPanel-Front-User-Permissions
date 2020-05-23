<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$SNJPa1TeyTEXJdWSuXHjKuZJfQDE57w.PkfUFxdTnlHkSz4NjZHr2',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
