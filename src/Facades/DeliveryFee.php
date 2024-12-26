<?php
namespace Pondol\Market\Facades;

use Illuminate\Support\Facades\Facade;

class DeliveryFee extends Facade
{

  protected static $cached = false;
  protected static function getFacadeAccessor()
  {
    return 'market-delivery-fee';
  }
}
