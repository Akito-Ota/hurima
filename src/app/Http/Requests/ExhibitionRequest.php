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
        return [
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['required', 'string','max:255'],
            'item_images' => ['required', 'image', 'mimes:jpg,jpeg,png','max:4096'],
            'brand'       => ['nullable', 'string', 'max:50'],
            'status'      => ['required', 'string', ],
            'price'       => ['required', 'integer', 'min:1'],
            'category_ids'   => ['required', 'array'],
            'category_ids.*' => ['integer', 'exists:categories,id'],

        ];
    }
    public function attributes(): array
    {
        return [
            'name'        => '商品名',
            'price'       => '価格',
            'brand'       => 'ブランド',
            'description' => '商品説明',
            'status'      => '商品の状態',
            'item_images' => '商品画像',
            'category_ids'   => 'カテゴリー',
            'category_ids.*' => 'カテゴリー',
        ];
    }
}
