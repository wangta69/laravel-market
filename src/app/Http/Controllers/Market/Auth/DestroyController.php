<?php

namespace App\Http\Controllers\Market\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Notifications\CountChanged;
use App\Http\Controllers\Controller;

class DestroyController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles authenticating users for the application and
  | redirecting them to your home screen. The controller uses a trait
  | to conveniently provide its functionality to your applications.
  |
  */



  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {

  }


  public function delete(Request $request){
    return view('market.templates.auth.'.config('market.template.auth.theme').'.cancel-account');
  }

  /**
  * Delete
  * @deprecated
  * 삭제하기 (<-- 직접 탈퇴가 아니라 관리자가 한번 더 confirm 을 받는 단계 진행)
  */
  public function destroy(Request $request){
    $password = $request->password;
    $user = $request->user();

    if (!\Hash::check($password, $user->password)) {
      return redirect()->back()->with('error', '비밀번호가 일치하지 않습니다.');
    }

    $user->email =  $user->email.'@'.date('YmdHis');
    $user->active =  9;
    $user->save();

    $user->delete();

    auth()->logout();  //logout
    // Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('market.cancel.account.success');

  }

  public function success() {
    return view('market.templates.auth.'.config('market.template.auth.theme').'.cancel-account-success');
  }

}
