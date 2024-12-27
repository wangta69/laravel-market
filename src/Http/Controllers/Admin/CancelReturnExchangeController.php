<?php
namespace Pondol\Market\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use File;
use Storage;

use Pondol\Market\Models\MarketExchangeReturn;
use Pondol\Market\Traits\CancelReturnExchange;

use App\Http\Controllers\Controller;

class CancelReturnExchangeController extends Controller
{

  use CancelReturnExchange;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    // $this->middleware('auth');
  }

  public function index(Request $request) {
    // \DB::enableQueryLog();
    $types = $request->types;
    $from_date = $request->from_date;
    $to_date = $request->to_date;

    if (!$types) {
      $types = ['refund', 'exchange'];
      $request->merge(['types' => $types]);
    }

    $items = $this->_index();
    $items =  $items->whereIn('re.type', $types);
    // $items =  $items->whereIn('re.type', ['refund', 'exchange']);
    if ($from_date) {
      if (!$to_date) {
        $to_date = date("Y-m-d");
      }

      $from_date = Carbon::createFromFormat('Y-m-d', $from_date);
      $to_date = Carbon::createFromFormat('Y-m-d', $to_date);
      $items =  $items->whereBetween('re.created_at', [$from_date->startOfDay(), $to_date->endOfDay()]);
    }

    
    $items = $items->orderBy('re.id', 'desc')
    ->paginate(15)->withQueryString();

    foreach($items as $item) {
      $item->displayOptions = extractOptions($item);   
    }

    // print_r(\DB::getQueryLog());

    return view('market::admin.cancel-return-exchange.index', [
      'items'=>$items,
      'refund_status' => __('market::market.refund_status'),
      'exchange_status' => __('market::market.exchange_status')
    ]);
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
    
    ->withTrashed()->where('re.id', $id)->first();

    $item->displayOptions = extractOptions($item);

    
    // echo $item->type;
    switch($item->type) {
      case 'refund':
        $configs = __('market::market.refund_status');
        break;
      case 'exchange':
        $configs = __('market::market.exchange_status');
        break;
    }

    return view('market::admin.cancel-return-exchange.view', [
      'item'=>$item,
      'configs' => $configs,
    ]);
  }

  public function update(MarketExchangeReturn $re, Request $request) {
    $re->status = $request->status;
    $re->save();
    
    return redirect()->route('market.admin.cancel-return-exchanges');
  }
}
