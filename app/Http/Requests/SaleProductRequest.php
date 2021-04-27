<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleProductRequest extends FormRequest
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
            'ProductName' => ['required', 'string'],
            'ProductDescription' => ['string'],
            'QuantityPerUnit' => ['integer'],
            'UnitPrice' => ['required', 'numeric'],
            'SellingPrice' => ['required', 'numeric'],
            'AvailableSize' => ['boolean'],
            'AvailableColors' => ['boolean'],
            'AvailableGender' => ['boolean'],
            'Size' => ['array'],
            'Size.*' => ['required', 'integer'],
            'Color' => ['array'],
            'Color.*' => ['required', 'string'],
            'Gender' => ['string', 'exists:App\Models\SaleGender,GenderName'],
            'Discount' => ['numeric'],
            'UnitWeight' => ['numeric'],
            'ProductAvailable' => ['boolean'],
            'DiscountAvailable' => ['boolean'],
            'sale_category_id' => ['required', 'integer', 'exists:App\Models\SaleCategory,id'],
            'sale_sub_category_id' => ['integer', 'exists:App\Models\SaleSubCategory,id'],
            'sale_brand_id' => ['required', 'integer', 'exists:App\Models\SaleBrand,id'],
            'sale_product_type_id' => ['required', 'integer', 'exists:App\Models\SaleProductType,id'],
            'sale_product_unit_id' => ['required', 'integer', 'exists:App\Models\SaleProductUnit,id'],
        ];
    }
}
