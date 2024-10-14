<?php
namespace App\Http\Controllers\Market\Admin\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Market\Services\ConfigService;


class DeliveryController extends Controller
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
    // \Artisan::call('config:clear'); // 만약 production mode이고 config를 cache 하여 사용하면
    $cfg = $this->configSvc->get();

    return view('market.admin.config.delivery', [
      'cfg'=>$cfg
    ]);
  }

  public function update(Request $request) {
    $config = [
      'fee' => $request->fee,
      'type' => $request->type,
      'min' => $request->min
    ];
    // [TACKBAE_MONEY] => 1000 
    $this->configSvc->set('delivery', $config );


  }

   

}
