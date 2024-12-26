<?php
namespace Pondol\Market\Http\Controllers\Admin\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;

use Pondol\Common\Facades\JsonKeyValue;
// use Pondol\Auth\Models\User\UserConfig;

class CompanyController extends Controller
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

    
    $company = JsonKeyValue::getAsJson('company');
    $company->copyright = isset($company->copyright) ? $company->copyright: '';


    return view('market::admin.config.company', compact('company'));
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
      'copyright' => $request->copyright,
    ];

    set_config('pondol-market.company', $params );
    JsonKeyValue::storeAsJson('company', $params);
    return response()->json(['error'=>false]);
  }
   

}
