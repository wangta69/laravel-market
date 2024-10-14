<?php
namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;

use App\Models\Market\MarketCategory;
use App\Http\Controllers\Market\Services\Meta;
use App\Http\Controllers\Market\Traits\Item;

class SearchController extends Controller
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


  public function index(Request $request) {
    // DB::enableQueryLog();
    $items =  $this->searchItems($request)
    // ->orderBy('market_items.id', 'desc') // Fulltext search 는 order by 절이 없어야 한다.
    ->paginate(15)->withQueryString();

    // 1차 카테고리 가졍오기
    $categories = MarketCategory::select('category', 'name')
    ->whereRaw('length(category) = 3')
    ->orderBy('category', 'asc')
    ->get();

    $this->meta->title = $request->q;
    $this->meta->description = $request->q.'에 대한 검색결과';
    // print_r(DB::getQueryLog());
    return view('market.templates.search.'.config('market.template.search.theme').'.search', [
      'items'=> $items,
      'meta' => $this->meta,
      'categories'=>$categories
    ]);

  }

}