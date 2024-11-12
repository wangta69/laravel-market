<?php
namespace Pondol\Market\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use Pondol\Market\Models\MarketItemDisplay;

class MainController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      // $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {


        // print_r(Request::server('HTTP_REFERER')); 
       // $visitorInformation['referer'] = Request::server('HTTP_REFERER');
    // $visitorInformation['referer'] = url()->previous();

    // $referer = Request::server('HTTP_REFERER');

    // $visitorInformation['referer'] = Request::server('HTTP_REFERER');
    // $visitorInformation['referer'] = url()->previous();
    // $visitorInformation['referer'] = request()->headers->get('referer');

    // print_r(url()->previous());
    // print_r($request->header('HTTP_REFERRER'));
    // print_r(isset($_SERVER['HTTP_REFERER']) ?$_SERVER['HTTP_REFERER']: '' );
    // print_r($request->header('HTTP_REFERRER'));
    // $referer = $_SERVER['HTTP_REFERER'];

    // print_r( $_SERVER);
    // print_r($referer);
    // $referer = Request::server('HTTP_REFERER');

    
    $items = MarketItemDisplay::select(
      'market_item_displays.name as display',
      'it.id', 'it.name', 'it.model', 'it.price', 'it.image',
    )
    ->whereIn('item_id', function($query) {
      $query->select('item_id')
        ->from('market_item_displays')
        ->where('name', 'main');
    })
    ->leftjoin('market_items as it', function($join){
      $join->on('it.id', '=', 'market_item_displays.item_id');
    })
    ->where('market_item_displays.name', '!=', 'main')
    ->orderBy('id', 'desc')
    ->get();
    // print_r($items);

    $main = ['rec'=>[], 'new'=>[], 'hit'=>[]];
    foreach($items as $v) {
      $main[$v->display][] = $v;
    }

    return view('market.templates.main.'.config('pondol-market.template.main.theme').'.index', [
      'main' => $main
    ]);
  }

  /**
  * 상단 top 클릭시 qna 리스트 페이지로 이동하기
  */
  // public function goto($bbs) {
  //     $bbsparams = BbsService::create_params(array('blade_extends' =>'bbs.admin.default-layout'));
  //     return redirect('/bbs/'.$bbs.'?urlParams='.$bbsparams->enc);
  // }
}