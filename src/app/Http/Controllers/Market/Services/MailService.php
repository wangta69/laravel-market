<?php
namespace App\Http\Controllers\Market\Services;
use Illuminate\Support\Facades\Log;

use App\Jobs\JobEmailForMarket;
use Mail;
use App\Mail\SendEmailForMarket;
use App\Http\Controllers\Market\Services\OrderService;
class MailService
{

  function __construct( OrderService $ordergSvc) {//
    $this->orderSvc = $ordergSvc;
  }

  /**
   * 회원가입메일
   */
  public function registerMail($user) {
    $data = new \stdClass;
    $data->user = $user;
    $data->type = 'register';
    $data->subject = $user->name.'님의 회원가입정보입니다.';
    $data->message = null;
    dispatch(new JobEmailForMarket($data));
  }

  /**
   * 주문메일
   * @params $params type, o_id, 
   */
  public function orderMail($user, $params) {
    $data = new \stdClass;
    $data->user = $user;
    $data->type = $params->type;
    $data->o_id = $params->o_id;
    $data->subject = $user->name.'님의 주문정보입니다.';
    $data->message = null;
    $data->items = $this->orderSvc->orderItemsByOrderid($data->o_id)->orderBy('market_orders.id', 'desc')->get();     
    $data->display = $this->orderSvc->orderDetailByOrderid($data->o_id);

    foreach($data->items as $item) {
  
      $item->displayOptions = extractOptions($item);     
    }

    dispatch(new JobEmailForMarket($data));
  }

   /**
   * 회원가입메일
   */
  public function noticeMail($user, $params) {
    $data = new \stdClass;
    $data->user = $user;
    $data->type = $params->type;
    $data->subject = $params->subject;
    $data->message = $params->message;
    dispatch(new JobEmailForMarket($data));
  }




/**
   * 테스트메일
   */
  public function testMail($params) {
    $data = new \stdClass;
    $data->mail_to = 'yourMailAddress';
    $data->subject = 'This is Only Test Mail';
    $data->message = 'Do not reply this mail';
    dispatch(new JobEmailForMarket($data));
  }

}
