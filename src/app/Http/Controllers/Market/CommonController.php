<?php

namespace App\Http\Controllers\Market;

use App\Providers\RouteServiceProvider;
use App\Models\Auth\User\User;
// use Illuminate\Foundation\Auth\RegistersUsers;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Auth\Events\Registered;
use DB;
// use App\Models\Auth\Role\Role;
// use App\Models\UserBank;
// use App\Models\Agent;


class CommonController extends Controller
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
  public function setLan(Request $request)
  {
    $lan = $request->input('lan', 'ko');
    if ($lan !== 'ko' && $lan !== 'en' ) {
      $lan = 'ko';
    }

    session(['locale' => $lan]);
    // \App::setLocale($lan);
    return redirect()->back();
  }

  public function setScreenMode(Request $request)
  {
    $screenMode = $request->input('screenMode');
    $minutes = 60*24*360;
    $cookie = \Cookie::queue('screenMode', $screenMode, $minutes);

    return response()->json(['error'=>false, 'screenMode'=>$screenMode, 'cookie'=>$cookie], 200);
  }

  public function setCookie(Request $request)
  {
    $name = $request->input('name');
    $value = $request->input('value');
    $day = $request->input('day', '1');

    $minutes = 60 * 24 * (int)$day;
    $cookie = \Cookie::queue($name, $value, $day);
    return response()->json(['error'=>false, 'cookie'=>$cookie], 200);
  }

  /**
  * check users user_id exist
  * if id exist return true
  */
  // public function idCheck(Request $request) {
  //   $user_id = $request->user_id;
  //   if (!$request->user_id) {
  //     return response()->json(['error' => '검색하실 아이디를 입력해 주세요'], 200);
  //   }

  //   $user = User::where('user_id', $user_id)->first();
  //   if(!$user) {
  //     return response()->json(['error'=>false, 'result'=>false], 200);
  //   } else {
  //       // 관리자 입금에서 이름 찾기
  //     return response()->json(['error'=>false, 'result'=>true, 'id'=>$user->id, 'name'=>$user->name], 200);
  //   }
  // }

  /**
   * 회원가입시 이메일 유효성 및 중복 체크
   */
  public function validationEmail($email) {
    $validator = Validator::make(['email' => $email], [
      // 'user_id' => ['required', 'alpha_num', 'min:5', 'max:20', 'unique:users']
      'email' => ['required', 'email', 'unique:users']

      ], [
        'email.required' =>'이메일을 입력해주세요.',
        'email.email' =>'이메일형식이 잘못되었습니다.',
        'email.unique' =>'사용하려는 이메일이 이미 존재합니다.',
      ]
    );

    if ($validator->fails()) {
      return response()->json(['error'=>$validator->errors()->first()], 203);
    } else {
      return response()->json(['error'=>false], 200);
    }
  }
}
