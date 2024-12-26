<?php
namespace Pondol\Market\Http\Controllers\Admin\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use Pondol\Market\Models\MarketBank;

class SmsController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(
  )
  {
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    $sms = config('pondol-market.sms');
    $vendors = ['smsto'=>'SMS.TO', 'directsend'=>'DIRECTSEND'];

    $sms = isset($sms) ? $sms : [];
    
    $sms = array_merge(['vendor'=>null, 'key'=>null, 'id'=>null, 'sender'=>null, 'manager_rec_order'=>false], $sms);
    
    return view('market::admin.config.sms', [
      'sms'=>$sms,
      'vendors' => $vendors
    ]);
  }

  public function update(Request $request) {
    $params = [
      'vendor' => $request->vendor,
      'key' => $request->key,
      'id' => $request->id,
      'sender' => $request->sender,
      'manager_rec_order' => $request->manager_rec_order ? true : false
    ];
    Log::info($params);
    set_config('pondol-market.sms', $params );
    return response()->json(['error'=>false]);
  }
   

}
