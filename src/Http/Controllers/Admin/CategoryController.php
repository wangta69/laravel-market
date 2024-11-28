<?php
namespace Pondol\Market\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;

use Pondol\Market\Models\MarketCategory;
use Pondol\Market\Models\MarketItemCategory;
use Pondol\Market\Models\MarketItem;


class CategoryController extends Controller
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
  public function index()
  {

    // $cat1 = $this->subCategory('');
    return view('market::admin.category.index', [

    ]);
  }

  public function store(Request $request) {
    $name = $request->name;
    $parent = $request->parent;
    $category = $this->createCategoryCode($parent);

    $cat = new MarketCategory;
    $cat->category = $category;
    $cat->name = $name;
    $cat->save();
    return response()->json($cat);
  }

  /**
   * 현재 depth의 다음 카테고리 생성
   */
  private function createCategoryCode($parent) {
    if (!$parent) {
      $parent = '';
    }
    // if(!$parent) {
    //     $depth = 1;
    // } else {
    //     $depth = (strlen($parent) / 3) + 1;
    // }
    $parent_len = strlen($parent);
    $category_len = $parent_len + 3;
    
    $prevCategory = MarketCategory::select('category')
      ->where(DB::raw("LENGTH(`category`)"),$category_len)
      ->where(DB::raw("LEFT(`category`, $parent_len)"), $parent)
      ->orderBy('category', 'desc')
      ->first();
    if (!$prevCategory) {
      return $parent.'001';
    } else {
      $category = (int)$prevCategory->category + 1;
      return str_pad($category , $category_len, "0", STR_PAD_LEFT);
    }
    
  }

  /**
   * 현재 depth 의 sub category 가져오기 
   * @param String $type json | data
   */

  public function subCategory($category, $type='data') {
    if(!$category) {
        $len = 0;
        $depth = 1;
        $category = ''; // null로 넘어오는 것을 공백으로 변경
    } else {
        $len = strlen($category);
        $depth = (strlen($category) / 3) + 1;
    }

    $sub_len = $len  + 3;

    $items = MarketCategory::where(DB::raw("LENGTH(`category`)"), $sub_len)
    ->where(DB::raw("LEFT(`category`, $len)"), $category)
    ->get(); // 대분류 카테고리

    // $querylog = DB::getQueryLog();
    // var_dump($querylog);
    switch($type) {
      case 'json':
        $rtn = ['items'=>$items, 'depth'=> $depth];
        return response()->json($rtn); // 
        break;
      default:
        return $items;
        break;
    }
  }

  /**
   * 현재 depth 의 sub category 가져오기 
   * @param String $type json | data
   */

  public function sub(Request $request) {
    $category = $request->category;
    $type = $request->type;
    return $this->subCategory($category, $type);
  }

  public function destroy(Request $request) {
    $category = $request->category;

    ## 하위 카테고리 존재시 삭제를 cancel
    $count = MarketCategory::where('category', 'like', $category.'%')->count();

    if ($count > 1) { ## 자신을 폼함하여 1개 이상 존재시
      return response()->json([
        'error'=>'하위 카테고리가 존재 합니다.'.PHP_EOL.'먼저 하위 카테고리를 삭제해 주시기 바랍니다.'
      ]);
    }

    ## 현카테고리에 상품이 존재하면 삭제를 cancel
    $count = MarketItemCategory::where('category', $category)->count();
    if ($count > 0) {## 제품이 한개 이상 존재시
      return response()->json(['error'=>'현재 카테고리에 상품이 존재 합니다.'.PHP_EOL.'먼저 현재 카테고리에 등록된 상품을 삭제하거나 다른 카테고리로 이동해 주시기 바랍니다.']);
    }

    # 카테고리 삭제
    $result = MarketCategory::where('category', $category)->delete();
    return response()->json(['error'=>false]);
  }

  public function update(Request $request) {
    $category = $request->category;
    $name = $request->name;

    MarketCategory::where('category', $category)
    ->update(['name' => $name]);
    return response()->json(['error'=>false]);
  }


}
