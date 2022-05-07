<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            ['name' => 'project management'],
            ['name' => 'photography'],
            ['name' => 'singing'],
            ['name' => 'dancing'],
            ['name' => 'movie production'],
            ['name' => 'script writing'],
            ['name' => 'acting']
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                ['name' => $skill['name'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
