<?php
namespace App\Http\Controllers\Market\Admin\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use App\Services\Market\ConfigService;
use App\Models\Market\MarketBank;

class PgController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(
    ConfigService $configSvc
  )
  {
      // $this->middleware('auth');
    $this->configSvc = $configSvc;
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // config()->set('app.name','My Project App');
    // $cat1 = $this->subCategory('');
   
    // $banks = MarketBank::paginate(20)->appends(request()->query());
    // $codes = $this->configSvc->get('banks');
    $payment = $this->configSvc->get('payment');
    $pgs = ['inicis'=>'Inicis', 'kcp'=>'KCP', 'lg'=>'LG'];
    $simples = ['naver'=>'네이버 페이', 'kakao'=>'카카오 페이']; // simplePayments
    return view('market.admin.config.pg', [
      'payment' => $payment,
      'pgs'=>$pgs,
      'simples' => $simples
    ]);
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
    Log::info($params);
    $this->configSvc->set('payment', $params );
    return response()->json(['error'=>false]);
  }

  // public function destroy(MarketBank $bank, Request $request) {
  //   $bank->delete();
  //   return response()->json([
  //     'error' => false
  //   ]);
  //   // return redirect()->route('market.admin.config.banks');
  // }

   

}
