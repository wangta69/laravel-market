<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Model;

class MarketBuyer extends Model
{
  // protected $table = 'market_buyer';
  // protected $primaryKey = 'DB_num';
  protected $fillable = ['o_id']; 


  public function delivery_company()
  {
    return $this->hasOne('App\Models\Market\MarketDeliveryCompany', 'id', 'courier');
  }

}
