<?php

namespace Pondol\Market\Models;

use Illuminate\Database\Eloquent\Model;

class MarketBuyer extends Model
{
  protected $fillable = ['o_id']; 


  public function delivery_company()
  {
    return $this->hasOne('Pondol\Market\Models\MarketDeliveryCompany', 'id', 'courier');
  }

}
