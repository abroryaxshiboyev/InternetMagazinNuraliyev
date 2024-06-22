<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'Admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => '+998912345678',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('admin');

        $user = User::create([
            'first_name' => 'Setora',
            'last_name' => 'Qobilova',
            'email' => 'setora0877@gmail.com',
            'phone' => '+998912345679',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('editor');


        $user = User::create([
            'first_name' => 'Sanjar',
            'last_name' => 'Eshqobilov',
            'email' => 'sanjar@gmail.com',
            'phone' => '+998912345680',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('shop-manager');


        $user = User::create([
            'first_name' => 'Jamila',
            'last_name' => 'Toirova',
            'email' => 'jamila@gmail.com',
            'phone' => '+998912345681',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('helpdesk-support');

        $user = User::create([
            'first_name' => 'Fazliddin',
            'last_name' => 'Qobilov',
            'email' => 'fazliddin11@gmail.com',
            'phone' => '+998912345682',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('customer');


       $users = User::factory()->count(10)->create();

       foreach ($users as $user) {
        $user->assignRole('customer');
       }
    }
}
