<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SaleProduct;
use App\Models\SaleProductStatus;
use App\Models\SaleBusinessLocation;
use App\Models\SaleCustomer;
use App\Models\OrderDetail;

class SaleStockRecord extends Model
{
    protected $fillable = [
        'order_detail_id',
        'sale_product_id',
        'Quantity',
        'sale_product_status_id',
        'sale_business_location_id',
        'sale_customer_id',
        'Size',
        'Color',
    ];

    public function SaleProduct()
    {
        return $this->belongsTo(SaleProduct::class);
    }

    public function SaleProductStatus()
    {
        return $this->belongsTo(SaleProductStatus::class);
    }

    public function SaleBusinessLocation()
    {
        return $this->belongsTo(SaleBusinessLocation::class);
    }

    public function SaleCustomer()
    {
        return $this->belongsTo(SaleCustomer::class);
    }

    public function OrderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
