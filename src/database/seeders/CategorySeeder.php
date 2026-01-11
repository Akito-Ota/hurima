<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $names = [
            'ファッション',
            '家電',
            'インテリア',
            'レディース',
            'メンズ',
            'コスメ',
            '本',
            'ゲーム',
            'スポーツ',
            'キッチン',
            'ハンドメイド',
            'アクセサリー',
            'おもちゃ',
            'ベビー・キッズ',
        ];
        foreach ($names as $name) {
            $slug = Str::slug($name, '-');
            if ($slug === '') {
                $slug = null;
            }
            Category::updateOrCreate(
                ['name' => $name],
                ['slug' => $slug]
            );
        }
    }
}
