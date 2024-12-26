<?php
namespace Pondol\Market\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;

use Pondol\Market\Traits\Favorite;

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
  public function store(Request $request, $item)
  {
    return response()->json($this->_store($request, $item));
  }

  public function destroy(Request $request, $fav)
  {
    return response()->json($this->_destroy($request, $fav));
  }
}