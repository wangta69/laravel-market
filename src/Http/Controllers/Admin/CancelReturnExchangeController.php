<?php
namespace Pondol\Market\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;

use File;
use Storage;

use Pondol\Market\Models\MarketExchangeReturn;


class CancelReturnExchangeController extends Controller
{
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
      
      ->whereNull("re.deleted_at")
      ->orderBy('re.id', 'desc')->paginate(15)->withQueryString();


    foreach($items as $item) {
      $item->displayOptions = extractOptions($item);   
    }

    return view('market::admin.cancel-return-exchange.index', [
      'items'=>$items,
      'return_status' => config('pondol-market.return_status'),
      'exchange_status' => config('pondol-market.exchange_status')
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

    

    switch($item->type) {
      case 'return':
        $configs = config('pondol-market.return_status');
        break;
      case 'exchange':
        $configs = config('pondol-market.exchange_status');
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
