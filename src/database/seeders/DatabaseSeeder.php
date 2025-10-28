<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\User;
use App\Models\category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $user = User::firstOrCreate(
            ['email' => 'seed@example.com'],
            [
                'name' => 'Seed User',
                'password' => bcrypt('password'),
            ]);

    
        config(['seeder_user_id' => $user->id]);

        
        $this->call(ItemsTableSeeder::class);
        $this->call(CategorySeeder::class);
    }
}
