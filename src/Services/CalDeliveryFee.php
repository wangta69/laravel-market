<?php
namespace Pondol\Market\Services;

class CalDeliveryFee
{

  public function cal($total) {
    $delivery = config('pondol-market.delivery');

    $delivery_fee = 0;

    if($total < $delivery["min"] || $delivery["type"] === 'apply') {
      $delivery_fee = $delivery["fee"];
    }
      
    return (int)$delivery_fee;
    
  }


}