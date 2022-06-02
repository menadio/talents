<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'music'],
            ['name' => 'visual arts'],
            ['name' => 'performing arts'],
            ['name' => 'film'],
            ['name' => 'lectures & books'],
            ['name' => 'fashion'],
            ['name' => 'food & drink'],
            ['name' => 'festivals & fairs'],
            ['name' => 'charities'],
            ['name' => 'sports & active life'],
            ['name' => 'nightlife'],
            ['name' => 'kids & family'],
            ['name' => 'others'],
        ];

        foreach ($categories as $category) {
            EventCategory::updateOrInsert(
                ['name' => $category['name']],
                [
                    'name' => $category['name'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}