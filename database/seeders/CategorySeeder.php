<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'a & r administrator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'caterer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'cinematographer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'critic', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'makeup artist', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'professional speaker', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'publicist', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'stunt person', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'theatre consultant', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'writer', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($categories as $category) {
            Category::updateOrInsert(
                ['name' => $category['name']],
                [
                    'name' => $category['name'],
                    'created_at' => $category['created_at'],
                    'updated_at' => $category['updated_at']
                ]
            );
        }
    }
}
