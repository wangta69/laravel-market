<?php
namespace App\Http\Controllers\Market\Traits;

use App\Models\Market\MarketTag;

trait Tag {

  /**
   * 카테고리별 상품 가져오기
   */
  public function store($request) {
    $tag = MarketTag::firstOrCreate(['tag' => $request->tag]);
    return ['error' => false, 'id'=>$tag->id];
  }

}