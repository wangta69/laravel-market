<?php
namespace Pondol\Market\Http\Controllers\Admin\Config;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use DB;

use Pondol\Common\Facades\JsonKeyValue;

use App\Http\Controllers\Controller;

class DeliveryController extends Controller
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
    return view('market::admin.config.delivery', [
      'delivery'=>JsonKeyValue::getAsJson('market.delivery')
    ]);
  }

  public function update(Request $request) {
    $config = [
      'fee' => $request->fee,
      'type' => $request->type,
      'min' => $request->min
    ];

    JsonKeyValue::update('market.delivery', $config);
  }
}
