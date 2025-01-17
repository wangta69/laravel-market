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

    $main = ['rec'=>[], 'new'=>[], 'hit'=>[]];
    foreach($items as $v) {
      $main[$v->display][] = $v;
    }

    return view(market_theme('main').'.index', [
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