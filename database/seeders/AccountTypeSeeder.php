<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = [
            ['type' => 'individual'],
            ['type' => 'business']
        ];

        foreach ($accounts as $account) {
            AccountType::updateOrInsert(
                ['type' => $account['type']],
                ['type' => $account['type']]
            );
        }
    }
}
