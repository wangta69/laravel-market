<?php
namespace App\Http\Controllers\Market\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;


class KcpController extends Controller
{
  public function __construct()
  {
      // $this->middleware('auth');
  }
}