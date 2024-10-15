<?php
namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use App\Models\Market\MarketConfig;
// use App\Models\Market\MarketCategory;
// use App\Models\Market\MarketItem;
// use App\Models\Market\MarketItemQna;
use App\Services\Market\Meta;



class PagesController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(Meta $meta){
    $this->meta = $meta;
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, $page)
  {
    $item = null;
    switch($page) {
      case 'privacy-policy':
        $this->meta->title = "개인정보처리방침";
        
        $privacyPolicy = MarketConfig::where('key', 'privacyPolicy')->first();
        $item = $privacyPolicy->value;
        break;
      case 'terms-of-use':
        $this->meta->title = "서비스이용약관";
        $termsOfUse = MarketConfig::where('key', 'termsOfUse')->first();
        $item = $termsOfUse->value;
        break;
    }

    // $article->parent_id = $parent_id ? $parent_id : $article->id;
    // $article->save();

    return view('market.templates.pages.'.config('market.template.pages.theme').'.'.$page, [
    'meta' => $this->meta,
    'item' => $item,
    ]);


  }

  // protected function get_order_num($params=null){
  //   $order_num = MarketItemQna::min('order_num');
  //   return $order_num ? $order_num-1:-1;
  // }

}