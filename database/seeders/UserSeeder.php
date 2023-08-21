<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Making test users
        $users = User::factory()->count(10)->make();

        foreach ($users as $user) {
            $new = new User();

            $new->first_name = $user->first_name;
            $new->last_name = $user->last_name;
            $new->email = $user->email;
            $new->password = $user->password;
            $new->phone = $user->phone;
            $new->contact_id = $user->contact_id;
            $new->role_id = $user->role_id;
            $new->save();
        }

    }
}
