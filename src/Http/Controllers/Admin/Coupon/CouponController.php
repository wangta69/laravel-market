<?php
namespace Pondol\Market\Http\Controllers\Admin\Coupon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use Pondol\Auth\Models\User\User;
use Pondol\Market\Services\OrderService;

use Pondol\Market\Models\MarketCoupon;

// use App\Models\Deposits;
// use App\Models\Purchase;
// use App\Models\Sale;

class CouponController extends Controller
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

    $items = MarketCoupon::orderBy('id', 'desc')->paginate(15)->withQueryString();
    return view('market::admin.coupon.index', compact('items'));
  }

  public function create(Request $request) {
    $item = new MarketCoupon;
    return view('market::admin.coupon.create', compact('item'));
  }

  public function store(Request $request) {
    print_r($request->all);
    $coupon = new MarketCoupon;

    $coupon->title = $request->title;
    $coupon->apply_type = $request->apply_type;
    $coupon->item_id = $request->item_id;
    $coupon->category = $request->category;
    $coupon->min_price = str_replace(',', '', $request->min_price);
    $coupon->apply_amount_type = $request->apply_amount_type;
    $coupon->price = $request->price ? str_replace(',', '', $request->price): null;
    $coupon->percentage = $request->percentage;
    $coupon->percentage_max_price = $request->percentage_max_price ? str_replace(',', '', $request->percentage_max_price): null;
    $coupon->save();

    return redirect()->route('market.admin.coupons');

  }


}
