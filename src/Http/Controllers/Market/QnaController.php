<?php
namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
// use App\Models\Market\MarketCategory;
use App\Models\Market\MarketItem;
use App\Models\Market\MarketItemQna;




class QnaController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(

  ){

  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, MarketItem $item)
  {

    $user = $request->user();
    $parent_id = $request->get('parent_id');//if this vaule setted it means reply
    // $item->
    $article = new MarketItemQna;
    $article->user_id = $user->id;
    $article->item_id = $item->id;
    // $article->order_num = $this->get_order_num();
    $article->title = $request->get('title');
    $article->content = $request->get('content');
    $article->secret = $request->get('secret', 0);
    $article->save();

    // $article->parent_id = $parent_id ? $parent_id : $article->id;
    // $article->save();

    return response()->json([
      'error' => false,
      'next'=>route('market.mypage.qnas')
    ]);


  }

  // protected function get_order_num($params=null){
  //   $order_num = MarketItemQna::min('order_num');
  //   return $order_num ? $order_num-1:-1;
  // }

}