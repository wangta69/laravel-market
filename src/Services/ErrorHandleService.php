<?php
namespace Pondol\Market\Services;

class ErrorHandleService
{
  /**
   * 기존 스토리지 경로를 public 경로로 변경
   */
  // public function redirectBack($request, $validator) {
  //   if($request->ajax()){
  //     return response()->json(['error'=>$validator->errors()->first()], 203);
  //   } else {
  //     return redirect()->back()->withErrors($validator->errors());
  //   }
  // }

  // public function redirectBackWithInput($request, $validator, $except) {
  //   if($request->ajax()){
  //     return response()->json(['error'=>$validator->errors()->first()], 203);
  //   } else {
  //     $except = $except ? $request->except($except): null;
  //     return redirect()->back()->withErrors($validator->errors())->withInput($except);
  //   }
  // }

  // public function redirectBackWithInput($request, $message, $except) {
  //   if($request->ajax()){
  //     return response()->json(['error'=>$validator->errors()->first()], 203);
  //   } else {
  //     $except = $except ? $request->except($except): null;
  //     return redirect()->back()->withErrors($validator->errors())->withInput($except);
  //   }
  // }


  // /**
  //  * 전화번호에 하이펀 추가
  //  */
  // static function addHypenToMobile($tel) {
  //   if ($tel) {
  //     $tel = preg_replace("/[^0-9]*/s", "", $tel); // 숫자이외 제거

  //     if (substr($tel, 0, 2) == '02' ) {
  //       return preg_replace("/([0-9]{2})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", $tel);
  //     } else if(substr($tel, 0, 2) == '8' && substr($tel, 0, 2) == '15' || substr($tel, 0, 2) =='16' || substr($tel, 0, 2) == '18') {
  //       return preg_replace("/([0-9]{4})([0-9]{4})$/","\\1-\\2", $tel);
  //     } else {
  //       return preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", $tel);
  //       //핸드폰번호만 이용한다면 이것만 있어도 됨
  //     }
  //   } else {
  //     return $tel;
  //   }
  // }

  
}
