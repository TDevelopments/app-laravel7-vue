<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'action',
        'model_type',
        'model_id',
        'user_id',
        'creation_date',
    ];

    protected $casts = [
        'creation_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
