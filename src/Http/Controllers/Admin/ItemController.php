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
use Pondol\Market\Models\MarketItemDisplay;
use Pondol\Market\Models\MarketItemImage;
use Pondol\Market\Models\MarketItemTag;

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


      // $items = $users->where(function ($q) use($from_date, $to_date) {
      //   $q->whereRaw("DATE(market_items.created_at) >= '".$from_date."' AND DATE(market_items.created_at)<= '".$to_date."'" );
      // });
    }

    $items = $items->orderBy('id', 'desc')->paginate(15)->withQueryString();
    return view('market::admin.item.index', [
      'items'=>$items
    ]);
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
    
    $this->storeOption($item->id,  $option);
    $item->category = $this->storeCategory($item->id, $category1, $category2, $category3);
    $this->storeDisplay($item->id, $request->display);
    $this->storeTags($item->id, $request->tags);
    $this->contents_update($item);
    $item->save();
    return redirect()->route('market.admin.items');
  }

  /**
   * 상품 수정 폼
   */
  public function modify(MarketItem $item) {
    $display = $item->display->pluck('name')->all(); // display option
    // $categories = $item->categories->toJson();
    $categories = $item->categories()->select('category')->get()->toJson();
    $images = $item->images()->select('image')->get()->toJson();
    $options = $this->creteOptionForm($item);
    $tags = MarketItemTag::select(
      't.id', 't.tag'
    )->join('market_tags as t', function($join){
      $join->on('market_item_tags.tag_id', '=', 't.id');
    })->where('market_item_tags.item_id', $item->id)->get();

    if ($tags->isEmpty()) {
      $tags = [];
    }
    // print_r(json_encode($tags));
    return view('market::admin.item.create', [
      'item' => $item,
      'display' => $display,
      'categories' => $categories,
      'images' => $images,
      'options' => json_encode($options),
      'tags' => json_encode($tags)
    ]);
  }

  // 상품 업데이트
  public function update(MarketItem $item, Request $request) {
    $category1 = $request->category1;
    $category2 = $request->category2;
    $category3 = $request->category3;

    $file = $request->file;
    $option = $request->option;

    // $item->category = $category;
    $item->name = $request->name;
    $item->model = $request->model;
    $item->cost = str_replace(',', '', $request->input('cost', 0));
    $item->price = str_replace(',', '', $request->price);
    $item->t_point = str_replace(',', '', $request->t_point);
    $item->stock = $request->stock;
    $item->description = $request->description;
    $item->shorten_description = $request->shorten_description;

    // 제품이미지 업로드
    // $filepath = 'public/market/items/'.$item->id;
    // if(is_array($request->file('files'))) {
    //   foreach ($request->file('files') as $index => $upload) {

    //     if ($upload == null) {
    //       continue;
    //     }
        
    //     // 기존 이미지는 삭제
    //     \Storage::delete($item->image);

    //     $filename = $upload->getClientOriginalName();
    //     $path=\Storage::put($filepath, $upload); // //Storage::disk('local')->put($name,$file,'public');  
    //     $item->image = $path;
    //   }
    // }

    $item->save();

    $path = $this->storeImage($item->id, $request->file('files'));
    if(isset($path[0])) {
      $item->image = $path[0];
      
    }
    
    $this->storeOption($item->id,  $option);
    $item->category = $this->storeCategory($item->id, $category1, $category2, $category3);
    $this->storeDisplay($item->id, $request->display);
    $this->storeTags($item->id, $request->tags);
    $this->contents_update($item);
    $item->save();

    return redirect()->route('market.admin.items');

  }

  // image 저장
  private function storeImage($item_id, $files) {
    $pathes = [];
    $filepath = 'public/market/items/'.$item_id;
    if(is_array($files)) {
      foreach ($files as $index => $upload) {
        if ($upload == null) {
          array_push($pathes, null);
          continue;
        }
        
        // 기존 이미지는 삭제
        // \Storage::delete($item->image);

        $filename = $upload->getClientOriginalName();
        $path=\Storage::put($filepath, $upload); // //Storage::disk('local')->put($name,$file,'public');  
        array_push($pathes, $path);
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
    $sourceDir = storage_path() .'/app/public/tmp/editor/'. session()->getId();
    $destinationDir = storage_path() .'/app/public/market/items/'.$item->id.'/editor';

    $item->description = str_replace('/storage/tmp/editor/'.session()->getId(), '/storage/market/items/'.$item->id.'/editor', $item->description);

    $item->save();

    $success = File::copyDirectory($sourceDir, $destinationDir);
    Storage::deleteDirectory('public/tmp/editor/'. session()->getId());

    return;
  }

  public function destroy(MarketItem $item, Request $request) {
    $item->delete();
    // market_item_categories에서도 제품을 삭제한다.
    MarketItemCategory::where('item_id', $item->id)->delete();
    return response()->json(['error'=>false]);
  }

}
