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
    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address'  => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255'],
            'image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], 
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'ユーザー名',
            'postcode' => '郵便番号',
            'address' => '住所',
            'building' => '建物名',
            'image' => 'プロフィール画像',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'お名前を入力してください',
            'postcode.required' => '郵便番号を入力してください',
            'postcode.regex'    => 'ハイフンを含む8文字の郵便番号で入力してください',
            'address.required' => '住所を入力してください',
            'image.mimes' => '画像はjpg、jpeg、png形式で指定してください',

        ];
    }
}
