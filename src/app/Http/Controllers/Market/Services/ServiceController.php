<?php
namespace App\Http\Controllers\Market\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;



class ServiceController extends \App\Http\Controllers\Controller {

  public function __construct() {
  }

  /*
   * List Page
   *
   * @param String $tbl_name
   * @return \Illuminate\Http\Response
   */
  public function routeUrl(Request $request)
  {
    try {
      return route($request->name, $request->params);
    } catch (\Exception $e) {
   
    }
    
  }
}
