<?php

namespace Pondol\Market\View\Components;

use Illuminate\View\Component;

use Pondol\Common\Facades\JsonKeyValue;
// use DB;

class MailFooter extends Component
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

    $company = JsonKeyValue::getAsJson('company');
    return view('market::components.mail-footer', compact('company'));
  }


}
