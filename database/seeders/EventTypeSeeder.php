<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eventTypes = [
            ['name' => 'free'],
            ['name' => 'paid']
        ];

        foreach ($eventTypes as $type) {
            EventType::updateOrInsert(
                ['name' => $type['name']],
                [
                    'name' => $type['name'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
                );
        }
    }
}
