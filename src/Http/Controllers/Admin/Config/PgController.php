<?php
namespace Pondol\Market\Http\Controllers\Admin\Config;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use DB;

use Pondol\Common\Facades\JsonKeyValue;

use App\Http\Controllers\Controller;
class PgController extends Controller
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
    $payment = JsonKeyValue::getAsJson('payment');
    $pgs = ['inicis'=>'Inicis', 'kcp'=>'KCP', 'lg'=>'LG'];
    $simples = ['naver'=>'네이버 페이', 'kakao'=>'카카오 페이']; // simplePayments
    return view('market::admin.config.pg', compact(
      'payment', 'pgs', 'simples'
    ));
  }


  public function update(Request $request) {
    $params = [
      'pg' => $request->pg,
      'mid' => $request->mid,
      'sitekey' => $request->sitekey,
      'submit_url' => $request->submit_url,
      'service' => $request->service == 'prod' ? true : false,
      'naver' => $request->naver ? true : false,
      'kakao' => $request->kakao ? true : false,
    ];

    JsonKeyValue::update('payment', $params);
    return response()->json(['error'=>false]);
  }
}
