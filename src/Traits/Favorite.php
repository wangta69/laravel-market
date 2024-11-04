<?php
namespace Pondol\Market\Traits;

use Pondol\Market\Models\MarketItemFavorite;

trait Favorite {

  public function index($request, $user = null) {
    $items = MarketItemFavorite::select(
      'market_item_favorites.id as fav_id',
      'it.id', 'it.name', 'it.model', 'it.price', 'it.cost', 'it.image'
    )
    ->join('market_items as it', function($join){
      $join->on('market_item_favorites.item_id', '=', 'it.id');
    });

    if($user) {
      $items =  $items->where('market_item_favorites.user_id', $user->id);
    }

    return $items;
  }

  public function store($request, $item_id)
  {

    $user = $request->user();
    $fav = new MarketItemFavorite;
    $fav->user_id = $user->id;
    $fav->item_id = $item_id;
    $fav->save();

    return ['error'=> false, 'id'=>$fav->id];
  }

  public function destroy($request, $id)
  {

    $user = $request->user();
    $fav = MarketItemFavorite::find($id);
    
    if(!$fav) {
      return ['error'=> '이미 삭제 되었습니다.'];
    }
    if($user->id != $fav->user_id) {
      return ['error'=> '권한이 없습니다.'];
    }
    $fav->delete();
    return ['error'=> false, 'id'=>$fav->id];
  }


}