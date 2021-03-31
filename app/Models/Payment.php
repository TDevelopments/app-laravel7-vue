<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\PaymentConcept;
use App\Models\BankEntity;

class Payment extends Model
{
    // use HasFactory;

    protected $fillable = [
        'image',
        'mount',
        'payment_date',
        'payment_concept_id',
        'bank_entity_id',
        'order_id',
    ];

    protected $casts = [
        'image' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentConcept()
    {
        return $this->belongsTo(PaymentConcept::class);
    }

    public function bankEntity()
    {
        return $this->belongsTo(BankEntity::class);
    }
}
