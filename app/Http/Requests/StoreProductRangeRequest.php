<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRangeRequest extends FormRequest
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
            'name' => ['string'],
            'sku' => ['unique:product_ranges'],
            'model' => ['required', 'string', 'unique:product_ranges'],
            'description' => ['array'],
            'description.*' => ['string'],
            'images' => ['array'],
            'images.*.id' => ['required', 'exists:App\Models\Image,id'],
            'images.*.name' => ['required', 'exists:App\Models\Image,name'],
            'images.*.path' => ['required', 'exists:App\Models\Image,path'],
            'colors' => ['array'],
            'stock' => ['required', 'integer'],
            'brand' => ['string'],
            'price_sale' => ['numeric'],
            'on_sale' => ['boolean'],
            'catalogue_id' => ['required', 'integer', 'exists:App\Models\Catalogue,id'],
            'category_id' => ['required', 'integer', 'exists:App\Models\Category,id'],
            'ranges' => ['array'],
            'ranges.*.min' => ['required', 'integer'],
            'ranges.*.max' => ['required', 'integer'],
            'ranges.*.price' => ['required', 'numeric'],
        ];
    }
}