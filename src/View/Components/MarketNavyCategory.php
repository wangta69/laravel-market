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
    if (!$this->categoryObj) {
      return null;
    }
    
    return view(market_theme('components').'.navycategory', [
      'categoryObj'=>$this->categoryObj
    ]);
  }


}
