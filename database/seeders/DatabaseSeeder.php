<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * @return void
     */
    public function run(){
        \App\Models\User::factory(10)->create();

        $this->call([
            RestaurantSeeder::class,
        ]);

        $this->call([
            CategorySeeder::class,
        ]);

        $this->call([
            CategoryRestaurantSeeder::class,
        ]);

        $this->call([
            RestaurantUserSeeder::class,
        ]);
    }
}