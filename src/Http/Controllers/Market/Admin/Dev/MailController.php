<?php
namespace App\Http\Controllers\Market\Admin\Dev;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Events\OrderShipped;

use DB;
use Illuminate\Support\Facades\Log;
use App\Services\Market\MailService;
use App\Models\Auth\User\User;
use App\Services\Market\OrderService;


use App\Http\Controllers\Controller;

class MailController extends Controller
{

  // use Tag;
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(MailService $mailSvc, OrderService $ordergSvc)
  {
    $this->mailSvc = $mailSvc;
    $this->orderSvc = $ordergSvc;
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function view(Request $request)
  {
    return view('market.admin.dev.mail', []);
  }

  public function send(Request $request)
  {

    $user = User::select('id', 'email', 'name')->find($request->to);
    switch($request->type) {
      
      case 'notice':
        

        // $this->mailSvc->noticeMail($user, $request);
 
        break;
      case 'order':
        event(new OrderShipped($user, $request->o_id));
        break;
      case 'register':
        // $this->mailSvc->registerMail($user);
        event(new Registered($user));
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

        return view('market.templates.mail.'.config('market.template.mail.theme').'.'.$request->type,  ['user'=>$user, 'data'=>$mailData]);
        break;
      case 'register':

        return view('auth.templates.mail.'.config('auth-pondol.template.mail').'.register',  ['notifiable'=>$user]);
        break;
      
    }
  }
  


}
