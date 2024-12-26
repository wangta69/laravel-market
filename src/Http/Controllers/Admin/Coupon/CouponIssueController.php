<?php
namespace Pondol\Market\Http\Controllers\Admin\Coupon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Carbon\Carbon;

use Pondol\Auth\Models\User\User;
use Pondol\Market\Models\MarketCoupon;
use Pondol\Market\Models\MarketCouponIssue;

use App\Http\Controllers\Controller;

class CouponIssueController extends Controller
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

    $items = MarketCouponIssue::select(
      'market_coupon_issues.*',
      'market_coupons.title', 'market_coupons.apply_type', 'market_coupons.min_price', 'market_coupons.apply_amount_type', 'market_coupons.price',
      'market_coupons.percentage', 'market_coupons.percentage_max_price',
      'users.name', 'users.email'
    )
    ->join('market_coupons', function($join){
      $join->on('market_coupons.id', '=', 'market_coupon_issues.coupon_id');
    })
    ->join('users', function($join){
      $join->on('users.id', '=', 'market_coupon_issues.user_id');
    })->orderBy('market_coupon_issues.id', 'desc')->paginate(15)->withQueryString();
    return view('market::admin.coupon.issues', compact('items'));
  }

  public function create(MarketCoupon $coupon, Request $request) {
  
    return view('market::admin.coupon.issue', compact('coupon'));
  }

  public function store($coupon, Request $request) {
    $to = $request->to;
    $recv_users = $request->recv_users;
    $expired_at = Carbon::createFromFormat('Y-m-d', $request->expired_at)->endOfDay();

    switch($to) {
      case 'all':
        $users = User::select('id')->get()->pluck('id')->toArray();
        break;
      case 'individual':
        $users = explode(',', $recv_users);
        break;
    }

    foreach($users as $user) {
      $issue = new MarketCouponIssue;
      $issue->user_id = $user;
      $issue->coupon_id = $coupon;
      $issue->expired_at = $expired_at;
      $issue->save();

    }
    return redirect()->route('market.admin.coupon.issues');

  }


}
