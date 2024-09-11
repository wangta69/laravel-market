<?php
namespace App\Http\Controllers\Market\Mypage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use DB;
use Validator;

use App\Models\Market\MarketOrder;
use App\Models\Market\MarketExchangeReturn;
use App\Models\Market\MarketBank;
// use App\Models\Market\MarketDeliveryCompany;
// use App\Models\Market\MarketBuyer;
use App\Http\Controllers\Market\Services\OrderService;
use App\Http\Controllers\Controller;
class CancelReturnExchangeController extends Controller
{
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


  public function index(Request $request) {

    $user = $request->user();

    $items = MarketExchangeReturn::from('market_exchange_returns as re') ->select(
      're.id', 're.type', 're.created_at', 're.qty', 're.item_price', 're.option_price','re.options',
      're.status', 're.issue_id',
      'it.name', 'it.model', 'it.image',
      'o.o_id', 'o.created_at as order_created_at'
      )->withTrashed()
      

      ->join('market_items as it', function($join){
        $join->on('it.id', '=', 're.item_id');
      })

      ->join('market_orders as o', function($join){
        $join->on('re.order_id', '=', 'o.id');
      })
      
      ->whereNull("re.deleted_at")
      ->where("re.user_id", $user->id)
      ->orderBy('re.id', 'desc')->paginate(15)->withQueryString();

    $return_status = config('market.return_status');
    $exchange_status = config('market.exchange_status');
    foreach($items as $item) {
      $item->displayOptions = extractOptions($item);
      switch($item->type) {
        case 'exchange':
          $item->statusStr = $exchange_status[$item->status];
          break;
        case 'return':
          $item->statusStr = $return_status[$item->status];
          break;
      }
    }

    return view('market.templates.userpage.'.config('market.template.userpage.theme').'.cancel-return-exchange.index', [
      'items'=>$items,
      'return_status' => config('market.return_status'),
      'exchange_status' => config('market.exchange_status')
    ]);
  }
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function create($type, $o_id, Request $request)
  {

    // 마켙order 접근시 비회원 경우는 o_id가 있어야한다.
    $user = $request->user();



    // if(!$user && !$o_id) {
    //   return redirect()->route('market.login', ['f'=>'market.mypage.order']);
    // } else if($o_id){ // 주문 아이디가 있을 경우 바로 상세 보기로 넘긴다.
    //   // return redirect()->route('market.mypage.order.view', [$o_id]);
      
    // }

    // DB::enableQueryLog();

    // 현재 선택한 상품을 리스트업 한다.
    $items = $this->orderSvc->orderItemsByOrderid($o_id)->orderBy('market_orders.id', 'desc')->paginate(15)->withQueryString();

    foreach($items as $item) {
      $item->displayOptions = extractOptions($item);
    }


    $typeStr = '';
    switch($type) {
      case 'return':
        $typeStr = '반품';
        break;
      case 'exchange':
        $typeStr = '교환';
        break;
    }

    return view('market.templates.userpage.'.config('market.template.userpage.theme').'.cancel-return-exchange.create', [
      'type'=>$type,
      'o_id'=>$o_id,
      'items' => $items,
      'typeStr' => $typeStr
    ]);

    
  }

  public function store($type, $o_id, Request $request) {


    $validator = Validator::make($request->all(), [
      'order_id' => ['required'],
      'contact' => ['required', 'string'],
      'reason' => ['required', 'string']
    ], []);

    if ($validator->fails()) {
      if($request->ajax()){
        return response()->json(['error'=>$validator->errors()->first()], 203);//500, 203
      } else {
        return redirect()->back()->withErrors($validator->errors())->withInput();
      }
    }

    $order_id = $request->order_id;
    $qty = $request->qty;
    $contact = $request->contact;
    $reason = $request->reason;

    $issue_id = uniqid(); // 


    foreach($order_id as $v) {

      $order = MarketOrder::find($v);
      $issue = new MarketExchangeReturn;


      $issue->type = $type;
      $issue->issue_id = $issue_id;
      $issue->contact = $contact;
      $issue->reason = $reason;

      $issue->user_id = $order->user_id;
      $issue->order_id = $order->id;
      $issue->item_id = $order->item_id;
      $issue->qty = $qty[$v];
      $issue->item_price = $order->item_price;
      $issue->option_price = $order->option_price;
      $issue->point = $order->point;
      $issue->options = $order->options;
      $issue->save();

    }

   


    if($request->ajax()){
      return response()->json(['error'=>false], 200);//500, 203
    } else {
      return redirect()->route('market.mypage.order.cancel-return-exchanges');
    }

  }

  public function view($id, Request $request) {

    $item = MarketExchangeReturn::from('market_exchange_returns as re')
    ->select(
      're.id', 're.type', 're.status', 're.created_at', 're.qty', 're.item_price', 're.option_price','re.options',
      're.contact', 're.reason',
      'it.name', 'it.model', 'it.image',
      'o.o_id', 'o.created_at as order_created_at'
    )
    ->join('market_items as it', function($join){
      $join->on('it.id', '=', 're.item_id');
    })

    ->join('market_orders as o', function($join){
      $join->on('re.order_id', '=', 'o.id');
    })
    
    ->withTrashed()->where('re.issue_id', $id)->first();

    $item->displayOptions = extractOptions($item);

    

    switch($item->type) {
      case 'return':
        $configs = config('market.return_status');
        break;
      case 'exchange':
        $configs = config('market.exchange_status');
        break;
    }


    return view('market.templates.userpage.'.config('market.template.userpage.theme').'.cancel-return-exchange.view', [
      'item'=>$item,
      'configs' => $configs,
    ]);
  }

  /**
   * 환불계좌
   */
  public function refund(Request $request) {
    $bank = MarketBank::where('type', 'user')->first();
    if(!$bank) {
      $bank = new \stdClass;
      $bank->id = null;
      $bank->code = null;
      $bank->no = null;
      $bank->owner = null;
    }
    $codes = config('market.banks');
    return view('market.templates.userpage.'.config('market.template.userpage.theme').'.cancel-return-exchange.refund', [
      'bank'=>$bank,
      'codes' => $codes
    ]);
  }

  public function refundUpdate(Request $request) {
    $user = $request->user();

    $validator = Validator::make($request->all(), [
      'code' => ['required'],
      'no' => ['required', 'string'],
      'owner' => ['required', 'string']
    ], []);

    if ($validator->fails()) {
      if($request->ajax()){
        return response()->json(['error'=>$validator->errors()->first()], 203);//500, 203
      } else {
        return redirect()->back()->withErrors($validator->errors())->withInput();
      }
    }

    $id = $request->id;
    $code = $request->code;
    $no = $request->no;
    $owner = $request->owner;

    if($id) { // update
      $bank = MarketBank::find($id);
    } else { // store
      $bank = new MarketBank;
    }
    $bank->type = 'user';
    $bank->user_id = $user->id;
    $bank->code = $code;
    $bank->no = $no;
    $bank->owner = $owner;
    $bank->save();
    
    if($request->ajax()){
      return response()->json(['error'=>false], 200);//500, 203
    } else {
      return redirect()->route('market.mypage.order.refund');
    }

  }

}