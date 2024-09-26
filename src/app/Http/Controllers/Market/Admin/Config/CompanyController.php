<?php
namespace App\Http\Controllers\Market\Admin\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Market\Services\ConfigService;
use App\Models\Market\MarketBank;
use App\Models\Market\MarketConfig;

class CompanyController extends Controller
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

    $company = $this->configSvc->get('company');
    $termsOfUse = MarketConfig::where('key', 'termsOfUse')->first();
    $termsOfPersonal = MarketConfig::where('key', 'termsOfPersonal')->first();

    return view('market.admin.config.company', [
      'company'=>$company
    ]);
  }

  public function update(Request $request) {

    $params = [
      'name' => $request->name,
      'businessNumber' => $request->businessNumber,
      'mailOrderSalesRegistrationNumber' => $request->mailOrderSalesRegistrationNumber,
      'address' => $request->address,
      'representative' => $request->representative,
      'tel1' => $request->tel1,
      'fax1' => $request->fax1,
    ];

    $this->configSvc->set('company', $params );
    return response()->json(['error'=>false]);
  }
   

}
