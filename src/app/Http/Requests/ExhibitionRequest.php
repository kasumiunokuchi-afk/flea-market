<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /**
         * 商品名	入力必須
         * 商品説明	入力必須、最大文字数255
         * 商品画像	アップロード必須、拡張子が.jpegもしくは.png
         * 商品のカテゴリー	選択必須
         * 商品の状態	選択必須
         * 商品価格	入力必須、数値型、0円以上
         */
        return [
            'name' => 'required',
            'explanation' => 'required|max:255',
            'image_path' => 'required|mimes:jpeg,png',
            'category_ids' => 'required',
            'condition' => 'required',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名は必ず入力してください。',
            'explanation.required' => '商品説明は必ず入力してください。',
            'explanation.max' => '商品説明は255文字以下で入力してください。',
            'image_path.required' => '商品画像は必ずアップロードしてください。',
            'image_path.mimes' => 'アップロードできるファイルは jpeg / png のみです。',
            'category_ids.required' => '商品カテゴリは1つ以上選択してください。',
            'required.required' => '商品価格は必ず入力してください。',
            'required.numeric' => '商品価格は数値で入力してください。',
            'required.min' => '商品価格は0円以上の値を入力してください。',
        ];
    }
}
