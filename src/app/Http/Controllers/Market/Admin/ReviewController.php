<?php
namespace App\Http\Controllers\Market\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;

use App\Models\Market\MarketItemReview;


class ReviewController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
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


    $items = MarketItemReview::select(
      'market_item_reviews.id', 'market_item_reviews.item_id', 'market_item_reviews.user_id', 'market_item_reviews.rating','market_item_reviews.content', 'market_item_reviews.reply', 'market_item_reviews.created_at',
      'it.name', 'it.image',
      'u.name as user_name'
    )->join('market_items as it', function($join){
      $join->on('market_item_reviews.item_id', '=', 'it.id');
    })->join('users as u', function($join){
      $join->on('market_item_reviews.user_id', '=', 'u.id');
    })
    ->orderBy('market_item_reviews.id', 'desc')->paginate(15)->withQueryString();

    return view('market.admin.review.index', [
      'items'=>$items
    ]);
  }

  public function update(MarketItemReview $review, Request $request) {
    $review->reply = $request->reply;
    $review->save();
    return response()->json(['error'=>false]);
  }
}
