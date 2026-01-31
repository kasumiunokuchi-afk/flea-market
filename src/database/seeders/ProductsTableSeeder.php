<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();

        // 腕時計
        $imageName = 'Armani+Mens+Clock.jpg';
        $fileName = self::uploadImage($imageName);
        $param = [
            'name' => '腕時計',
            'brand_name' => 'Rolax',
            'explanation' => 'スタイリッシュなデザインのメンズ腕時計',
            'image_path' => $fileName,
            'condition' => 1,
            'price' => '15000',
            'user_id' => 1,
        ];
        $product = Product::create($param);
        $product->categories()->sync(
            $categories->random(rand(1, 3))->pluck('id')
        );

        // HDD
        $imageName = 'HDD+Hard+Disk.jpg';
        $fileName = self::uploadImage($imageName);
        $param = [
            'name' => 'HDD',
            'brand_name' => '西芝',
            'explanation' => '高速で信頼性の高いハードディスク',
            'image_path' => $fileName,
            'condition' => 2,
            'price' => '5000',
            'user_id' => 1,
        ];
        $product = Product::create($param);
        $product->categories()->sync(
            $categories->random(rand(1, 3))->pluck('id')
        );

        // 玉ねぎ3束
        $imageName = 'iLoveIMG+d.jpg';
        $fileName = self::uploadImage($imageName);
        $param = [
            'name' => '玉ねぎ3束',
            'brand_name' => 'なし',
            'explanation' => '新鮮な玉ねぎ3束のセット',
            'image_path' => $fileName,
            'condition' => 1,
            'price' => '300',
            'user_id' => 3,
        ];
        $product = Product::create($param);
        $product->categories()->sync(
            $categories->random(rand(1, 3))->pluck('id')
        );

        // 革靴
        $imageName = 'Leather+Shoes+Product+Photo.jpg';
        $fileName = self::uploadImage($imageName);
        $param = [
            'name' => '革靴',
            'explanation' => 'クラシックなデザインの革靴',
            'image_path' => $fileName,
            'condition' => 4,
            'price' => '4000',
            'user_id' => 1,
        ];
        $product = Product::create($param);
        $product->categories()->sync(
            $categories->random(rand(1, 3))->pluck('id')
        );

        // ノートPC
        $imageName = 'Living+Room+Laptop.jpg';
        $fileName = self::uploadImage($imageName);
        $param = [
            'name' => 'ノートPC',
            'explanation' => '高性能なノートパソコン',
            'image_path' => $fileName,
            'condition' => 1,
            'price' => '45000',
            'user_id' => 1,
        ];
        $product = Product::create($param);
        $product->categories()->sync(
            $categories->random(rand(1, 3))->pluck('id')
        );

        // マイク
        $imageName = 'Music+Mic+4632231.jpg';
        $fileName = self::uploadImage($imageName);
        $param = [
            'name' => 'マイク',
            'brand_name' => 'なし',
            'explanation' => '高音質のレコーディング用マイク',
            'image_path' => $fileName,
            'condition' => 1,
            'price' => '8000',
            'user_id' => 2,
        ];
        $product = Product::create($param);
        $product->categories()->sync(
            $categories->random(rand(1, 3))->pluck('id')
        );

        // ショルダーバッグ
        $imageName = 'Purse+fashion+pocket.jpg';
        $fileName = self::uploadImage($imageName);
        $param = [
            'name' => 'ショルダーバッグ',
            'explanation' => 'おしゃれなショルダーバッグ',
            'image_path' => $fileName,
            'condition' => 1,
            'price' => '3500',
            'user_id' => 3,
        ];
        $product = Product::create($param);
        $product->categories()->sync(
            $categories->random(rand(1, 3))->pluck('id')
        );

        // タンブラー
        $imageName = 'Tumbler+souvenir.jpg';
        $fileName = self::uploadImage($imageName);
        $param = [
            'name' => 'タンブラー',
            'brand_name' => 'なし',
            'explanation' => '使いやすいタンブラー',
            'image_path' => $fileName,
            'condition' => 1,
            'price' => '500',
            'user_id' => 4,
        ];
        $product = Product::create($param);
        $product->categories()->sync(
            $categories->random(rand(1, 3))->pluck('id')
        );

        // コーヒーミル
        $imageName = 'Waitress+with+Coffee+Grinder.jpg';
        $fileName = self::uploadImage($imageName);
        $param = [
            'name' => 'コーヒーミル',
            'brand_name' => 'Starbacks',
            'explanation' => '手動のコーヒーミル',
            'image_path' => $fileName,
            'condition' => 1,
            'price' => '4000',
            'user_id' => 1,
        ];
        $product = Product::create($param);
        $product->categories()->sync(
            $categories->random(rand(1, 3))->pluck('id')
        );

        // メイクセット
        $imageName = '外出メイクアップセット.jpg';
        $fileName = self::uploadImage($imageName);
        $param = [
            'name' => 'メイクセット',
            'explanation' => '便利なメイクアップセット',
            'image_path' => $fileName,
            'condition' => 1,
            'price' => '2500',
            'user_id' => 2,
        ];
        $product = Product::create($param);
        $product->categories()->sync(
            $categories->random(rand(1, 3))->pluck('id')
        );
    }

    public function uploadImage($imageName)
    {
        $dummyImagesPath = database_path('seeders/dummy_images/');

        $imagePath = $dummyImagesPath . $imageName;
        $fileName = 'products/' . $imageName;
        Storage::disk('public')->put(
            $fileName,
            file_get_contents($imagePath)
        );

        return $fileName;
    }
}
