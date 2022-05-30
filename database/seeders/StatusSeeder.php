<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses =  [
            ['name' => 'approved', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'rejected', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'accepted', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'deactivated', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($statuses as $status) {
            Status::updateOrInsert(
                ['name' => $status['name']],
                [
                    'name' => $status['name'],
                    'created_at' => $status['created_at'],
                    'updated_at' => $status['updated_at']
                ]
            );
        }
    }
}
