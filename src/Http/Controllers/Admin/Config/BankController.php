<?php
namespace Pondol\Market\Http\Controllers\Admin\Config;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use Pondol\Market\Services\ConfigService;
use Pondol\Market\Models\MarketBank;

class BankController extends Controller
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
   
    $banks = MarketBank::where('type', 'manager')->paginate(20)->appends(request()->query());
    $codes = $this->configSvc->get('banks');
    return view('market::admin.config.bank', [
      'banks'=>$banks,
      'codes' => $codes
    ]);
  }

  public function create() {


    // [TACKBAE_MONEY] => 1000 
    $codes = $this->configSvc->get('banks');
    return view('market::admin.config.bank-create', [
      'codes' => $codes
    ]);

  }

  public function store(Request $request) {
    $user = $request->user();
    $bank = new MarketBank;
    $bank->user_id = $user->id;
    $bank->type = 'manager';
    $bank->code = $request->code;
    $bank->no = $request->no;
    $bank->owner = $request->owner;
    $bank->save();
    return redirect()->route('market.admin.config.banks');
  }

  public function destroy(MarketBank $bank, Request $request) {
    $bank->delete();
    return response()->json([
      'error' => false
    ]);
    // return redirect()->route('market.admin.config.banks');
  }

   

}
