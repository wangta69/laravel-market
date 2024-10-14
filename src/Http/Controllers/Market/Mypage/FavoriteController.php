<?php
namespace App\Http\Controllers\Market\Mypage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;


use App\Http\Controllers\Market\Traits\Favorite;

class FavoriteController extends Controller
{
  use Favorite;

  public function __construct(

  ){

  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function _index(Request $request)
  {
    
    // 마켙order 접근시 비회원 경우는 o_id가 있어야한다.
    $user = $request->user();
    $items = $this->index($request, $user);

    // 현재 선택한 상품을 리스트업 한다.
    $items = $items->orderBy('market_item_favorites.id', 'desc')->paginate(15)->withQueryString();

    return view('market.templates.userpage.'.config('market.template.userpage.theme').'.favorite', [
      'items' => $items,
    ]);

    
  }

  // public function view($o_id, Request $request) {
  //   $user = $request->user();
  //   $items = $this->orderSvc->orderItemsByOrderid($o_id)->orderBy('market_orders.id', 'desc')->get();  
  //   $display = $this->orderSvc->orderDetailByOrderid($o_id);
  //   $display->delivery_company = MarketDeliveryCompany::find($display->courier);

  //   // exit;

  //   return view('market.templates.'.config('market.template.userpage.theme').'.mypage.order-view', [
  //     'user' => $user,
  //     'items' => $items,
  //     'display' =>$display,
  //   ]);
  // }
}