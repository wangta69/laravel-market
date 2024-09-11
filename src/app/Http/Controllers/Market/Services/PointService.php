<?php
namespace App\Http\Controllers\Market\Services;

use App\Models\Market\MarketPoint;

class PointService
{
  /**
   * 입금및 게임시 처리 (별도의 hold_point를 처리하지 않는다.)
   * @param Object $user
   * @param String $item : admin |
   * \App\Services\PointService::insertPoint($user, $point, 'gameCrypto', 'win', $player->id);
   * \App\Services\PointService::insertPoint($user, $point, 'gameFx', 'win', $player->id);
   * \App\Services\PointService::insertPoint($user, $amount, 'deposit', $symbol, $deposit->id);
   */
  static function insertPoint($user, $point, $item = null, $sub_item = null, $rel_item = null) {
    if(!$sub_item) {$sub_item = $item;}
    
    $cur_sum = $user->curPoint();
    $userPoint = new MarketPoint;
    $userPoint->user_id = $user->id;
    $userPoint->point = $point;
    $userPoint->cur_sum = $cur_sum + $point;
    $userPoint->item = $item;
    $userPoint->sub_item = $sub_item;
    $userPoint->rel_item = $rel_item;

    $userPoint->save();

    $user->increment('point', $point);
  }

  /**
   * 출금 요청시 처리 (hold point를 up시키고 기존 point를 다운 시킨다.)
   * 출금 홀딩시 (hold point를 down시키고 기존 point를 업 시킨다.
   * 출금 완료시 처리 (hold point를 down 시킨다.)
   * \App\Services\PointService::withDrawPoint($user, $point, 'gameCrypto', 'win', $player->id);
   */
  // static function withDrawPoint($user, $point, $item = null, $sub_item = null, $rel_item = null) {
  //     $cur_sum = $user->curPoint();
  //     $userPoint->user_id = $user->id;
  //     $userPoint->point = -$point;
  //     $userPoint->cur_sum = $cur_sum - $point;
  //     $userPoint->item = $item;
  //     $userPoint->sub_item = $sub_item;
  //     $userPoint->rel_item = $rel_item;
  //
  //     $userPoint->save();
  //
  //     $user->decrement('hold_point', $point);
  // }
}
