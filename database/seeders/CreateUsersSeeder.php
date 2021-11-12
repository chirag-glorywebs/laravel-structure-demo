<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'user_id'=> Str::uuid()->toString(),
                'first_name'=>'Admin',
                'last_name'=>'Kshatriya',
                'email'=>'admin@hatikshatriya.com',
                'user_type'=>'SuperAdmin',
                'password'=> bcrypt('admin'),
            ],
            [
                'user_id'=> Str::uuid()->toString(),
                'first_name'=>'User',
                'last_name'=>'Kshatriya',
                'email'=>'test@hatikshatriya.com',
                'user_type'=>'User',
                'password'=> bcrypt('admin'),
            ],
        ];
  
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
