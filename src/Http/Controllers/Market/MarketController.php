<?php
namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
// use App\Models\Market\MarketCategory;
use App\Models\Market\MarketItem;
use App\Models\Market\MarketItemReview;
use App\Models\Market\MarketItemQna;
use App\Models\Market\MarketItemFavorite;
use App\Models\Market\MarketCategory;

use App\Http\Controllers\Market\Traits\Item;
use App\Http\Controllers\Market\Services\Meta;

class MarketController extends Controller
{

  use Item;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(Meta $meta)
  {
    $this->meta = $meta;
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function category($category, Request $request)
  {

    $items = $this->categoryItems($request, $category)
      ->orderBy('market_items.id', 'desc')
      ->paginate(config('market.template.shop.lists'))->withQueryString();

    
    // 현재 카테고리를 저장해 둔다.
    $request->session()->put('category', $category);

    $categoryObj = $this->buildCategory($category);

    $keywords = [];
    $this->meta->title = $categoryObj->path[0]->name;
    array_push($keywords,  $categoryObj->path[0]->name);
    
    if(isset($categoryObj->path[1])) {
      $this->meta->title = $categoryObj->path[1]->name;
      array_push($keywords,  $categoryObj->path[1]->name);
    } 

    if(isset($categoryObj->path[2])) {
      $this->meta->title = $categoryObj->path[2]->name;
      array_push($keywords,  $categoryObj->path[2]->name);
    }

    if(isset($categoryObj->sub_category)) {
      foreach($categoryObj->sub_category as $v) {
        array_push($keywords,  $v->name);
      }
    }

    $this->meta->keywords = implode(',', $keywords);

    return view('market.templates.shop.'.config('market.template.shop.theme').'.category', [
      'category' => $category,
      'items' => $items,
      'categoryObj' => $categoryObj,
      'meta' => $this->meta,
    ]);
  }

  public function view(MarketItem $item, Request $request)
  {

    $user = $request->user();

    $images = $item->images()->select('image')->get();
    $options = $this->creteOptionForm($item);
    // $reviews = $item->reviews;

    // 현재 카테고리를 가져온다. 
    // $category = $request->session()->get('category');
   
    $request->session()->forget('category');
    // echo "11".PHP_EOL;
    // print_r($item->category->category);
    // echo "22".PHP_EOL;
    // 만약 존재 하지 않으면 대표 카테고리를 가져온다.
    // if(!$category) {
    //   $category = $item->category;
    // }

    $categoryObj = $this->buildCategory($item->category);

    // review 가져오기
    $reviews = MarketItemReview::select(
      'market_item_reviews.rating', 'market_item_reviews.content',
      'u.name as user_name'
    )
    ->join('users as u', function($join){
      $join->on('u.id', '=', 'market_item_reviews.user_id');
    })
    ->where('market_item_reviews.item_id', $item->id)
    ->get();


    // qna 가져오기
    $qnas = MarketItemQna::select(
      'market_item_qnas.id', 'market_item_qnas.title', 'market_item_qnas.user_id', 'market_item_qnas.content', 'market_item_qnas.reply', 'market_item_qnas.secret','market_item_qnas.created_at',
      'u.name as user_name'
    )
    ->join('users as u', function($join){
      $join->on('u.id', '=', 'market_item_qnas.user_id');
    })
    ->where('market_item_qnas.item_id', $item->id)
    ->orderBy('market_item_qnas.id', 'desc')
    ->get();

    // favorite 가져오기
    $favorite = null;
    if($user) {
      $favoritetmp = MarketItemFavorite::where('item_id', $item->id)->where('user_id', $user->id)->first();
      if($favoritetmp) {
        $favorite = $favoritetmp->id;
      }
    }

    $this->meta->setItem($item);
    // print_r($reviews);

    return view('market.templates.shop.'.config('market.template.shop.theme').'.view', [
      'meta' => $this->meta,
      'item' => $item,
      'images' => $images,
      'options' => $options,
      'reviews' => $reviews,
      'qnas' => $qnas,
      'favorite' => $favorite,
      'categoryObj' => $categoryObj
    ]);
  }

  // 테이블의 옵션을 관리자용에 사용할 옵션 스트링으로 제작
  private function creteOptionForm($item) {
    $options = $item->options()->select('id', 'title', 'name', 'price', 'sale')->orderBy('id')->get();
    $rtn = [];
    foreach($options as $k => $v) {
      if(!isset($rtn[$v->title])) {
        $rtn[$v->title] = [];
      }

      array_push($rtn[$v->title], $v);
    }

    return $rtn;
  }


  private function buildCategory($category) {

    if(!$category) {
      return null;
    }

    $categories = MarketCategory::where('category', 'like', substr($category, 0, 3).'%')->get();
    $sub_category = [];
    $all_category = [];
    $cur_depth = (strlen($category) / 3) - 1;
    $cur_len =  strlen($category);
    
    foreach($categories as $v) {
      if(strlen($v->category) > $cur_len) {
        // 나머지 카테고리 구하기
        $sub = substr($v->category, $cur_len);
        // $sub를 3 자리식 자르기
        $cat = str_split($sub, 3); 
        if(!isset($sub_category[$cat[0]])) {
          $sub_category[$cat[0]] = new \stdClass;
        }
        if(!isset($cat[1])) {
          $sub_category[$cat[0]]->name = $v->name;
          $sub_category[$cat[0]]->category = $v->category;
          $sub_category[$cat[0]]->sub = [];
        };
        if(isset($cat[1])) {
          $obj = new \stdClass;
          $obj->name = $v->name;
          $obj->category = $v->category;
          array_push($sub_category[$cat[0]]->sub, $obj);
        }
      }
      $all_category[$v->category] = $v;
    }


    // path 설정 (path는 위에서 부터 현재 카테고리 까지만 디스플레이 한다.)
    $path = [];
    $len = strlen($category);
    $path[0] = $all_category[substr($category, 0, 3)];
    if($len >= 6) {
      $path[1] = $all_category[substr($category, 0, 6)];
      if($len == 9) {
        $path[2] = $all_category[substr($category, 0, 9)];
      }
    }
  /**/
    $categoryObj = new \stdClass;
    $categoryObj->category =$category;
    $categoryObj->path = $path;
    $categoryObj->sub_category = $sub_category;

    return $categoryObj;
  }



}