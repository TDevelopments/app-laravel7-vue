<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adviser extends Model
{
  protected $fillable = [
      'name',
      'phone',
      'link'
  ];
}
