<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'content' => 'ファッション'
        ];
        Category::create($param);
        $param = [
            'content' => '家電'
        ];
        Category::create($param);
        $param = [
            'content' => 'インテリア'
        ];
        Category::create($param);
        $param = [
            'content' => 'レディース'
        ];
        Category::create($param);
        $param = [
            'content' => 'メンズ'
        ];
        Category::create($param);
        $param = [
            'content' => 'コスメ'
        ];
        Category::create($param);
        $param = [
            'content' => '本'
        ];
        Category::create($param);
        $param = [
            'content' => 'ゲーム'
        ];
        Category::create($param);
        $param = [
            'content' => 'スポーツ'
        ];
        Category::create($param);
        $param = [
            'content' => 'キッチン'
        ];
        Category::create($param);
        $param = [
            'content' => 'ハンドメイド'
        ];
        Category::create($param);
        $param = [
            'content' => 'アクセサリー'
        ];
        Category::create($param);
        $param = [
            'content' => 'おもちゃ'
        ];
        Category::create($param);
        $param = [
            'content' => 'ベビー・キッズ'
        ];
        Category::create($param);
    }
}
