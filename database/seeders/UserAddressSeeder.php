<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::find(2)->addresses()->create([
            "latitude"=>"15",
            "longitude"=>"13",
            "region"=>"Xorazm",
            "district"=>"Gurlan",
            "street"=>"Dosimbiy",
            "home"=>"1"
        ]);

        User::find(2)->addresses()->create([
            "latitude"=>"42°26'44.8",
            "longitude"=>"59°37'37.3",
            "region"=>"Qoraqalpog'iston",
            "district"=>"Nukus",
            "street"=>"21-mkr",
            "home"=>"5B/19"
        ]);

        User::find(2)->addresses()->create([
            "latitude"=>"41.984068",
            "longitude"=>"60.233232",
            "region"=>"Qoraqalpog'iston",
            "district"=>"Amudaryo",
            "street"=>"Tutzor",
            "home"=>"18"
        ]);
    }
}
