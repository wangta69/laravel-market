<?php
namespace Pondol\Market\Http\Controllers\Mypage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use Validator;
use DB;

use App\Http\Controllers\Controller;

use Pondol\Market\Models\MarketAddress;
use Pondol\Market\Services\OrderService;

class AddressController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(
    // OrderService $ordergSvc
    // ErrorHandleService $errorHandle
  ){
    // $this->orderSvc = $ordergSvc;
    // // $this->errorHandle = $errorHandle;
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
    $addresses = MarketAddress::where('user_id', $user->id)->orderBy('default', 'desc')->orderBy('updated_at', 'desc')->get();
    return view('market.templates.userpage.'.config('pondol-market.template.userpage.theme').'.address.index', [
      'addresses' => $addresses,
    ]);
  }

  public function store(Request $request) {
    

    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'zip' => 'required',
      'addr1' => 'required',
      'addr2' => 'required',
      'tel1' => 'required',
    ], [
      'name.required' =>'이름을 입력하세요',
      'zip.required' =>'우편번호를 입력하세요',
      'addr1.required' =>'주소를 입력하세요',
      'addr2.required' =>'상세주소를 입력하세요',
      'tel1.required' =>'연락처를 입력하세요',
    ]);

    if ($validator->fails()) {
      if($request->ajax()){
        return response()->json(['error'=>$validator->errors()->first()], 203);//500, 203
      } else {
        return redirect()->back()->withErrors($validator->errors())->withInput();
      }
    }

    $user = $request->user();

    $name = $request->name;
    $zip = $request->zip;
    $addr1 = $request->addr1;
    $addr2 = $request->addr2;
    $tel1 = str_replace('-', '', $request->tel1);

    
    // 기존에 default 주소가 있는지 확인
    $hasDefault = MarketAddress::where('user_id', $user->id)->where('default', 1)->count();

    $address = new MarketAddress;
    $address->user_id = $user->id;
    $address->name = $name;
    $address->zip = $zip;
    $address->addr1 = $addr1;
    $address->addr2 = $addr2;
    $address->tel1 = $tel1;
    $address->default = $hasDefault ? 0 : 1;
    $address->save();
    
    if($request->ajax()){
      return response()->json(['error'=>false], 200);//500, 203
    } else {
      return redirect()->back();
    }

  }

  public function updateDefault(MarketAddress $address, Request $request) {
    $user = $request->user();
    if($address->user_id === $user->id ) {
      // 기존 default를 0으로 처리
      MarketAddress::where('user_id', $user->id)->update(['default'=>0]);
      $address->default = 1;
      $address->save();
      return response()->json(['error'=>false], 200);//500, 203
    } else {
      return response()->json(['error'=>'잘못된 접근입니다.'], 200);//500, 203
    }
  }

  public function destroy(MarketAddress $address, Request $request) {
    $user = $request->user();
    if($address->user_id === $user->id ) {
      $address->delete();
      return response()->json(['error'=>false], 200);//500, 203
    } else {
      return response()->json(['error'=>'잘못된 접근입니다.'], 200);//500, 203
    }
  }

  

}