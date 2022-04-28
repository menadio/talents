<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrInsert(
            ['email' => 'hello@bookstars.co'],
            [
                'email' => 'hello@bookstars.co',
                'password' => Hash::make('demopassword'),
                'account_type_id' => 1
            ]
        );
    }
}
