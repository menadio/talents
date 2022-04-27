<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $industries = [
            ['name' => 'finance'],
            ['name' => 'technology'],
            ['name' => 'education'],
            ['name' => 'entertainment'],
            ['name' => 'hospitality'],
        ];

        foreach ($industries as $industry) {
            Industry::updateOrInsert(
                ['name' => $industry['name']],
                ['name' => $industry['name']]
            );
        }
    }
}
