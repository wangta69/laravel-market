<?php
namespace App\Http\Controllers\Market\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;

use App\Traits\Market\Tag;

class TagController extends Controller
{

  use Tag;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {

  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function _store(Request $request)
  {
    return response()->json($this->store($request));
  }


}
