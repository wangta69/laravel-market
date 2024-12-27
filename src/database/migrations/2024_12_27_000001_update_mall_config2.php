<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class  UpdateMallConfig2 extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    if (Schema::hasTable('json_key_values')) {
      DB::table('json_key_values')->updateOrInsert(
        ['key' => 'market.template'],['v' => '{"ci":"logo.png","favicon":"favicon.ico","layouts":{"theme":"default"},"main":{"theme":"default"},"shop":{"theme":"default","lists":"20"},"cart":{"theme":"default"},"order":{"theme":"default"},"userpage":{"theme":"default"},"search":{"theme":"default","lists":"20"},"components":{"theme":"default"},"mail":{"theme":"default"},"pages":{"theme":"default"}}']
      );

      $banks = [
      '039'=>['name'=>'경남은행', 'siwft'=>'KYNAKR22XXX'],
      '034'=>['name'=>'광주은행', 'siwft'=>'KWABKRSE'],
      '004'=>['name'=>'국민은행', 'siwft'=>'CZNBKRSE'],
      '003'=>['name'=>'기업은행', 'siwft'=>'IBKOKRSE'],
      '011'=>['name'=>'농협은행', 'siwft'=>'NACFKRSEXXX'],
      '031'=>['name'=>'대구은행', 'siwft'=>'DAEBKR22'],
      '032'=>['name'=>'부산은행', 'siwft'=>'PUSBKR2P'],
      '002'=>['name'=>'산업은행', 'siwft'=>'KODBKRSE'],
      '050'=>['name'=>'상호저축은행', 'siwft'=>''],
      '045'=>['name'=>'새마을금고', 'siwft'=>''],
      '007'=>['name'=>'수협은행', 'siwft'=>'NFFCKRSE'],
      '027'=>['name'=>'씨티은행', 'siwft'=>'CITIKRSX'],
      '088'=>['name'=>'신한은행', 'siwft'=>'SHBKKRSE'],
      '048'=>['name'=>'신협은행', 'siwft'=>''],
      '005'=>['name'=>'외환은행', 'siwft'=>'KEOXKRSE'],
      '020'=>['name'=>'우리은행', 'siwft'=>'HVBKKRSEXXX'],
      '071'=>['name'=>'우체국은행', 'siwft'=>'SHBKKRSEPO'],
      '037'=>['name'=>'전북은행', 'siwft'=>'JEONKRSE'],
      '035'=>['name'=>'제주은행', 'siwft'=>'JJBKKR22'],
      '090'=>['name'=>'카카오뱅크', 'siwft'=>'CITIKRSXKAK'],
      '089'=>['name'=>'케이뱅크', 'siwft'=>''],
      '092'=>['name'=>'토스뱅크', 'siwft'=>''],
      '081'=>['name'=>'하나은행', 'siwft'=>'HNBNKRSE'],
      '023'=>['name'=>'SC제일은행', 'siwft'=>'SCBLKRSE']
      ];
  
      DB::table('json_key_values')->updateOrInsert(
        ['key' => 'banks'],['v' => json_encode($banks)]
      );
    }


      $sms = [
        'vendor' => 'smsto',
        'key' => 'ADFAFAF',
        'id' => 'ASDFADFADF',
        'sender' => 'ADFADFA',
        'manager_rec_order' => true,
      ];

      DB::table('json_key_values')->updateOrInsert(
        ['key' => 'sms'],['v' => json_encode($sms)]
      );

      $payment = [
        'pg' => 'kcp',
        'mid' => 'T0000',
        'sitekey' => '3grptw1.zW0GSo4PQdaGvsF__',
        'submit_url' => 'https://testpay.kcp.co.kr/plugin/payplus_web.jsp',
        'service'=>false,
        'naver'=>false,
        'kakao'=>false
      ];

      DB::table('json_key_values')->updateOrInsert(
        ['key' => 'payment'],['v' => json_encode($payment)]
      );

      $delivery = [
        'fee' => 0,
        'type' => 'none',
        'min' => 0
      ];

      DB::table('json_key_values')->updateOrInsert(
        ['key' => 'market.delivery'],['v' => json_encode($delivery)]
      );
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {   
  }
}
