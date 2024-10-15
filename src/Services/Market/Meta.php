<?php
namespace App\Services\Market;

use App\Models\Market\MarketItemTag;
class Meta
{
  public $title = '';
  public $keywords = '';
  public $description = '';
  public $og_type = 'website';
  public $og_image = null;
  // public $og_sitename = '온스토리';
  public $updated_at = '';
  public $created_at = '';
  // public $mytemp = 'aa';

  public function __construct(
  ){
    $this->og_image = new \stdClass;
  }


  public function setItem($item) {
    $this->title = $item->name;
    $this->keywords = $this->itemKeywords($item->id);

    $this->description = $item->shorten_description;
    $this->updated_at = isset($item->updated_at) ? $item->updated_at : null;
    $this->created_at = isset($item->created_at) ? $item->created_at : null;

    $this->og_image->name = getImageUrl($item->image);
    // $this->og_image->alt = $item->name;
    // $this->og_image->type = 'jpeg';
  }

  private function itemKeywords($id) {
    $tags = MarketItemTag::select(
      't.tag'
    )->join('market_tags as t', function($join){
      $join->on('market_item_tags.tag_id', '=', 't.id');
    })->where('market_item_tags.item_id', $id)->pluck('tag')->toArray();
    // ->implode(', '); // 


    return implode(', ', $tags);
  }



}