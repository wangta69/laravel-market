<?php
namespace Pondol\Market\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;

use Pondol\Market\Models\MarketItemQna;

class QnaController extends Controller
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
    // DB::enableQueryLog();


    $items = MarketItemQna::select(
      'market_item_qnas.id', 'market_item_qnas.item_id', 'market_item_qnas.user_id', 'market_item_qnas.title', 'market_item_qnas.content', 'market_item_qnas.reply', 'market_item_qnas.created_at',
      'it.name', 'it.image',
      'u.name as user_name'
    )->join('market_items as it', function($join){
      $join->on('market_item_qnas.item_id', '=', 'it.id');
    })->join('users as u', function($join){
      $join->on('market_item_qnas.user_id', '=', 'u.id');
    })
    ->orderBy('market_item_qnas.id', 'desc')->paginate(15)->withQueryString();

    return view('market::admin.qna.index', [
      'items'=>$items
    ]);
  }

  public function update(MarketItemQna $qna, Request $request) {
    $qna->reply = $request->reply;
    $qna->save();
    return response()->json(['error'=>false]);
  }
}
