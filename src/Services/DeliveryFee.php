<?php
namespace Pondol\Market\Services;

class DeliveryFee
{

  public function cal($total) {
    $delivery = jsonval('market.delivery');

    $delivery_fee = 0;

    if($total < $delivery["min"] || $delivery["type"] === 'apply') {
      $delivery_fee = $delivery["fee"];
    }
      
    return (int)$delivery_fee;
    
  }

  public function view() {
    $delivery = jsonval('market.delivery');
    switch($delivery["type"]) {
      case 'none':
        return '무료';
      case 'on_delivery':
        return '착불';
      case 'apply':
        return number_format($delivery["fee"]);
      case 'partial':
        return number_format($delivery["fee"]).'('. number_format($delivery["min"]). ' 미만) ';
    }
  }


}