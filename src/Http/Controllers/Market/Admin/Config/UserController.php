<?php
namespace App\Http\Controllers\Market\Admin\Config;

use Illuminate\Http\Request;
use App\Traits\Auth\Admin\Config as tConfig;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

  use tConfig;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {}

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $result = $this->_index($request);
    return view('market.admin.config.user', $result);
  }

  public function update(Request $request) {
    $this->_update($request);
    return response()->json(['error'=>false]);
  }
}
