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
            // 日本語から slug を生成。空になる場合がある
            $slug = Str::slug($name, '-');   // 第3引数 'ja' を付けても空になることがあります
            if ($slug === '') {
                $slug = null;                // 空文字は UNIQUE 衝突の元。NULL にする
            }

            // name をキーに Upsert（重複防止）
            Category::updateOrCreate(
                ['name' => $name],           // 探すキー（name にユニーク制約を付けているならベスト）
                ['slug' => $slug]
            );
        }
    }
    }

