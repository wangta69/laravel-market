<?php
namespace Pondol\Market\Http\Controllers\Admin\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;


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
    // config()->set('app.name','My Project App');
    // $cat1 = $this->subCategory('');
    // \Artisan::call('config:clear'); // 만약 production mode이고 config를 cache 하여 사용하면
    $cfg = config('pondol-market');

    return view('market::admin.config.delivery', [
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
    set_config('pondol-market.delivery', $config );


  }

   

}
