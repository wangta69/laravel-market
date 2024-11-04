<?php

namespace Pondol\Market\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketItemCategory extends Model
{
  use SoftDeletes;

  protected $fillable = ['item_id', 'category']; 
}
