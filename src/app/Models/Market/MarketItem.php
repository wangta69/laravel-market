<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketItem extends Model
{

  use SoftDeletes;
  // protected $table = 'market_buyer';
  // protected $primaryKey = 'DB_num';
  public function display()
  {
    return $this->hasMany('App\Models\Market\MarketItemDisplay', 'item_id');
  }

  // public function category()
  // {
  //   return $this->hasOne('App\Models\Market\MarketItemCategory', 'item_id')->where('order', 0);
  // }

  public function categories()
  {
    return $this->hasMany('App\Models\Market\MarketItemCategory', 'item_id');
  }

  public function images()
  {
    return $this->hasMany('App\Models\Market\MarketItemImage', 'item_id');
  }

  public function options()
  {
    return $this->hasMany('App\Models\Market\MarketItemOption', 'item_id');
  }
  
  public function reviews()
  {
    return $this->hasMany('App\Models\Market\MarketItemReview', 'item_id');
  }

  public function qnas()
  {
    return $this->hasMany('App\Models\Market\MarketItemQna', 'item_id');
  }
  

}
