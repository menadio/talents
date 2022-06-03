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
            ['name' => 'Music Production'],
            ['name' => 'Movie Production'],
            ['name' => 'Mixing & Mastering'],
            ['name' => 'Song Writing'],
            ['name' => 'Video Shooting'],
            ['name' => 'Video Editing'],
            ['name' => 'Animation'],
            ['name' => 'Modelling'],
            ['name' => 'Fashion & Beauty'],
            ['name' => 'Script Writing'],
            ['name' => 'Screen Writing'],
            ['name' => 'Photography'],
            ['name' => 'Cinematography'],
            ['name' => 'Video Editing'],
            ['name' => 'Acting'],
            ['name' => 'Costume Management'],
            ['name' => 'Singing'],
            ['name' => 'Advertising'],
            ['name' => 'Branding']
        ];

        foreach ($industries as $industry) {
            Industry::updateOrInsert(
                ['name' => $industry['name']],
                ['name' => $industry['name']]
            );
        }
    }
}
