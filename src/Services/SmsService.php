<?php
namespace Pondol\Market\Services;
use Illuminate\Support\Facades\Log;
class SmsService
{
  private $VENDOR;
  private $SMS_KEY;
  private $SMS_ID;
  private $SMS_SENDER;//다이렉트센드 회원가입시 등록한 전화번호
  private $smsClass;

  function __construct() {//
    $this->VENDOR = env('SMS_VENDOR');
    $this->SMS_KEY = env('SMS_KEY');
    $this->SMS_ID = env('SMS_ID');
    $this->SMS_SENDER = env('SMS_SENDER');
    switch ($this->VENDOR) {
      case 'SMS.TO':
        $this->smsClass = new smsTo($this->SMS_KEY, $this->SMS_ID);
        break;
      case 'DIRECTSEND':
        $this->smsClass = new directSend($this->SMS_KEY, $this->SMS_ID, $this->SMS_SENDER);
        break;
    }
  }

  public function sendSms($params) {
    return $this->smsClass->sendSms($params);
  }
}

/**
 * http://sms.to
 */
class smsTo {
  private $SMS_KEY;
  private $SMS_ID;

  function __construct($key, $id) {//
    $this->SMS_KEY = $key;
    $this->SMS_ID = $id;
  }

  /**
   *@param Array $params [maeeage: string, recipients: '+35799999999999']
    */
  public function sendSms($params) {
    $curl = curl_init();
    $data = [
      'message' => $params["message"],
      'to' => $params["recipients"],
      'sender_id' => $this->SMS_ID,
      'callback_url' => ''
    ];

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.sms.to/sms/send",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS =>json_encode($data),
      CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Accept: application/json",
        "Authorization: Bearer ".$this->SMS_KEY
      ]
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($response);
    $error = false;

    if ($result->success != true) {
        $error = true;
    }

    Log::info(json_encode($result));

    $return = [
      'error' => $error,
      'message' => $result->message,
      'response' => $result
    ];
    return (object)$return;
    // {"message":"Message is queued for sending! Please check report for update","success":true,"message_id":"11eb-1509-31c2ebb0-9d0b-0242ac120007"}
  }
}

/**
 * directsend.co.kr
 */
class directSend {
  private $SMS_KEY;
  private $SMS_ID;
  private $SMS_SENDER;//다이렉트센드 회원가입시 등록한 전화번호
  function __construct($key, $id, $sender) {//
    $this->SMS_KEY = $key;
    $this->SMS_ID = $id;
    $this->SMS_SENDER = $sender;
  }

  /**
  * 문자보내기 (이부분은 서비스 파트로 분리하여 다른 컨트롤러에서도 쉽게 접근하게 구성한다.)
  * @param Array $params = array(message:보낼내용, recipients:수신자"01012347985,01012341111");
  */
  public function sendSms($params){
    $message = base64_encode(iconv("utf-8", "euc-kr", $params["message"]));
    $recipients = $params["recipients"];
    $sender = $this->SMS_SENDER;
    $username = $this->SMS_ID;
    $key = $this->SMS_KEY;

    $ch = curl_init();

    $postvars = "message=" . urlencode($message)
    . "&sender=" . urlencode($sender)
    . "&username=" . urlencode($username)
    . "&recipients=" . urlencode($recipients)
    . "&key=" . urlencode($key);


    $url = "https://directsend.co.kr/index.php/api/v1/sms";

    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $postvars);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
    curl_setopt($ch,CURLOPT_TIMEOUT, 20);
    $response = curl_exec($ch);
    curl_close ($ch);

    return json_decode($response);
  }

  /**
   * 다이렉트 센드 리턴 코드
   */
  public function directsend_status_code($status){
    $code = [
      "0"=>"정상발송",
      "100"=>"POST validation 실패",
      "101"=>"sender 유효한 번호가 아님",
      "102"=>"recipient 유효한 번호가 아님",
      "103"=>"api key or user is invalid",
      "104"=>"recipient count = 0",
      "105"=>"message length = 0",
      "106"=>"message validation 실패",
      "205"=>"잔액부족",
      "999"=>"Internal Error."
    ];

    return $code[$status];
  }
}
