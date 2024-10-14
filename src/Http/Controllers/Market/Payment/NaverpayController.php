<?php
namespace App\Http\Controllers\Market\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;


class NaverpayController extends Controller
{
  public function __construct()
  {
      // $this->middleware('auth');
  }
}