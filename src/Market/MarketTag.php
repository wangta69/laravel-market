<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Model;

class MarketTag extends Model
{
  protected $fillable = ['tag']; // , 'gender', 'item']; //

  const CREATED_AT = null;
  const UPDATED_AT = null;
}
