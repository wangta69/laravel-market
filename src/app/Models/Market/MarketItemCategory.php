<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketItemCategory extends Model
{
  use SoftDeletes;

  protected $fillable = ['item_id', 'category']; 
}
