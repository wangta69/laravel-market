<?php
namespace App\Http\Controllers\Market\Mypage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use Validator;
use DB;

use App\Http\Controllers\Controller;
// use App\Http\Controllers\Market\Services\ErrorHandleService;

use App\Models\Market\MarketAddress;
// use App\Models\Market\MarketBank;
// use App\Models\Market\MarketDeliveryCompany;
use App\Http\Controllers\Market\Services\OrderService;

class UserController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(
    OrderService $ordergSvc
    // ErrorHandleService $errorHandle
  ){
    $this->orderSvc = $ordergSvc;
    // $this->errorHandle = $errorHandle;
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


    // DB::enableQueryLog();

    // 현재 선택한 상품을 리스트업 한다.
    // $items = $this->orderSvc->orderList($user->id)->orderBy('market_orders.id', 'desc')->paginate(15)->withQueryString();
    // default를 먼저 가져오고 최근 사용한 순으로 가져온다.
    return view('market.templates.userpage.'.config('market.template.userpage.theme').'.user', [
      'user' => $user
    ]);
  }

  public function edit(Request $request) {
    $user = $request->user();
    return view('market.templates.'.config('market.template.theme').'.auth.edit', [
      'user' => $user,
    ]);
  }

  /**
   * 이메일 변경
   */
  public function updateEmail(Request $request) {
    $user = $request->user();

    $validator = Validator::make($request->all(), [
      'email' => 'required|unique:users,email,'.$user->id,
      'password' => 'required|current_password:web'
    ]);
   
    if ($validator->fails()) {
      if($request->ajax()){
        return response()->json(['error'=>$validator->errors()->first()], 203);//500, 203
      } else {
        return redirect()->back()->withErrors($validator->errors())->withInput($request->except('password'));
      }
    }

    $user->email = $request->email;
    $user->save();
    if($request->ajax()){
      return response()->json(['error'=>false], 200);//500, 203
    } else {
      return redirect()->back();
    }
  }

  /**
   * 패스워드 변경
   */
  public function updatePassword(Request $request) {
    $user = $request->user();

    $validator = Validator::make($request->all(), [
      'password' => 'required|min:8|confirmed',
      'current_password' => 'required|current_password:web'
      // 'password' => 'current_password:web'
    ]);

    if ($validator->fails()) {
      if($request->ajax()){
        return response()->json(['error'=>$validator->errors()->first()], 203);//500, 203
      } else {
        return redirect()->back()->withErrors($validator->errors())->withInput($request->except('password'));
      }
    }
    $user->password = Hash::make($request->password);
    $user->save();

    if($request->ajax()){
      return response()->json(['error'=>false], 200);//500, 203
    } else {
      return redirect()->back();
    }
  }

  /**
   * 패스워드 변경
   */
  public function updateMobile(Request $request) {
    $user = $request->user();

    $validator = Validator::make($request->all(), [
      'mobile' => 'sometimes|min:8',
      'mobile_1' => 'sometimes|min:2',
      'mobile_2' => 'sometimes|min:3',
      'mobile_3' => 'sometimes|min:4',
    ]);

    if ($validator->fails()) {
      if($request->ajax()){
        return response()->json(['error'=>$validator->errors()->first()], 203);//500, 203
      } else {
        return redirect()->back()->withErrors($validator->errors())->withInput();
      }
    }
    $user->mobile = str_replace('-', '', $request->mobile);
    $user->save();

    if($request->ajax()){
      return response()->json(['error'=>false], 200);//500, 203
    } else {
      return redirect()->back();
    }
  }
  

}