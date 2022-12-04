<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopItemStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'itemName' => 'required|min:5|max:100',
            'manufacturer' => 'required|string|max:100',
            'price' => 'required|integer',
            'year' => 'required|integer|min:2000|max:2022',
            'itemImage' => 'nullable|image|mimes:jpg,png,jpeg|max:2048|dimensions:min_width=300,min_height=300,max_width=2000,max_height=2000',
            'warrantyCost' => 'nullable|integer|max:2000',
            'deliveryCost' => 'nullable|integer|max:2000',
            'setUpCost' => 'nullable|integer|max:2000',
        ];
    }
}
