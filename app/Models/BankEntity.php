<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankEntity extends Model
{
    protected $fillable = [
        'name',
        'short_name',
        'account_name',
        'account_soles',
        'account_interbank_soles',
        'account_dollar',
        'account_interbank_dollar',
    ];
}
