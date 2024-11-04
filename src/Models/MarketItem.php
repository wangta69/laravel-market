<?php

namespace Pondol\Market\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketItem extends Model
{

  use SoftDeletes;
  public function display()
  {
    return $this->hasMany('Pondol\Market\Models\MarketItemDisplay', 'item_id');
  }

  public function categories()
  {
    return $this->hasMany('Pondol\Market\Models\MarketItemCategory', 'item_id');
  }

  public function images()
  {
    return $this->hasMany('Pondol\Market\Models\MarketItemImage', 'item_id');
  }

  public function options()
  {
    return $this->hasMany('Pondol\Market\Models\MarketItemOption', 'item_id');
  }
  
  public function reviews()
  {
    return $this->hasMany('Pondol\Market\Models\MarketItemReview', 'item_id');
  }

  public function qnas()
  {
    return $this->hasMany('Pondol\Market\Models\MarketItemQna', 'item_id');
  }
  

}
