<?php

namespace Database\Seeders;

use App\Models\EmploymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmploymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['name' => 'full-time'],
            ['name' => 'part-time'],
            ['name' => 'contract']
        ];

        foreach ($types as $type) {
            EmploymentType::updateOrInsert(
                ['name'  => $type['name']],
                ['name'  => $type['name']],
            );
        }
    }
}
