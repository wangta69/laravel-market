<?php
namespace Pondol\Market\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Carbon\Carbon;
use File;
use Storage;


use Pondol\Market\Models\MarketItem;
use Pondol\Market\Models\MarketItemCategory;
use Pondol\Market\Models\MarketItemOption;
use Pondol\Market\Models\MarketItemSpec;
use Pondol\Market\Models\MarketItemDisplay;
use Pondol\Market\Models\MarketItemImage;
use Pondol\Market\Models\MarketItemTag;
use Pondol\Editor\Facades\Editor;
use Pondol\Meta\Facades\Meta;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    // $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

    $sk = $request->sk;
    $sv = $request->sv;
    $from_date = $request->from_date;
    $to_date = $request->to_date;

    $items = MarketItem::select('market_items.*'); 

    if ($sv) {
      $items = $items->where($sk, 'like', '%' . $sv . '%');
    }

    if ($from_date) {
      if (!$to_date) {
        $to_date = date("Y-m-d");
      }

      $from_date = Carbon::createFromFormat('Y-m-d', $from_date);
      $to_date = Carbon::createFromFormat('Y-m-d', $to_date);
      $items =  $items->whereBetween('market_items.created_at', [$from_date->startOfDay(), $to_date->endOfDay()]);
    }

    if($request->ajax()){
      return response()->json(['error'=>false, 'items'=>$items->get()], 200);//500, 203
    } else {
      $items = $items->orderBy('id', 'desc')->paginate(15)->withQueryString();
      return view('market::admin.item.index', [
        'items'=>$items
      ]);
    }

    
  }

  /**
   * 상품 신규 등록 폼
   */
  public function create() {
    $item = new MarketItem;
    $item->stock = -1;
    $item->cost = 0;
    $item->price = 0;
    $item->t_point = 0;
    return view('market::admin.item.create', [
      'item' => $item,
      'display' => [],
      'categories' => json_encode([]),
      'images'  => json_encode([]),
      'options' => json_encode([]),
      'tags' => json_encode([]),
    ]);
  }

  public function store(Request $request) {

    $category1 = $request->category1;
    $category2 = $request->category2;
    $category3 = $request->category3;

    $file = $request->file;
    $option = $request->option;
    $specs = $request->specs;

    $item = new MarketItem;
    // $item->category = $category;
    $item->name = $request->name;
    $item->model = $request->model;
    $item->cost = str_replace(',', '', $request->input('cost', 0));
    $item->price = str_replace(',', '', $request->price);
    $item->t_point = str_replace(',', '', $request->t_point);
    $item->stock = $request->stock;
    $item->description = $request->description;
    $item->shorten_description = $request->shorten_description;
    $item->save();

    // 제품이미지 업로드
    $path = $this->storeImage($item->id, $request->file('files'));
    if(isset($path[0])) {
      $item->image = $path[0];
    }
    
    $this->storeOption($item->id,  $option); // 등록옵션 입력
    $this->storeSpec($item->id,  $specs); // 추가필드 입력
    $item->category = $this->storeCategory($item->id, $category1, $category2, $category3);
    $this->storeDisplay($item->id, $request->display);
    $this->storeTags($item->id, $request->tags);
    $this->contents_update($item);
    $item->save();

    // $meta 처리하기
    Meta::set('market.item', ['item'=>(string)$item->id])
    ->title($item->name)
    ->description($item->shorten_description)
    ->extractKeywordsFromArray($item->tags, 'tag')
    ->image(\Storage::url($item->image))
    ->update();

    return redirect()->route('market.admin.items');
  }

  /**
   * 상품 수정 폼
   */
  public function edit(MarketItem $item) {
    $display = $item->display->pluck('name')->all(); // display option
    // $categories = $item->categories->toJson();
    $categories = $item->categories()->select('category')->get()->toJson();
    $images = $item->images()->select('image')->get()->toJson();
    $options = $this->creteOptionForm($item);
    // $tags = MarketItemTag::select(
    //   't.id', 't.tag'
    // )->join('market_tags as t', function($join){
    //   $join->on('market_item_tags.tag_id', '=', 't.id');
    // })->where('market_item_tags.item_id', $item->id)->get();


    // if ($tags->isEmpty()) {
    //   $tags = [];
    // }
    // $temp = ;

    return view('market::admin.item.create', [
      'item' => $item,
      'display' => $display,
      'categories' => $categories,
      'images' => $images,
      'options' => json_encode($options),
      'tags' => json_encode($item->tags)
    ]);
  }

  // 상품 업데이트
  public function update(MarketItem $item, Request $request) {
    $category1 = $request->category1;
    $category2 = $request->category2;
    $category3 = $request->category3;

    $file = $request->file;
    $option = $request->option;
    $specs = $request->specs;

    // $item->category = $category;
    $item->name = $request->name;
    $item->model = $request->model;
    $item->cost = str_replace(',', '', $request->input('cost', 0));
    $item->price = str_replace(',', '', $request->price);
    $item->t_point = str_replace(',', '', $request->t_point);
    $item->stock = $request->stock;
    $item->description = $request->description;
    $item->shorten_description = $request->shorten_description;
    $item->save();

    // 업로드 이미지 처리
    $path = $this->storeImage($item->id, $request->file('files'));
    if(isset($path[0])) {
      $item->image = $path[0];
    }
    

    

    $this->storeOption($item->id,  $option); // 등록옵션 입력
    $this->storeSpec($item->id,  $specs); // 추가필드 입력
    $item->category = $this->storeCategory($item->id, $category1, $category2, $category3);
    $this->storeDisplay($item->id, $request->display);
    $this->storeTags($item->id, $request->tags);
    $this->contents_update($item);
    $item->save();

    // $meta 처리하기
    Meta::set('market.item', ['item'=>(string)$item->id])
      ->title($item->name)
      ->description($item->shorten_description)
      ->extractKeywordsFromArray($item->tags, 'tag')
      ->image(\Storage::url($item->image))
      ->update();
    return redirect()->route('market.admin.items');

  }

  // image 저장
  private function storeImage($item_id, $files) {
    $pathes = [];
    $filepath = 'public/market/items/'.$item_id;


    if(is_array($files)) {
      $max = max(array_keys($files));
      echo 'max:'.$max.PHP_EOL;
      for($i = 0; $i <= $max; $i++) {
        if(isset($files[$i])) {
          $upload = $files[$i];
          $filename = $upload->getClientOriginalName();
          $path=\Storage::put($filepath, $upload); // //Storage::disk('local')->put($name,$file,'public');  
          array_push($pathes, $path);
        } else {
          array_push($pathes, null);
        }
      }
    }

    foreach($pathes as $k=>$v) {
      if ($v) {//새로이 덮어 씌우는 것이라면 
        $itemImage = MarketItemImage::firstOrNew(['item_id'=>$item_id, 'order' => $k]);
        $itemImage->image = $v;
        $itemImage->save();
      }
    }

    return $pathes;
  }

  // display option 저장
  private function storeOption($item_id, $option) {
    // 옵션등록
    // 1. 기존 옵션은 삭제
    MarketItemOption::where('item_id', $item_id)->delete();
    // 옵션 등록
    if(isset($option['name'])) {
      foreach($option['name'] as $k=>$title) {
        $val = $option['val'][$k];
        $exp = explode("|", $val);
        foreach($exp as $op) {
          $each = explode(":", $op);
          $name = $each[0];
          $price = $each[1];
          $sale = $each[2];

          $optionItem = new MarketItemOption;
          $optionItem->item_id = $item_id;
          $optionItem->title = $title;
          $optionItem->name = $name;
          $optionItem->price = $price;
          $optionItem->sale = $sale;
          $optionItem->save();
        }
      }
    }
  }

  /**
   * 추가필드 입력
   */
  private function storeSpec($item_id, $specs) {
    // 옵션등록
    // 1. 기존 옵션은 삭제
    MarketItemSpec::where('item_id', $item_id)->delete();
    // 옵션 등록
    if(isset($specs['name'])) {
      foreach($specs['name'] as $k=>$title) {
        $comment = $specs['val'][$k];

        $specsItem = new MarketItemSpec;
        $specsItem->item_id = $item_id;
        $specsItem->title = $title;
        $specsItem->comment = $comment;
        $specsItem->save();
      }
    }
  }


  // display option 저장
  private function storeCategory($item_id, $cat1, $cat2, $cat3) {
    // 옵션등록
    // 1. 기존 카테고리 삭제
    MarketItemCategory::where('item_id', $item_id)->delete();
    $defaultCategory = '';
    // 옵션 등록
    foreach($cat1 as $k=>$v) {
      $cat = $cat3[$k] ? : ($cat2[$k] ? : $cat1[$k]);
      $category = MarketItemCategory::withTrashed()->firstOrNew(['item_id'=>$item_id, 'category' => $cat]);
      $category->order = $k;
      $category->save();
      $category->restore();
      if($k === 0) {
        $defaultCategory = $cat;
      }
    }
    return $defaultCategory;
  }

  // display option 저장
  private function storeDisplay($item_id, $display) {
 // 옵션등록
    // 1. 기존 옵션은 삭제
    MarketItemDisplay::where('item_id', $item_id)->delete();
    // 옵션 등록
    if(isset($display)) {
      foreach($display as $k => $v) {
        $display = MarketItemDisplay::withTrashed()->firstOrNew(['item_id'=>$item_id, 'name' => $k]);
        $display->save();
        $display->restore();
      }
    }
  }

  /**
   * 태그 등록
   */
  private function storeTags($item_id, $tagstr) {
    // 1. 기존 카테고리 삭제
    MarketItemTag::where('item_id', $item_id)->delete();
    if($tagstr) {
      $tags = explode(',', $tagstr);
      // 태그 등록
      foreach($tags as $v) {
        $tag = new MarketItemTag;
        $tag->item_id = $item_id;
        $tag->tag_id = $v;
        $tag->save();
      }
    }

  }

  // 테이블의 옵션을 관리자용에 사용할 옵션 스트링으로 제작
  private function creteOptionForm($item) {
    $options = $item->options()->orderBy('id')->get();
    $rtn = [];
    foreach($options as $k => $v) {
      if(!isset($rtn[$v->title])) {
        $rtn[$v->title] = [];
      }
      $option = $v->name.':'.$v->price.':'.$v->sale;
      array_push($rtn[$v->title], $option);
    }

    $itemOption = [];
    foreach($rtn as $k => $v) {
      $itemOption[$k] = implode('|', $v);
    }

    return $itemOption;
  }

  /*
  * description에 있는 이미지들을 제품 이미지 쪽으로 옮기고 기존 temp에 있는 이미지들을 리셑한다.
  */
  private function contents_update($item) {
    // editor의 임시 파일일 경우 파일을 이동 처리한다.
    $sourceDir = storage_path() .'/app/public/tmp/editor/'. session()->getId();
    $destinationDir = storage_path() .'/app/public/market/items/'.$item->id.'/editor';
    $success = File::copyDirectory($sourceDir, $destinationDir);
    $item->description = str_replace('/storage/tmp/editor/'.session()->getId(), '/storage/market/items/'.$item->id.'/editor', $item->description);
    // 현재 tmp directory 삭제    
    Storage::deleteDirectory('public/tmp/editor/'. session()->getId());

    // 본문속 이미지가 base64로 된 경우 특정 위치로 이동 처리한다.
    $item->description = Editor::extractBase64Image($item->description,  $destinationDir, '/storage/market/items/'.$item->id.'/editor/');

    $item->save();
    return;
  }

  public function destroy(MarketItem $item, Request $request) {
    $item->delete();
    // market_item_categories에서도 제품을 삭제한다.
    MarketItemCategory::where('item_id', $item->id)->delete();
    return response()->json(['error'=>false]);
  }

}
