<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>공지메일</title>
</head>
<body>
  <!-- 네이버 웹메일의 경우 모든 것은 없애고 body 안의 내용만 가져와서 처리한다. -->
<!-- Body Start -->


<div style="width: 680px;padding: 35px;font-size: 12px;font-family: dotum;line-height: 20px;border: 1px solid #2e65a7;">
  <div style="border-bottom: 3px solid #2e65a7;padding-bottom: 5px; font-size: 20px;">
    <a href="http://www.phpschool.com" target="_blank" rel="noreferrer noopener">{{ config('app.name') }}</a>
    </div>
  <div style="padding: 20px 5px;">
    안녕하세요. {{$mailData->user->name}} 님 <br>
  </div>
  <div style="border: 4px solid #f2f2f2;padding: 20px 10px;font-weight: bold; margin-bottom:30px;">
    {{$mailData->subject}}
  </div>

  <div style="padding: 20px;">
  {{$mailData->message}}
  </div>



  <div style="clear: both;border-top: 1px solid #000000;padding: 10px;border-bottom: 1px solid #cccccc; color: #aaa; font-size: 11px;">
  {{config('pondol-market.company.name')}} / 사업번호 : {{config('pondol-market.company.businessNumber')}} / 대표 : {{config('pondol-market.company.representative')}}<br>
    주소 : {{config('pondol-market.company.address')}}
  </div>
  <div style="padding: 10px;color: #959595;line-height: 15px;font-size: 11px;">
    본 메일은 2024년 09월 20일 이전에 회원님의 광고이메일 수신동의 여부를 확인한 결과 수신을 동의하였기에 발송되었습니다.<br>
    수신을 원치 않으시면 <a href="" target="_blank" rel="noreferrer noopener">[여기]</a>를 클릭하여 주시기 바랍니다. To unsubscribe this e-mail, 
    <a href="" target="_blank" rel="noreferrer noopener">[click here]</a><br>
    본 메일은 발신전용으로 회신을 통한 문의는 처리되지 않습니다.
  </div>
</div>
<!-- Body End -->
</body>
</html>
