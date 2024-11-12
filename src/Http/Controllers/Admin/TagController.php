<?php
namespace Pondol\Market\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;

use Pondol\Market\Traits\Tag;

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
  public function store(Request $request)
  {
    return response()->json($this->_store($request));
  }


}
