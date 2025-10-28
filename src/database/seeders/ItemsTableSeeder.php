<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = config('seeder_user_id');
        $catIds = Category::pluck('id', 'name');
        DB::table('items')->insert([
            [
                'name' => '腕時計',
                'price' => 15000,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'brand' => 'Rolax',
                'category_id' => $catIds['インテリア'] ?? null,
                'status' => '良好',
                'item_images' => 'items/Clock.jpg',
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'description' => '高速で信頼性の高いハードディスク',
                'brand' => 'なし',
                'category_id' => $catIds['インテリア'] ?? null,
                'status' => 'やや傷や汚れあり',
                'item_images' => 'items/Hdd.jpg',
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'description' => '新鮮な玉ねぎ3束のセット',
                'brand' => 'なし',
                'category_id' => $catIds['インテリア'] ?? null,
                'status' => 'やや傷や汚れあり',
                'item_images' => 'items/Onion.jpg',
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'description' => 'クラシックなデザインの革靴',
                'brand' => 'なし',
                'category_id' => $catIds['インテリア'] ?? null,
                'status' => '状態が悪い',
                'item_images' => 'items/Shoes.jpg',
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'description' => '高性能なノートパソコン',
                'brand' => 'なし',
                'category_id' => $catIds['インテリア'] ?? null,
                'status' => '良好',
                'item_images' => 'items/Laptop.jpg',
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'description' => '高音質のレコーディング用マイク',
                'brand' => 'なし',
                'category_id' => $catIds['インテリア'] ?? null,
                'status' => '目立った傷や汚れなし',
                'item_images' => 'items/Mic.jpg',
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'description' => 'おしゃれなショルダーバッグ',
                'brand' => 'なし',
                'category_id' => $catIds['インテリア'] ?? null,
                'status' => 'やや傷や汚れあり',
                'item_images' => 'items/Bag.jpg',
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'description' => '使いやすいタンブラー',
                'brand' => 'なし',
                'category_id' => $catIds['インテリア'] ?? null,
                'status' => '状態が悪い',
                'item_images' => 'items/Tumbler.jpg',
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'description' => '手動のコーヒーミル',
                'brand' => 'Starbacks',
                'category_id' => $catIds['インテリア'] ?? null,
                'status' => '良好',
                'item_images' => 'items/Coffee.jpg',
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'description' => '便利なメイクアップセット',
                'brand' => 'なし',
                'category_id' => $catIds['インテリア'] ?? null,
                'status' => '良好',
                'item_images' => 'items/Makeup.jpg',
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
