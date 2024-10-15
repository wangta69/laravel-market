<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>주문확인메일</title>
  </head>
  <body>

    <div style="width: 680px;padding: 35px;border: 1px solid #0000002d;">
      <div style="border-bottom: 3px solid #0000002d;padding-bottom: 5px; font-size: 20px;">
        <a href="{{ config('app.url') }}" target="_blank" rel="noreferrer noopener" style="text-decoration: none;color: inherit;">{{ config('app.name') }}</a>
      </div>

      <div style="padding: 20px 5px;">
         {{$user->name}}님, {{config('app.name')}}에서 주문하신 구매내역을 안내해 드립니다.<br>
      </div>


      <div style="padding: 20px;">
        <div style="display: flex;justify-content: space-between;align-items: center;">
          <h3>구매정보</h3>
          <a href="">배송정보</a>
        </div>
        <table style="width: 100%;">
          <tr style="background-color: #f3f2f2;">
              <td style="padding: 10px; text-align: center;">구매상품</td>
              <td style="padding: 10px; text-align: center;">가격</td>
              <td style="padding: 10px; text-align: center;">수량</td>
              <td style="padding: 10px; text-align: center;">구매금액</td>
            </tr>
          @foreach($data->items as $item)
            <tr>
              <td style="padding: 10px; border-bottom: 2px solid #f3f2f2;">{{$item->name}}
              @if(isset($item->displayOptions))
                <br>
                @foreach($item->displayOptions as $option)
                  {{$option[1]}} : {{$option[2]}} @if($option[3]) ({{number_format($option[3])}} 원 추가) @endif<br>
                @endforeach
              @endif
              </td>
              <td style="padding: 10px; text-align: right; border-bottom: 2px solid #f3f2f2;">{{number_format($item->item_price)}}</td>
              <td style="padding: 10px; text-align: right; border-bottom: 2px solid #f3f2f2;">{{number_format($item->qty)}}</td>
              <td style="padding: 10px; text-align: right; border-bottom: 2px solid #f3f2f2;">{{number_format(($item->item_price + $item->option_price) * $item->qty)}}</td>
            </tr>
          @endforeach
        </table>
      </div>


      <div style="padding: 20px;">
        <h3>받는사람 정보</h3>
          {{$data->display->name}} / 
          Tel: {{addHypenToMobile($data->display->tel1)}} /  
          ({{$data->display->zip}}) {{$data->display->addr1}}  {{$data->display->addr2}}
      </div>


      <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #cccccc;color: #aaa; font-size: 11px;">
        {{config('market.company.name')}} / 
        사업번호 : {{config('market.company.businessNumber')}} / 
        대표 : {{config('market.company.representative')}}<br>
        주소 : {{config('market.company.address')}}
      </div>

    </div>
  <!-- Body End -->


  </body>
</html>