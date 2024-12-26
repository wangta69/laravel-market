<?php
namespace Pondol\Market\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Validator;
use DB;

use Pondol\Market\Models\MarketItem;
use Pondol\Market\Models\MarketCart;
use Pondol\Market\Facades\DeliveryFee;
use Pondol\Meta\Facades\Meta;
use App\Http\Controllers\Controller;

class CartController extends Controller
{

  // private $cart_cookie = null;
  // private $c_id = null;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    
  }

  public function index(Request $request) 
  {

    $user = $request->user();
    $c_id = $this->cart_cookie();
    $meta = Meta::get();


    $items = MarketCart::select(
      'market_carts.id','market_carts.item_id', 'market_carts.qty', 'market_carts.item_price', 'market_carts.option_price', 'market_carts.options',
      'market_items.name', 'market_items.image', 'market_items.model', 'market_items.price')
    ->leftjoin('market_items', function($join){
      $join->on('market_items.id', '=', 'market_carts.item_id');
    });
    if($user) { // 로그인 된 회원이면
      if($c_id) { // 로그인전 cart에 담은 것을 업데이트 한다.
        MarketCart::whereNull('user_id')->where('c_id', $c_id)->update(['user_id'=>$user->id]);
      }
      $items->where('market_carts.user_id', $user->id);
    } else if($c_id) {
      $items->where('market_carts.c_id', $c_id)->whereNull('market_carts.user_id');
    }

    $items = $items->orderby('market_carts.id', 'desc')->get();


    foreach($items as $item) {
      $item->displayOptions = extractOptions($item);   
    }

    // 옵션을 분리하여 처리한다.

    return view('market.templates.cart.'.config('pondol-market.template.cart.theme').'.cart', compact('items', 'meta'));
  }

  public function store(Request $request)
  {
    $c_id = $this->cart_cookie();
    $user = $request->user();


    $item_id = $request->item;
    $options = $request->options;
    $qty = $request->qty;
    // $item_price = $request->item_price; // 사용자에게 보여진 totalPrice 및 아래 프로그램에서 다시 계산한 토탈 price가 동일해야 한다.
    // $optionPrice = $request->optionPrice; (아래에서 자동으로 계산)
    $direct = $request->direct; // direct 에 값이 있는 경우 바로구매로 처리된다.

    // 옵션이 있는 경우 모든 옵션값이 선택되어져야 한다.
    if(is_array($options)) {
      foreach($options as $v) {
        if(!$v) {
          return response()->json([
            'error' => '옵션을 선택해 주세요'
          ]);
        }
      }
    }

    // 현재 제품 정보를 가져온다(주문후 제품정보가 변경되더라도 구매당시의 제품 유지 하기 위해)
    $item = MarketItem::find($item_id);

    // $requstPayPrice = ($prdPrice + $optionPrice) * $qty;

    // 실제 가격을 구한다.
    // $realPrice = $item->price;
    // $realOptionPrice = 0;
    // $optionStr = [];

    $optionInfo = $this->parsingOptions($options, $item); // return ['price'=>$price, 'options'=>$options];
    $option_price = $optionInfo['price'];

    // $realPayPrice = ($item->price + $$optionInfo['price']) * $qty;


    // if ($realPayPrice !== $requstPayPrice) {
    //   return response()->json([
    //     'error' => '품절되었거나 제품가격에 변동이 발생하였습니다.'
    //   ]);
    // }

    if ($user) { // 로그인전 장바구니에 넣었다가 로그인 한 경우 이곳을 업데이트 한다.
      MarketCart::where('c_id', $c_id)->whereNull('user_id')->update(['user_id'=>$user->id]);
      // 기존 장바구니 쿠키는 삭제한다.
      
    }

    $cart = new MarketCart;
    $cart->user_id = $user ? $user->id : null;
    $cart->c_id = $c_id;
    $cart->item_id = $item->id;
    $cart->options = implode("|", $optionInfo['options']);
    $cart->qty = $qty;
    $cart->item_price = $item->price;
    $cart->option_price = $option_price;
    $cart->point = $item->t_point;

    $cart->save();

    if($direct) {
      $request->session()->put('orderItmes', ['order'=>$cart->id]);
    }

    return response()->json([
      'error' => false,
      'next'=>route('market.cart'),
      'order'=>route('market.order')
    ]);

    // 내 카드로 이동
    // if($this->cart_cookie) {
    //   return redirect()->route('market.cart')->cookie($this->cart_cookie);
    // } else {
      return redirect()->route('market.cart'); //->cookie('c_id', $this->c_id, 60);
    // }
    
  }

  // 아래 부터는 예전 코드
  private function cart_cookie() {
   
    $c_id = request()->cookie('c_id');
    if (!$c_id) {
      $MicroTsmp = explode(' ', microtime());
      $START_TIME = $MicroTsmp[0] + $MicroTsmp[1];
      $c_id = substr(str_replace(".", "", $START_TIME), 0, 13); // 장바구니고유코드
      cookie()->queue(cookie('c_id', $c_id, 60*60*24*7));
    }
    return $c_id;
  }

  private function parsingOptions($option_ids, $item) {
    $price = 0;
    $options = [];
    if(is_array($option_ids)) {
      foreach($option_ids as $v) {
        $option = $item->options()->find($v);
        if(isset($option->price)) {
          $price += $option->price;
          array_push($options, $option->id.':'.$option->title.':'.$option->name.':'.$option->price);
        }
      }
    }
    return ['price'=>$price, 'options'=>$options];
  }


  /**
   * 카트의 개별 item 삭제
   */
  public function destroy(MarketCart $cart, Request $request) {
    $c_id = $this->cart_cookie();
    $user = $request->user();

    if($cart->c_id == $c_id || ($user->id && $user->id == $cart->user_id)) {
      $cart->delete();
      return response()->json([
        'error' => false
      ]);
    } else {
      return response()->json([
        'error' => '잘못된 접근입니다.'
      ]);
    }  
  }

  /**
   * 카트의 선택 아이템 삭제
   */
  public function destroyChecked(Request $request) { // MarketCart $cart, 
    
    $c_id = $this->cart_cookie();
    $user = $request->user();
    $ids = $request->order;
    if(is_array($ids)) {
      foreach($ids as $id) {
        $cart = MarketCart::find($id);
        if($cart->c_id == $c_id || ($user->id && $user->id == $cart->user_id)) {
          $cart->delete();
        }
      }
      return response()->json([
        'error' => false
      ]);
    }

    return response()->json([
      'error' => '장바구니에서 삭제할 상품을 선택해 주세요'
    ]);
 
      
    // } else {
    //   return response()->json([
    //     'error' => '잘못된 접근입니다.'
    //   ]);
    // }  
  }

  public function updateQty(Request $request) {
    $user = $request->user();
    $c_id = $this->cart_cookie();

    $id = $request->id;
    $qty = $request->qty;


    $cart = MarketCart::find($id);

    if($cart->c_id == $c_id || $cart->user_id == $user->id) {
      $cart->qty = $qty;
      $cart->save();
      return response()->json(['error' => false]);
    } else {
      return response()->json(['error' => '잘못된 접근입니다.']);
    }
  }

  public function updateOverview(Request $request) {
    $orders = $request->order;
    $display = new \stdClass;

    if(!$orders) {
      $display->totalPrice = 0;
      $display->delivery_fee = 0;
      
      return response()->json(['error' => false, 'display'=>$display]);
    }
    $items = MarketCart::
      select(
        'market_carts.qty', 'market_carts.item_price', 'market_carts.option_price')
      ->whereIn('market_carts.id', $orders)
      ->get();

      $display = new \stdClass;
      $display->totalPrice = 0;
      
      foreach($items as $v) {
        $display->totalPrice += ($v->item_price + $v->option_price) * $v->qty;
      }
  
      // 배송비 계산
      $display->delivery_fee = DeliveryFee::cal($display->totalPrice);

      return response()->json(['error' => false, 'display'=>$display]);
  }
}