<?php
namespace Pondol\Market\Services;

use DB;

use Pondol\Market\Models\MarketOrder;
use Pondol\Market\Models\MarketBuyer;

class OrderService
{


  // public function orderList($user) {
  //   $items = MarketBuyer::select(
  //     'market_buyers.delivery_status',
  //     'order.user_id', 'order.item_id', 'order.o_id', 'order.qty', 'order.item_price', 'order.option_price', 'order.created_at',
  //     'item_count.count',
  //     'it.name', 'it.model', 'it.image',
  //     'pay.method', 'pay.status',
  //     'u.name as user_name'
  //     )
  //     ->Join('market_orders as order', function($join){
  //       $join->on('market_buyers.o_id', '=', 'order.o_id');
  //     })
  //     ->Join(DB::raw("(SELECT o_id, COUNT(o_id) as count, MAX(id) as max_id FROM market_orders GROUP BY market_orders.o_id) item_count"), function($join){
  //       $join->on('order.id', 'item_count.max_id');
  //     })
  //     ->Join('market_items as it', function($join){
  //       $join->on('it.id', '=', 'order.item_id');
  //     })
  //     ->Join('market_payments as pay', function($join){
  //       $join->on('pay.o_id', '=', 'order.o_id');
  //     })
      
  //     ->Join('users as u', function($join){
  //        $join->on('order.user_id', '=', 'u.id');
  //     });

  //     if($user !== 'admin') { // admin이 아닐경우 사용자 본인것만 보여준다.
  //       $items->where('order.user_id', $user);
  //     }
  //     // ->orderBy('market_orders.id', 'desc'); 
  //     return $items; // ->paginate(15)->withQueryString();
    
  // }


  public function orderList($user) {
    $items = MarketOrder::select(
      'market_orders.user_id', 'market_orders.o_id', 'market_orders.qty', 'market_orders.item_price', 'market_orders.option_price', 'market_orders.created_at',
      'orders.count',
      'it.name', 'it.model', 'it.image',
      'pay.method', 'pay.status',
      'buyer.delivery_status',
      'u.name as user_name'
      )
      ->Join(DB::raw("(SELECT o_id, COUNT(o_id) as count, MAX(id) as max_id FROM market_orders GROUP BY market_orders.o_id) orders"), function($join){
        $join->on('market_orders.id', 'orders.max_id');
      })
      ->leftJoin('market_items as it', function($join){
        $join->on('it.id', '=', 'market_orders.item_id');
      })
      ->leftJoin('market_payments as pay', function($join){
        $join->on('pay.o_id', '=', 'market_orders.o_id');
      })
      ->leftJoin('market_buyers as buyer', function($join){
        $join->on('buyer.o_id', '=', 'market_orders.o_id');
      })
      ->leftJoin('users as u', function($join){
         $join->on('market_orders.user_id', '=', 'u.id');
      });

      if($user !== 'admin') { // admin이 아닐경우 사용자 본인것만 보여준다.
        $items->where('market_orders.user_id', $user);
      }
      // ->orderBy('market_orders.id', 'desc'); 
      return $items; // ->paginate(15)->withQueryString();
    
  }



  /**
   * 동일 주문 내역에 속하는 모든 아이템을 가져온다.
   */
  public function orderItemsByOrderid($o_id) {
    $items = MarketOrder::select(
      'market_orders.id as order_id', 'market_orders.o_id', 'market_orders.qty', 'market_orders.item_price', 'market_orders.option_price', 'market_orders.options',
      'it.name', 'it.model', 'it.image', 'it.price'
      )
      ->leftJoin('market_items as it', function($join)
      {
        $join->on('it.id', '=', 'market_orders.item_id');
      })
      ->where('market_orders.o_id', $o_id);
      return $items; // ->paginate(15)->withQueryString();
  }

  public function orderDetailByOrderid($o_id) {
    $detail = MarketBuyer::select(
      'market_buyers.o_id', 'market_buyers.name', 'market_buyers.zip', 'market_buyers.addr1', 'market_buyers.addr2', 'market_buyers.tel1', 
      'market_buyers.message', 'market_buyers.courier', 'market_buyers.delivery_status','market_buyers.invoice_no',
      'pay.method', 'pay.status as pay_status', 'pay.inputer', 'pay.bank', 'pay.amt_point', 'pay.amt_product', 'pay.amt_delivery', 'pay.amt_total',
    'bank.code', 'bank.no', 'bank.owner'
      )
      ->leftJoin('market_payments as pay', function($join)
      {
        $join->on('pay.o_id', '=', 'market_buyers.o_id');
      })
      ->leftJoin('market_banks as bank', function($join){
        $join->on('bank.id', '=', 'pay.bank');
      })
      ->where('market_buyers.o_id', $o_id)->first();
      return $detail;

  }

}