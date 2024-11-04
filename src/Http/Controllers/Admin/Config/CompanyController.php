<?php
namespace Pondol\Market\Http\Controllers\Admin\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use Pondol\Market\Services\ConfigService;
use Pondol\Market\Models\MarketBank;
// use Pondol\Auth\Models\User\UserConfig;

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
    // $termsOfUse = UserConfig::where('key', 'termsOfUse')->first();
    // $termsOfPersonal = UserConfig::where('key', 'termsOfPersonal')->first();

    return view('market::admin.config.company', [
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
