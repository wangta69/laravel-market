<?php
namespace App\Http\Controllers\Market\Mypage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Validator;
use Auth;
use DB;

use App\Http\Controllers\Controller;
use App\Models\Market\MarketOrder;
// use App\Models\Market\MarketBank;
use App\Models\Market\MarketBuyer;
use App\Models\Market\MarketItemReview;
// use App\Http\Controllers\Market\Services\OrderService;

class ReviewController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(
    // OrderService $ordergSvc
  ){
    // $this->orderSvc = $ordergSvc;
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    // 마켙order 접근시 비회원 경우는 o_id가 있어야한다.
    $user = $request->user();

    $items = MarketBuyer::select(
      'o.id', 'o.item_id', 'o.created_at', 'it.name', 'it.image',
      'review.content', 'review.reply', 'review.rating'
    )
    ->where('market_buyers.user_id', $user->id)->where('market_buyers.delivery_status', 20)
    ->join('market_orders as o', function($join){
      $join->on('market_buyers.o_id', '=', 'o.o_id');
    })
    ->join('market_items as it', function($join){
      $join->on('o.item_id', '=', 'it.id');
    })
    ->leftjoin('market_item_reviews as review', function($join){
      $join->on('o.id', '=', 'review.order_id');
    })
    ->orderBy('market_buyers.id', 'desc')->paginate(15)->withQueryString();

    return view('market.templates.userpage.'.config('market.template.userpage.theme').'.review.index', [
      'user' => $user,
      'items' => $items,
    ]);    
  }


  public function store(MarketOrder $order, Request $request) {
    $user = $request->user();
    $parent_id = $request->parent_id;
    $validator = Validator::make($request->all(), [
      'rating' => 'required',
      'content' => 'required|min:2'
    ]);
   
    if ($validator->fails()) {
      if($request->ajax()){
        return response()->json(['error'=>$validator->errors()->first()], 203);//500, 203
      } else {
        return redirect()->back()->withErrors($validator->errors())->withInput($request->except('password'));
      }
    }

    // if(!$item || !$item_id)
    //   abort(404, "Exception Message");


    $comment = new MarketItemReview;
    // $comment->item = $item;
    // $comment->user_id = $user->id;
    $comment->order_id = $order->id;//firt fill then update
    $comment->item_id = $order->item_id;//firt fill then update
    // $comment->writer = $request->get('writer');
    $comment->content = $request->get('content');
    $comment->rating = $request->get('rating')[$order->id];
    //본글에 대한 답변인지 댓글의 댓글인지 구분

    if (Auth::check()) {
      $comment->user_id = Auth::user()->id;
      // $comment->writer = $comment->writer ? $comment->writer : Auth::user()->name;
    } else {
      $comment->user_id = null;
    }

    
   
    $comment->save();



    if($request->ajax()){
      return response()->json(['error'=>false], 200);
    } else {
      return redirect()->back();
    }


  }

}