<?php

namespace Pondol\Market\View\Components;

use Illuminate\View\Component;
use Pondol\Market\Models\MarketBanner;
// use DB;

class Banner extends Component
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

    $items = MarketBanner::where('position', 'MainTop')->get();

    return view('market.templates.components.main-carousel', compact('items'));
  }


}
