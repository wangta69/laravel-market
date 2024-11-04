<?php

namespace Pondol\Market\View\Components;

use Illuminate\View\Component;
use Pondol\Market\Models\MarketCategory;

class MarketNavyCategory extends Component
{
  private $category;
  public function __construct($categoryObj=null) {
    $this->categoryObj = $categoryObj;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {

    // $categories = MarketCategory::where('category', 'like', substr($this->category, 0, 3).'%')->get();
    // // print_r($categories);
    // $sub_category = [];
    // $all_category = [];
    // $cur_depth = (strlen($this->category) / 3) - 1;
    // $cur_len =  strlen($this->category);
   
    // foreach($categories as $v) {
    //   if(strlen($v->category) > $cur_len) {
    //     // 나머지 카테고리 구하기
    //     $sub = substr($v->category, $cur_len);
    //     // $sub를 3 자리식 자르기
    //     $cat = str_split($sub, 3); 
    //     if(!isset($sub_category[$cat[0]])) {
    //       $sub_category[$cat[0]] = new \stdClass;
    //     }
    //     if(!isset($cat[1])) {
    //       $sub_category[$cat[0]]->name = $v->name;
    //       $sub_category[$cat[0]]->category = $v->category;
    //       $sub_category[$cat[0]]->sub = [];
    //     };
    //     if(isset($cat[1])) {
    //       $obj = new \stdClass;
    //       $obj->name = $v->name;
    //       $obj->category = $v->category;
    //       array_push($sub_category[$cat[0]]->sub, $obj);
    //     }
    //   }


    //   $all_category[$v->category] = $v;
    //   // array_push($view_category[$depth], $v);
    // }


    // // path 설정 (path는 위에서 부터 현재 카테고리 까지만 디스플레이 한다.)
    // $path = [];
    // $len = strlen($this->category);
    // $path[0] = $all_category[substr($this->category, 0, 3)];
    // if($len >= 6) {
    //   $path[1] = $all_category[substr($this->category, 0, 6)];
    //   if($len == 9) {
    //     $path[2] = $all_category[substr($this->category, 0, 9)];
    //   }
    // }
 /**/
    if (!$this->categoryObj) {
      return null;
    }
    
    return view('market.templates.components.'.config('pondol-market.template.component.theme').'.navycategory', [
      'categoryObj'=>$this->categoryObj
      // 'category'=>$this->category,
      // 'path'=>$path,
      // 'sub_category'=>$sub_category,
    ]);
  }


}
