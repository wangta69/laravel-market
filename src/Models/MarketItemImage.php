<?php

namespace Pondol\Market\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class MarketItemImage extends Model
{
  protected $fillable = ['item_id', 'image', 'order']; 
}
