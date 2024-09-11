<?php
namespace App\Http\Controllers\Market\Admin\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Market\Services\ConfigService;
use App\Models\Market\MarketBank;
use App\Models\Market\MarketConfig;

class UserController extends Controller
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

    $user = $this->configSvc->get('user');
    $termsOfUse = MarketConfig::where('key', 'termsOfUse')->first();
    $termsOfPersonal = MarketConfig::where('key', 'termsOfPersonal')->first();

    return view('market.admin.config.user', [
      'user'=>$user,
      'termsOfUse' => $termsOfUse->value,
      'termsOfPersonal' => $termsOfPersonal->value,
    ]);
  }

  public function update(Request $request) {
    print_r($request->all());
    MarketConfig::where('key', 'termsOfUse')->update(['value'=>$request->termsOfUse]);
    MarketConfig::where('key', 'termsOfPersonal')->update(['value'=>$request->termsOfPersonal]);
    $params = [
      'active' => $request->active,
    ];

    $this->configSvc->set('user', $params );
    return response()->json(['error'=>false]);
  }
   

}
