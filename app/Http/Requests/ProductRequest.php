<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $rules = [
            'name' => ['string'],
            // 'model' => ['required', 'unique:products', 'string'],
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
            'price_unit' => ['required','numeric'],
            'price_group' => ['required','numeric'],
            'quantity_group' => ['required','integer'],
            'type_group' => ['required', 'string','in:unidades,sets,cajas'],
            'catalogue_id' => ['required', 'integer', 'exists:App\Models\Catalogue,id'],
            'category_id' => ['required', 'integer', 'exists:App\Models\Category,id'],
        ];
        return $rules;
    }
}
