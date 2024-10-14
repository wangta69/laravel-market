<?php
namespace App\Http\Controllers\Market\Traits;

use App\Models\Market\MarketItemCategory;
use App\Models\Market\MarketItem;


trait Item {

  /**
   * 카테고리별 상품 가져오기
   */
  public function categoryItems($request, $category) {
    return MarketItemCategory::select(
      'market_items.*'
    )->join('market_items', function($join){
      $join->on('market_items.id', '=', 'market_item_categories.item_id');
    })
    ->where('market_item_categories.category', 'like', $category.'%');

  }


  public function searchItems($request) {

    $q = $request->q;
    $cat = $request->cat;
    $minPrice = $request->minPrice;
    $maxPrice = $request->maxPrice;

    // $minPrice = $request->input('minPrice', 0);
    // $maxPrice = $request->input('maxPrice', 10000000000);
    
    $items =  MarketItem::select(
      'market_items.*'
    )
    // ->where('market_items.name', 'like', $q.'%')
    // ->orWhere('market_items.brand', 'like', $q.'%')
    // ->whereFullText(['name', 'model', 'shorten_description', 'description'], $q)
    ->whereFullText(['name', 'model', 'shorten_description', 'description'], $q, ['mode'=>'boolean']) 
    // ->whereFullText(['name', 'model', 'shorten_description', 'description'], $q, ['mode'=>'boolean']) 
    // ->orwhereIn('market_items.id', [1, 2, 3, 4]);
    ->orwhereIn('market_items.id', function($query) use($q){

      $query->select('it.item_id')
      ->from('market_item_tags as it')
      ->join('market_tags as t', function($join){
        $join->on('it.tag_id', '=', 't.id');
      })
      ->where('t.tag', $q);
    });

    if($minPrice || $maxPrice) {
      if($minPrice && $maxPrice) {
        $items->whereRaw('price >= '.$minPrice.' AND price <='.$maxPrice);
      } else if($minPrice) {
        $items->whereRaw('price >= '.$minPrice);
      } else {
        $items->whereRaw('price <='.$maxPrice);
      }
    }

    if($cat) {
      $items = $items->join('market_item_categories as ic', function($join) use($cat){
        $join->on('market_items.id', '=', 'ic.item_id');
        $join->where('ic.category', 'like', $cat.'%');
      }); // 현재 multi category에서는 이 경우 다수의 동일 아이템이 출력되는 문제가 발생할 수 있다.
    }

    return $items;

  }

}