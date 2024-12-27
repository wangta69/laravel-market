<?php
namespace Pondol\Market\Http\Controllers\Admin\Dev;

use Illuminate\Http\Request;
// use Illuminate\Auth\Events\Registered;
use Pondol\Auth\Events\Registered;
use Pondol\Auth\Events\ResetPasswordToken;
use Pondol\Market\Events\OrderShipped;

use DB;
use Illuminate\Support\Facades\Log;
use Pondol\Market\Services\MailService;
use Pondol\Auth\Models\User\User;
use Pondol\Market\Services\OrderService;


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
    return view('market::admin.dev.mail', []);
  }

  public function send(Request $request)
  {

    
    switch($request->type) {
      
      case 'notice':
        

        // $this->mailSvc->noticeMail($user, $request);
 
        break;
      case 'order':
        $user = User::select('id', 'email', 'name')->find($request->to);
        event(new OrderShipped($request->o_id));
        break;
      case 'register':
        // $this->mailSvc->registerMail($user);
        $user = User::select('id', 'email', 'name')->find($request->to);
        event(new Registered($user));
        break;
      case 'resetpassword':
          $user = User::select('id', 'email', 'name')->where('email', $request->email)->first();
          event(new ResetPasswordToken($user));
          break;
      
    }
    // return view('market.::admin.dev.mail', []);
  }

  public function preview(Request $request)
  {
    $mailData = $request;
    switch($request->type) {
      case 'notice':
        $user = User::select('id', 'email', 'name')->find($request->to);
        
        $mailData->user = $user;
        return view(market_theme('mail').'.'.$request->type,  ['mailData'=>$mailData]);

        break;
      case 'order':
       
        $mailData->items = $this->orderSvc->orderItemsByOrderid($mailData->o_id)->orderBy('market_orders.id', 'desc')->get();     
        $mailData->display = $this->orderSvc->orderDetailByOrderid($mailData->o_id);
        $user = User::select('id', 'email', 'name')->find($mailData->display->user_id);
        foreach($mailData->items as $item) {
      
          $item->displayOptions = extractOptions($item);     
        }

        return view(market_theme('mail').'.'.$request->type,  ['user'=>$user, 'data'=>$mailData]);
        break;
      case 'register':
        $user = User::select('id', 'email', 'name')->find($request->to);
        return view('auth.templates.mail.'.config('pondol-auth.template.mail').'.register',  ['notifiable'=>$user]);
        break;

      case 'resetpassword':
        $user = User::select('id', 'email', 'name')->where('email', $request->email)->first();
        $token=app('auth.password.broker')->createToken($user);
        $actionUrl  = route('password.reset', [$token]);

        return view('auth.templates.mail.'.config('pondol-auth.template.mail').'.resetpassword',  ['notifiable'=>$user, 'actionUrl'=>$actionUrl, 'token'=>$token]);
        break;
      
    }
  }
  
}
