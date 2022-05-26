<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AccountTypeSeeder::class,
            EmploymentTypeSeeder::class,
            IndustrySeeder::class,
            SkillSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
