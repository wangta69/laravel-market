<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Market\MarketCategory as CategoryModel;
// use DB;

class MarketCategory extends Component
{
  public function __construct() {

  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {

    $category = CategoryModel::whereRaw('LENGTH(category) = 3')->orderBy('order', 'asc')->get();
    return view('market.templates.components.'.config('market.template.component.theme').'.category', [
      'category'=>$category
    ]);
  }


}
