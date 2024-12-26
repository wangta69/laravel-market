<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>공지메일</title>
  </head>
  <body>
    <!-- 네이버 웹메일의 경우 모든 것은 없애고 body 안의 내용만 가져와서 처리한다. -->
  <!-- Body Start -->


    <div style="width: 680px;padding: 35px;font-size: 12px;font-family: dotum;line-height: 20px;border: 1px solid #0000002d;">
      <div style="border-bottom: 3px solid #0000002d;padding-bottom: 5px; font-size: 20px;">
        <a href="{{ config('app.url') }}" target="_blank" rel="noreferrer noopener" style="text-decoration: none;color: inherit;">{{ config('app.name') }}</a>
      </div>

      <div style="padding: 20px 5px;">
        안녕하세요. {{$mailData->user->name}} 님 <br>
      </div>

      <div style="padding: 20px;">
        {!! nl2br($mailData->message) !!}
      </div>

      <x-market-mail-footer/>

    </div>
  <!-- Body End -->
  </body>
</html>
