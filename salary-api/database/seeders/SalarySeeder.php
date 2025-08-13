<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SalaryDetail;

class SalarySeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Alice Johnson', 'email' => 'alice@example.com'],
            ['name' => 'Bob Smith', 'email' => 'bob@example.com'],
            ['name' => 'Carol Davis', 'email' => 'carol@example.com'],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
            
            SalaryDetail::create([
                'user_id' => $user->id,
                'salary_local_currency' => rand(3000, 8000),
                'salary_in_euros' => rand(2500, 7000),
                'commission' => 500,
            ]);
        }
    }
}