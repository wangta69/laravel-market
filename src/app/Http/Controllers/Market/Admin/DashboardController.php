<?php
namespace App\Http\Controllers\Market\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use App\Models\Auth\User\User;
use App\Http\Controllers\Market\Services\OrderService;

use App\Models\Market\MarketItemQna;
use App\Models\Market\MarketItemReview;
// use App\Models\Deposits;
// use App\Models\Purchase;
// use App\Models\Sale;

class DashboardController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(OrderService $orderSvc)
  {
    $this->orderSvc = $orderSvc;
      // $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    //  최근 리뷰 
    $reviews = MarketItemReview::select(
      'market_item_reviews.id', 'market_item_reviews.item_id', 'market_item_reviews.user_id', 'market_item_reviews.rating','market_item_reviews.content', 'market_item_reviews.reply', 'market_item_reviews.created_at',
      'it.name', 'it.image',
      'u.name as user_name'
    )->join('market_items as it', function($join){
      $join->on('market_item_reviews.item_id', '=', 'it.id');
    })->join('users as u', function($join){
      $join->on('market_item_reviews.user_id', '=', 'u.id');
    })
    ->orderBy('market_item_reviews.id', 'desc')->skip(0)->take(5)->get();
    // 최근 상품문의
    $qnas = MarketItemQna::select(
      'market_item_qnas.id', 'market_item_qnas.item_id', 'market_item_qnas.user_id', 'market_item_qnas.title', 'market_item_qnas.content', 'market_item_qnas.reply', 'market_item_qnas.created_at',
      'it.name', 'it.image',
      'u.name as user_name'
    )->join('market_items as it', function($join){
      $join->on('market_item_qnas.item_id', '=', 'it.id');
    })->join('users as u', function($join){
      $join->on('market_item_qnas.user_id', '=', 'u.id');
    })
    ->orderBy('market_item_qnas.id', 'desc')->skip(0)->take(5)->get();


    // 최근 가입한 회원
    $users = config('auth.providers.users.model')::orderBy('created_at', 'desc')->skip(0)->take(5)->get();
    // 최근 주문 내역
    $orders = $this->orderSvc->orderList('admin')->orderBy('market_orders.id', 'desc')->skip(0)->take(5)->get();

    return view('market.admin.dashboard', [
      'users'=>$users,
      'orders'=>$orders,
      'reviews'=>$reviews,
      'qnas'=>$qnas
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
