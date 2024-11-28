<?php
namespace Pondol\Market\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use DB;
use Carbon\Carbon;
use Pondol\Market\Models\MarketOrder;
use Pondol\Market\Models\MarketBuyer;
use Pondol\Market\Models\MarketPayment;

use Pondol\Market\Services\ConfigService;
use Pondol\Market\Services\OrderService;

use Pondol\DeliveryTracking\Traits\Tracking;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  use Tracking;

  public function __construct(
    ConfigService $configSvc,
    OrderService $ordergSvc
  )
  {
    $this->configSvc = $configSvc;
    $this->orderSvc = $ordergSvc;
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    DB::enableQueryLog();
    $sk = $request->sk;
    $sv = $request->sv;
    $from_date = $request->from_date;
    $to_date = $request->to_date;
    

 
    $delivery_status = $request->delivery_status;

    $items = $this->orderSvc->orderList('admin');

    if ($sv) {
      $items = $items->where($sk, 'like', '%' . $sv . '%');
    }

    if ($from_date) {
      if (!$to_date) {
        $to_date = date("Y-m-d");
      }

      $from_date = Carbon::createFromFormat('Y-m-d', $from_date);
      $to_date = Carbon::createFromFormat('Y-m-d', $to_date);
      $items =  $items->whereBetween('buyer.created_at', [$from_date->startOfDay(), $to_date->endOfDay()]);


      // $from_date = $from_date.' 00:00:00';
      // $to_date = $to_date.' 23:59:59';
      // $items = $items->where(function ($q) use($from_date, $to_date) {
      //   // qiuery 속도를 위해 DATE 함수는 사용하지 않는다.
      //   // $q->whereRaw("DATE(buyer.created_at) >= '".$from_date."' AND DATE(buyer.created_at)<= '".$to_date."'" );
      //   $q->whereRaw("buyer.created_at >= '".$from_date."' AND buyer.created_at <= '".$to_date."'" );
      // });
    }
    $status_array = [];
    if(!$delivery_status) {
      $delivery_status = ['ready', 'ing'];
    }
    foreach($delivery_status as $v) {
      switch($v) {
        case 'ready': $status_array = array_merge($status_array, [0]); break;
        case 'ing':$status_array = array_merge($status_array, [10, 30]);  break;
        case 'done': $status_array = array_merge($status_array, [90]); break;
      }
    }
    $request->merge(['delivery_status' => $delivery_status]);

   
    $items = $items->whereIn('buyer.delivery_status', $status_array);

    $items = $items->orderBy('market_orders.id', 'desc')
      ->paginate(15)->withQueryString();
    // print_r(DB::getQueryLog());
    return view('market::admin.order.index', [
      'items'=>$items
    ]);
  }

  /**
   * 주문배송 상세보기
   */
  public function view($o_id) {
    $items = $this->orderSvc->orderItemsByOrderid($o_id)->orderBy('market_orders.id', 'desc')->get();     
    $display = $this->orderSvc->orderDetailByOrderid($o_id);

    $couriers = $this->_couriers();

    $delivery_status = $this->configSvc->get('delivery_status');
    $pay_status = $this->configSvc->get('pay_status');
    

    return view('market::admin.order.view', [
      'items'=>$items,
      'display'=>$display,
      'couriers'=>$couriers,
      'delivery_status'=>$delivery_status,
      'pay_status'=>$pay_status,
    ]);
  }

  public function updateDelivery(Request $request) {
    $o_id = $request->o_id;
    $delivery_status = $request->delivery_status;
    $courier = $request->courier;
    $invoice_no = $request->invoice_no;

    $buyer = MarketBuyer::where('o_id', $o_id)->first();
    $buyer->delivery_status = $delivery_status;
    $buyer->courier = $courier;
    $buyer->invoice_no = $invoice_no;
    $buyer->save();
    return response()->json(['error'=>false]);

  }

  public function updatePay(Request $request) {
    $o_id = $request->o_id;
    $pay_status = $request->pay_status;

    $pay = MarketPayment::where('o_id', $o_id)->first();
    $pay->status = $pay_status;
    $pay->save();
    return response()->json(['error'=>false]);
  }
}
