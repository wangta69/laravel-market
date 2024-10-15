<?php
namespace App\Http\Controllers\Market;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;

use App\Traits\Market\Favorite;

class FavoriteController extends Controller
{

  use Favorite;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(

  ){

  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function _store(Request $request, $item)
  {
    return response()->json($this->store($request, $item));
  }

  public function _destroy(Request $request, $fav)
  {
    return response()->json($this->destroy($request, $fav));
  }
}