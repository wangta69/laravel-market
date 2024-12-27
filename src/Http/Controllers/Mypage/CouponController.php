<?php
namespace Pondol\Market\Http\Controllers\Mypage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Carbon\Carbon;

use Pondol\Auth\Models\User\User;
use Pondol\Market\Models\MarketCoupon;
use Pondol\Market\Models\MarketCouponIssue;

use App\Http\Controllers\Controller;

class CouponController extends Controller
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
  public function index(Request $request)
  {

    $user = $request->user();

    $items = MarketCouponIssue::select(
      'market_coupon_issues.*',
      'market_coupons.title', 'market_coupons.apply_type', 'market_coupons.min_price', 'market_coupons.apply_amount_type', 'market_coupons.price',
      'market_coupons.percentage', 'market_coupons.percentage_max_price'
    )
    ->join('market_coupons', function($join){
      $join->on('market_coupons.id', '=', 'market_coupon_issues.coupon_id');
    })->where('market_coupon_issues.user_id', $user->id)->orderBy('market_coupon_issues.id', 'desc')->paginate(15)->withQueryString();
    
    foreach($items as $item) {
      $item->enable = true;
      if($item->used_at) {
        $item->enable = false;
      } else if($item->expired_at < Carbon::now()) {
        $item->enable = false;
      }
    }

    // print_r($items);
    return view(market_theme('userpage').'.coupons', [
      'items' => $items,
    ]);
  }






}
