<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;
use App\Models\SaleCustomer;
use App\Models\Catalogue;
use App\Models\Payment;
use App\Models\StateOrder;
use App\Models\OrderShippingStatus;

class Order extends Model
{
    // use HasFactory;

    protected $fillable = [
        // 'status',
        'total_order',
        'catalogue_id',
        'user_id',
        'sale_customer_id',
        'state_order_id',
        'order_shipping_status_id'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function saleCustomer()
    {
        return $this->belongsTo(SaleCustomer::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function stateOrder()
    {
        return $this->belongsTo(StateOrder::class);
    }

    public function orderShippingStatus()
    {
        return $this->belongsTo(OrderShippingStatus::class);
    }
}
