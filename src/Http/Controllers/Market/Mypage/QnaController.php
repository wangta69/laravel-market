<?php
namespace App\Http\Controllers\Market\Mypage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use App\Models\Market\MarketItemQna;
// use App\Models\Market\MarketBank;
// use App\Http\Controllers\Market\Services\OrderService;

class QnaController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(
    // OrderService $ordergSvc
  ){
    // $this->orderSvc = $ordergSvc;
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    // 마켙order 접근시 비회원 경우는 o_id가 있어야한다.
    $user = $request->user();

    // DB::enableQueryLog();

    $items = MarketItemQna::select(
      'market_item_qnas.item_id', 'market_item_qnas.title', 'market_item_qnas.content', 'market_item_qnas.reply', 'market_item_qnas.created_at',
      'it.name', 'it.image'
    )->join('market_items as it', function($join){
      $join->on('market_item_qnas.item_id', '=', 'it.id');
    })
    ->where('market_item_qnas.user_id', $user->id)
    ->orderBy('market_item_qnas.id', 'desc')->paginate(15)->withQueryString();
    // 현재 선택한 상품을 리스트업 한다.
    // $items = $this->orderSvc->orderList($user->id)->orderBy('market_orders.id', 'desc')->paginate(15)->withQueryString();

    return view('market.templates.userpage.'.config('market.template.userpage.theme').'.qnas', [
      'user' => $user,
      'items' => $items,
    ]);

    
  }



}