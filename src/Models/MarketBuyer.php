<?php

namespace Pondol\Market\Models;

use Illuminate\Database\Eloquent\Model;

class MarketBuyer extends Model
{

  public const STATUS = [
    'READY' => 0, // 배송대기(주문접수)
    'DELIVERING' => 10, // 배송중,  
    'SENT' => 30, // 배송완료, 
    'CANCEL' => 40, // 주문취소, 
    'REFUND' => 50, // 반품, 
    'EXCHANGE' => 60, // 교환, 
    'EXCHANGEDONE' => 70, // 교환완료, 
    'DONE' => 90, // 거래완료
  ];

  protected $fillable = ['o_id']; 

  public function delivery_company()
  {
    return $this->hasOne('Pondol\Market\Models\MarketDeliveryCompany', 'id', 'courier');
  }

}
