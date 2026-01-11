<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach($users as $user){
        Profile::firstOrCreate(
                ['user_id' => $user->id],
                [
                'postcode' => '000-0000',
                'address' => '東京都テスト区テスト町1-1-1'
            ]
        );}
    }
}
