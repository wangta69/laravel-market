<?php
namespace Pondol\Market\Http\Controllers\Mypage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use Pondol\Market\Models\MarketOrder;
use Pondol\Market\Models\MarketBank;
use Pondol\Market\Models\MarketDeliveryCompany;
use Pondol\Market\Models\MarketBuyer;
use Pondol\Market\Services\OrderService;
use Pondol\DeliveryTracking\Traits\Tracking;
use Pondol\Auth\Traits\Point; // _insertPoint

class OrderController extends Controller
{

  use Tracking, Point;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(
    OrderService $ordergSvc
  ){
    $this->orderSvc = $ordergSvc;
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
    $o_id = $request->o_id; 


    if(!$user && !$o_id) {
      return redirect()->route('login', ['f'=>'market.mypage.order']);
    } else if($o_id){ // 주문 아이디가 있을 경우 바로 상세 보기로 넘긴다.
      return redirect()->route('market.mypage.order.view', [$o_id]);
    }

    // DB::enableQueryLog();

    // 현재 선택한 상품을 리스트업 한다.
    $items = $this->orderSvc->orderList($user->id)->orderBy('market_orders.id', 'desc')->paginate(15)->withQueryString();

    return view(market_theme('userpage').'.order.orders', [
      'user' => $user,
      'items' => $items,
    ]);

    
  }

  public function view($o_id, Request $request) {
    $user = $request->user();
    $items = $this->orderSvc->orderItemsByOrderid($o_id)->orderBy('market_orders.id', 'desc')->get();  
    $display = $this->orderSvc->orderDetailByOrderid($o_id);
    $display->delivery_company = $this->_courier($display->courier);// MarketDeliveryCompany::find($display->courier);

    foreach($items as $item) {
      $item->displayOptions = extractOptions($item);
           
    }

    return view(market_theme('userpage').'.order.view', [
      'user' => $user,
      'items' => $items,
      'display' =>$display,
    ]);
  }

  public function statusUpdate($o_id, $status, Request $request) {
    $user = $request->user();
    $order = MarketBuyer::where('o_id', $o_id)->first();

    if($order->delivery_status == 90) {
      return response()->json(['error'=>'수취확인된 주문입니다.'], 203);
    }
    if($status == 50) { // 주문취소
      if($order->delivery_status < 0) {
        return response()->json(['error'=>'배송중이므로 주문을 취소할 수 없습니다.'], 203);
        // if($request->ajax()){
        //   return response()->json(['error'=>$validator->errors()->first()], 203);//500, 203
        // } else {
        //   return redirect()->back()->withErrors($validator->errors())->withInput($request->except('password'));
        // }
      } else {
        $order->delivery_status = $status;
        $order->save();
        return response()->json(['error'=>false, 'next'=>null], 200);
      }
    } else { // 거래완료
      // 거래완료시점에 상품 구매 포인트를 회원에게 제공한다.
      if($status == 90) {

        // 적립포인트 계산
        $orders = MarketOrder::where('o_id', $o_id)->get();
        $savings = 0;
        foreach($orders as $o) {
          $savings =+ floor($o->point * $o->qty);
        }

        if($savings) {
          $this->_insertPoint($user, $savings, $item = 'order', $o_id);
        }
      }

      $order->delivery_status = $status;
      $order->save();
      return response()->json(['error'=>false], 200);
    }
  }
}