<?php

namespace Pondol\Market\View\Components;

use Illuminate\View\Component;
use Pondol\Market\Models\MarketCategory as CategoryModel;
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
    return view(market_theme('components').'.category', compact('category'));
  }


}
