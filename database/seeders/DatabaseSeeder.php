<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // php artisan migrate:fresh --seed 
        
        $this->call([
            ContactSeeder::class,
            AddressSeeder::class,
            EmailSeeder::class,
            PhoneSeeder::class
        ]);

        $this->call([
            CompanySeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class
        ]);
    }
}
