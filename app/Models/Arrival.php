<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogue;

class Arrival extends Model
{
    // use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // protected $casts = [
    //     'arrival_date' => 'datetime'
    // ];

    protected $fillable = [
        'city',
        'arrival_date',
        'catalogue_id'
    ];

    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class);
    }
}
