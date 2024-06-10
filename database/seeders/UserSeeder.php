<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => '+998912345678',
            'password' => Hash::make('secret123'),
        ]);

        $admin->roles()->attach(1);

        $user = User::create([
            'first_name' => 'Fazliddin',
            'last_name' => 'Qobilov',
            'email' => 'fazliddin11@gmail.com',
            'phone' => '+998912345679',
            'password' => Hash::make('secret123'),
        ]);

        $user->roles()->attach(2);


        User::factory()->count(10)->hasAttached([Role::find(2)])->create();
    }
}
