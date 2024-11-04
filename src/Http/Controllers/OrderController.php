<?php
namespace Pondol\Market\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Log;

use DB;
use Validator;

use Pondol\Market\Models\MarketItem;
use Pondol\Market\Models\MarketCart;
use Pondol\Market\Models\MarketBuyer;
use Pondol\Market\Models\MarketBank;
use Pondol\Market\Models\MarketPayment;
use Pondol\Market\Models\MarketOrder;
use Pondol\Market\Models\MarketAddress;

use Pondol\Market\Services\ConfigService;
use Pondol\Market\Services\CalDeliveryFee;

use App\Events\OrderShipped;
use Pondol\Auth\Traits\Point;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

  use Point;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(
    ConfigService $configSvc,
    CalDeliveryFee $delivery
    // PointService $pointSvc
  ){
    $this->configSvc = $configSvc;
    $this->delivery = $delivery;
    // $this->pointSvc = $pointSvc;
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    $user = $request->user();
    $orders = session()->get('orderItmes'); 
    // $o_id = session()->get('o_id'); 
    $o_id = $this->order_session('new');


   
    if(!$orders) {
      return redirect()->route('market.cart');
    }
    // 현재 선택한 상품을 리스트업 한다.
    $items = MarketCart::
      select(
        'market_carts.qty', 'market_carts.item_price', 'market_carts.option_price', 'market_carts.options',
        'market_items.id', 'market_items.name', 'market_items.image', 'market_items.model', 'market_items.price')
      ->whereIn('market_carts.id', $orders)
      ->leftjoin('market_items', function($join){
        $join->on('market_items.id', '=', 'market_carts.item_id');
      })->orderby('market_carts.id', 'desc')->get();

    if ($items->isEmpty()) { // 장바구니로 이동
      return redirect()->route('market.cart');
    }

    foreach($items as $item) {
      $item->displayOptions = extractOptions($item);     
    }


    // 기존 배송지들을 가져온다.
    $addresses = new \stdClass;
    $default_addr = new \stdClass;
    if($user) {
      $addresses = MarketAddress::where('user_id', $user->id)->orderBy('default', 'desc')->orderBy('updated_at', 'desc')->get();
      
      foreach($addresses as $v) {
        if ($v->default == 1) {
          $default_addr = $v;
        }
      }
    }

    
    $display = new \stdClass;
    $display->totalPrice = 0;
    $display->products = $items[0]->name;
    if(count($items) > 1) {
      $display->products .= '외 '.(count($items)-1).'종';
    }
    

  
    foreach($items as $v) {
      $display->totalPrice += ($v->item_price + $v->option_price) * $v->qty;
    }

    $display->user_point = $user->point ?? 0;
    // 배송비 계산
    $display->delivery_fee = $this->delivery->cal($display->totalPrice);


    // 주문을 시도했던 것은 다시 내용을 보여주고 만약 결제가 완료(주문 완료시점에 모든 세션삭제해야되지만 에러로 인해)된 것이라면 
    // 다시 기본 정보를 보여준다.
    $buyer = MarketBuyer::where('o_id', $o_id)->first();
    if (!$buyer) {
      $buyer = new \stdClass;
    }
    
    // if ($o_id) {
    //   $buyer = MarketBuyer::where('o_id', $o_id)->first();
    // } else if($default_addr) {
    $buyer->o_id = $o_id;
    $buyer->tel1 = isset($buyer->tel1) ? $buyer->tel1 : isset($default_addr->tel1) ? $default_addr->tel1 : null;
    $buyer->name = isset($buyer->name) ? $buyer->name : isset($default_addr->name) ? $default_addr->name : null;
    $buyer->zip = isset($buyer->zip) ? $buyer->zip : isset($default_addr->zip) ? $default_addr->zip : null;
    $buyer->addr1 = isset($buyer->addr1) ? $buyer->addr1 : isset($default_addr->addr1) ? $default_addr->addr1 : null;
    $buyer->addr2 = isset($buyer->addr2) ? $buyer->addr2 : isset($default_addr->addr2) ? $default_addr->addr2 : null;
    $buyer->message = isset($buyer->message) ? $buyer->message :  isset($default_addr->message) ? $default_addr->message : null;
    // }

    if($buyer->tel1) {
      $tel1 = explode('-', $buyer->tel1);
    }

    $buyer->tel1_1 = isset($tel1[0]) ? $tel1[0] : '';
    $buyer->tel1_2 = isset($tel1[1]) ? $tel1[1] : '';
    $buyer->tel1_3 = isset($tel1[2]) ? $tel1[2] : '';

    // 무통장 계좌 가져오기]
    $codes = $this->configSvc->get('banks');
    $banks = MarketBank::get();
    foreach($banks as $v) {
      $v->name = $codes[$v->code]['name'];
    }
    
    return view('market.templates.order.'.config('pondol-market.template.order.theme').'.order', [
      'user' => $user,
      'items' => $items,
      'buyer' => $buyer,
      'display' => $display,
      'banks' => $banks,
      'addresses' => $addresses
    ]);
  }

  public function setOrderItems(Request $request)
  {
    $request->session()->put('orderItmes', $request->order);
    return redirect()->route('market.order');
  }

  /**
   * 주문 1단계 회원전용 or /비회원
   */
  public function checkMember() {

  }

  /**
   *   배송지 정보 저장
   */
  public function storeAddress(Request $request) {
    // print_r($request->all());
    $user = $request->user();

    $validator = Validator::make($request->all(), [
      'zip' => ['required'],
      'addr1' => ['required', 'string'],
      'addr2' => ['required', 'string'],
      'name' => ['required'],
      'paytype' => ['required'],
    ], []);

    $validator->sometimes('tel1', 'required', function ($request) {
      return !$request->tel1_1;
    });

    $validator->sometimes(['tel1_1', 'tel1_2', 'tel1_3'], 'required', function ($request) {
      return !$request->tel1;
    });

    $validator->sometimes(['bank', 'inputer'], 'required', function ($request) {
      return $request->paytype == 'online';
    });


    if ($validator->fails()) {
      return response()->json(['error'=>$validator->errors()->first()], 203);
    }
    // 먼저 orderId에 대한 session을 생성

    $orders = $request->session()->get('orderItmes');  // 상품정보 가져오기

    $o_id = $this->order_session();


    // 배송지 정보 입력
    $buyer = MarketBuyer::firstOrNew(['o_id' => $o_id]);

    $tel1 = str_replace('-', '', $request->tel1);
    if (!$tel1) {
      $tel1 = $request->tel1_1.$request->tel1_2.$request->tel1_3;
    }
    $buyer->user_id = $user ? $user->id : null;
    $buyer->name = $request->name;
    $buyer->zip = $request->zip;
    $buyer->addr1 = $request->addr1;
    $buyer->addr2 = $request->addr2;
    $buyer->tel1 = $tel1;
    $buyer->message = $request->message;

    $buyer->delivery_status = 0;
    $buyer->save();

    // address에 신규 address 자동 추가
    if($user->id) {
      $address = MarketAddress::where('user_id', $buyer->user_id)
        ->where('zip', $buyer->zip)
        ->where('addr1', $buyer->addr1)
        ->where('addr2', $buyer->addr2)
        ->first();
      if(!$address) { // 동일 주소가 존재 하지 않으면 주소를 입력한다.
        $address = new MarketAddress;
        $address->user_id = $buyer->user_id;
        $address->zip = $buyer->zip;
        $address->addr1 = $buyer->addr1;
        $address->addr2 = $buyer->addr2;
      }
      $address->name = $buyer->name;
      $address->tel1 = $buyer->tel1;
      $address->message = $buyer->message;
      $address->save(); // 최근 사용한 것을 업데이트 하기위해

      // default 가 있는지 확인하고 default가 없으면 현재 address를 default로 입력한다.
      $default = MarketAddress::where('user_id', $buyer->user_id)
        ->where('default', 1)
        ->count();
      if(!$default) {
        $address->default = 1;
        $address->save();
      }
    }
    return response()->json([
      'error' => false
    ]);
    // 모든 것이 정상적으로 되었으면 리턴 하고 프론트에서 다시 결제 창 처리
    // 결제가 완료되면 그대로 처리
  }

  public function storePayment(Request $request) {
    $user = $request->user();
    
    $paytype = $request->paytype; // online / card
    $pointamount = (int)str_replace(',', '', $request->pointamount);
    $total = str_replace(',', '', $request->total); // 실제 결제 금액
    $bank = $request->bank;
    $inputer = $request->inputer;

    // 실제 결제 금액 및 포인트 정리 및 금액 일치 여부 확인(실제 계산치와 프론트에서 넘어온 total을 비교)
    $orders = session()->get('orderItmes'); 
    $o_id = session()->get('o_id'); 

    // 현재 선택한 상품을 리스트업 한다.
    $items = MarketCart::
      select(
        'market_carts.id', 'market_carts.c_id', 'market_carts.item_id', 'market_carts.item_price', 'market_carts.qty', 
        'market_carts.option_price', 'market_carts.point', 'market_carts.options'
      )
      ->whereIn('market_carts.id', $orders)
      ->get();

    if($pointamount < 0) {
      return response()->json([
        'error' => '사용할 포인트가 잘못 되었습니다.',
      ]);
    }

    
    // 총 상품 금액
    $totalPrice = 0;
    foreach($items as $v) {
      $totalPrice += ($v->item_price + $v->option_price) * $v->qty;
    }

    $user_point = $user->point ?? 0;
    // 배송비 계산
    $delivery_fee = $this->delivery->cal($totalPrice);
    

    if($user_point < $pointamount) {
      return response()->json([
        'error' => '보유 포인트보다 사용하신 포인트가 많습니다.',
      ]);
    }

    $sum = $totalPrice + $delivery_fee - $pointamount;
    \Log::info('totalPrice:'.$totalPrice .', delivery_fee:'. $delivery_fee.', pointamount:'. $pointamount);
    \Log::info('sum:'.$sum .', total:'. $total);
    if($sum != $total) {
      return response()->json([
        'error' => '결제 금액이 일치하지 않습니다.',
      ]);
    }
    DB::beginTransaction();
    try {
      // 결제 정보 저장
      $payment = new MarketPayment;
      $payment->user_id = $user->id ?? null;
      $payment->o_id = $o_id;
      $payment->method = $paytype;
      $payment->status = 0; # : 지불대기
      $payment->sequence_no = null;
      $payment->bank = $bank;
      $payment->inputer = $inputer;
      $payment->amt_point = $pointamount;
      $payment->amt_product = $totalPrice;
      $payment->amt_delivery = $delivery_fee;
      $payment->amt_total =  $total;
      $payment->save();
      // 회원 포인트 변경
      if($user) {
        $this->_insertPoint($user, -$pointamount, 'buy', null, $payment->id);
      }
      // market_orders에 입력
      foreach($items as $v) {
        $orders = new MarketOrder;
        $orders->user_id = $user->id ?? null;
        $orders->o_id = $o_id;
        $orders->item_id =  $v->item_id;
        $orders->qty = $v->qty;;
        $orders->item_price = $v->item_price;
        $orders->option_price = $v->option_price;
        $orders->point = $v->point;
        $orders->options = $v->options;
        $orders->save();

        // 현재 장바구니에서 삭제
        MarketCart::where('id', $v->id)->delete();
      }

      // $user->
      event(new OrderShipped($user, $o_id));

      DB::commit();

     
      // 세션 삭제
      $request->session()->forget(['orderItmes', 'o_id']);

      return response()->json([
        'error' => false, 
        'o_id'=>$o_id
      ]);

      // 마이페이지 > 주문내역으로 이동
    } catch (\Exception $e) {
      DB::rollback();
      Log::info($e->getMessage());
      return response()->json([
        'error' => '결제중 에러가 발생하였습니다.',
        'message' =>$e->getMessage()
      ]);
    }
  }

  private function order_session($flag = null) {
    // $o_id = session('o_id');
    $o_id = session()->get('o_id'); 
    if (!$o_id || $flag === 'new') {
      $o_id = uniqid();
      session(['o_id'=> $o_id]);
    }
    return $o_id;
  }

}