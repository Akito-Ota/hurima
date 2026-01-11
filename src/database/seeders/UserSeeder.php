<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'userA@example.com'],
            [
                'name' => 'userA',
                'password' => Hash::make('password'),
            ]
        );
        User::firstOrCreate(
            ['email' => 'userB@example.com'],
            [
                'name' => 'userB',
                'password' => Hash::make('password'),
            ]
        );
        User::firstOrCreate(
            ['email' => 'userC@example.com'],
            [
                'name' => 'userC',
                'password' => Hash::make('password'),
            ]
        );
    }
}
