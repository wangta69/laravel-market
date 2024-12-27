<?php
namespace Pondol\Market\Http\Controllers\Admin\Config;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use DB;

use Pondol\Common\Facades\JsonKeyValue;

use App\Http\Controllers\Controller;

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

    $sms = JsonKeyValue::getAsArray('sms');
    $vendors = ['smsto'=>'SMS.TO', 'directsend'=>'DIRECTSEND'];

  
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

    JsonKeyValue::update('market.delivery', $params);
    return response()->json(['error'=>false]);
  }
   

}
