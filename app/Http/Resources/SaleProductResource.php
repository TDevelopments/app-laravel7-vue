<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'Sku' => $this->Sku,
            'Slug' => $this->Slug,
            'ProductName' => $this->ProductName,
            'ProductDescription' => $this->ProductDescription,
            'QuantityPerUnit' => $this->QuantityPerUnit,
            'UnitPrice' => $this->UnitPrice,
            'SellingPrice' => $this->SellingPrice,
            'AvailableSize' => $this->AvailableSize,
            'AvailableColors' => $this->AvailableColors,
            'AvailableGender' => $this->AvailableGender,
            'Size' => $this->Size,
            'Color' => $this->Color,
            'Gender' => $this->Gender,
            'Discount' => $this->Discount,
            'UnitWeight' => $this->UnitWeight,
            'UnitsOnOrder' => $this->UnitsOnOrder,
            'ProductAvailable' => $this->ProductAvailable,
            'DiscountAvailable' => $this->DiscountAvailable,
            'Picture' => $this->SalePictures,
            'Category' => $this->SaleCategory,
            'SubCategory' => $this->SaleSubCategory,
            'Brand' => $this->SaleBrand,
            'SaleProductType' => $this->SaleProductType,
            'SaleProductUnit' => $this->SaleProductUnit,
            'Rating' => $this->Reviews->count() > 0 ? round($this->Reviews->sum('Star')/$this->Reviews->count(),2) : 'Sin calificación',
        ];
    }
}
