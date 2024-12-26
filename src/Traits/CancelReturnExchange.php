<?php
namespace Pondol\Market\Traits;

use Pondol\Market\Models\MarketExchangeReturn;
// use Pondol\Market\Models\MarketItemFavorite;

trait CancelReturnExchange {

  public function _index() {
    $items = MarketExchangeReturn::from('market_exchange_returns as re') ->select(
      're.id', 're.type', 're.created_at', 're.qty', 're.item_price', 're.option_price','re.options',
      're.status',
      'it.name', 'it.model', 'it.image',
      'o.o_id', 'o.created_at as order_created_at'
      )->withTrashed()
      

      ->join('market_items as it', function($join){
        $join->on('it.id', '=', 're.item_id');
      })

      ->join('market_orders as o', function($join){
        $join->on('re.order_id', '=', 'o.id');
      })
      
      ->whereNull("re.deleted_at");

    return $items;
  }
}