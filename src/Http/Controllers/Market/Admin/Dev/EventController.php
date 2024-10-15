<?php
namespace App\Http\Controllers\Market\Admin\Dev;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
use App\Models\Auth\User\User;
use App\Services\Market\OrderService;


// use App\Events\Registered;


class EventController extends Controller
{

  // use Tag;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(OrderService $ordergSvc)
  {

    $this->orderSvc = $ordergSvc;
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function view(Request $request)
  {
    return view('market.admin.dev.event', []);
  }

  public function send(Request $request)
  {

    $user = User::select('id', 'email', 'name')->find($request->to);
    switch($request->type) {
      
      case 'notice':
        

        break;
      case 'order':

        break;
      case 'register':
        \Log::info('register event fired');
        // Registered::dispatch($user);
        // event(new Registered($user));
        break;
      
    }
    // return view('market.admin.dev.mail', []);
  }

  public function preview(Request $request)
  {

    $user = User::select('id', 'email', 'name')->find($request->to);
      // print_r($request->all());
      // print_r($user);
      $mailData = $request;
      $mailData->user = $user;
      
    switch($request->type) {
      case 'notice':
        
        return view('market.templates.mail.'.config('market.template.mail.theme').'.'.$request->type,  ['mailData'=>$mailData]);

        break;
      case 'order':

        $mailData->items = $this->orderSvc->orderItemsByOrderid($mailData->o_id)->orderBy('market_orders.id', 'desc')->get();     
        $mailData->display = $this->orderSvc->orderDetailByOrderid($mailData->o_id);

        foreach($mailData->items as $item) {
      
          $item->displayOptions = extractOptions($item);     
        }

        return view('market.templates.mail.'.config('market.template.mail.theme').'.'.$request->type,  ['mailData'=>$mailData]);
        break;
      case 'register':

        return view('market.templates.mail.'.config('market.template.mail.theme').'.'.$request->type,  ['mailData'=>$mailData]);
        break;
      
    }
  }
  


}
