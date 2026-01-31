<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
         * プロフィール画像	拡張子が.jpegもしくは.png
         * ユーザー名	入力必須、20文字以内
         * 郵便番号	入力必須、ハイフンありの8文字
         * 住所	入力必須
         */
        return [

            'image_path' => 'mimes:jpeg,png',
            'name' => 'required|max:20',
            'postcode' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'image_path.mimes' => 'アップロードできるファイルは jpeg / png のみです。',
            'postcode.regex' => '郵便番号は「123-4567」形式で入力してください。',
        ];
    }
}
