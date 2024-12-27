@php
$service = jsonval('payment', 'service');
$CST_MID = jsonval('payment', 'mid');
if ($service) {
  $CST_PLATFORM = "service";
  $LGD_MID = $CST_MID;
} else {
  $CST_PLATFORM = "test";
  $LGD_MID = 't'.$CST_MID;
}


$LGD_WINDOW_TYPE = 'iframe'; // iframe | submit
$LGD_WINDOW_VER = 2.5;
$LGD_CUSTOM_SKIN = 'red';
$LGD_CUSTOM_PROCESSTYPE = 'TWOTR';
@endphp

<form name="payment-form">
<!-- <div id="LGD_PAYREQUEST"> -->
<!--
계좌이체: LGD_CUSTOM_FIRSTPAY, LGD_CUSTOM_USABLEPAY = "SC0030";
가상계좌: LGD_CUSTOM_FIRSTPAY, LGD_CUSTOM_USABLEPAY = "SC0040";
휴대폰: LGD_CUSTOM_FIRSTPAY, LGD_CUSTOM_USABLEPAY. = "SC0060";
신용카드: LGD_CUSTOM_FIRSTPAY, LGD_CUSTOM_USABLEPAY = "SC0010";
간편결제": LGD_CUSTOM_USABLEPAY 삭제, LGD_EASYPAY_ONLY = "PAYNOW";
            break;
무통장: LGD_CUSTOM_FIRSTPAY.value = "";


        -->
  <input type="hidden" name="CST_PLATFORM"                id="CST_PLATFORM"       value="{{ $CST_PLATFORM }}">      <!-- 테스트, 서비스 구분 'test' : 'service';-->
  <input type="hidden" name="CST_MID"                     id="CST_MID"            value="{{ $CST_MID }}">           <!-- 상점아이디 -->
  <input type="hidden" name="LGD_MID"                     id="LGD_MID"            value="{{ $LGD_MID }}">           <!-- 상점아이디 -->
  <input type="hidden" name="LGD_OID"                     id="LGD_OID"            value="..">             <!-- 주문번호 -->
  <input type="hidden" name="LGD_BUYER"                   id="LGD_BUYER"          value="">                                  <!-- 구매자 -->
  <input type="hidden" name="LGD_PRODUCTINFO"             id="LGD_PRODUCTINFO"    value="..">             <!-- 상품정보 -->
  <input type="hidden" name="LGD_AMOUNT"                  id="LGD_AMOUNT"         value="">                                  <!-- 결제금액 -->
  <input type="hidden" name="LGD_CUSTOM_FIRSTPAY"         id="LGD_CUSTOM_FIRSTPAY" value="SC0010">                                 <!-- 결제수단 -->
  <input type="hidden" name="LGD_BUYEREMAIL"              id="LGD_BUYEREMAIL"     value="">                                  <!-- 구매자 이메일 -->
  <input type="hidden" name="LGD_CUSTOM_SKIN"             id="LGD_CUSTOM_SKIN"    value="{{ $LGD_CUSTOM_SKIN }}">   <!-- 결제창 SKIN -->
  <input type="hidden" name="LGD_WINDOW_VER"              id="LGD_WINDOW_VER"     value="{{ $LGD_WINDOW_VER }}">    <!-- 결제창버전정보 (삭제하지 마세요) -->
  <input type="hidden" name="LGD_CUSTOM_PROCESSTYPE"      id="LGD_CUSTOM_PROCESSTYPE" value="{{ $LGD_CUSTOM_PROCESSTYPE }}">         <!-- 트랜잭션 처리방식 -->
  <input type="hidden" name="LGD_TIMESTAMP"               id="LGD_TIMESTAMP"      value="..">     <!-- 타임스탬프 -->
  <input type="hidden" name="LGD_HASHDATA"                id="LGD_HASHDATA"       value="">                                  <!-- MD5 해쉬암호값 -->
  <input type="hidden" name="LGD_PAYKEY"                  id="LGD_PAYKEY">                                                   <!-- LG유플러스 PAYKEY(인증후 자동셋팅)-->
  <input type="hidden" name="LGD_VERSION"                 id="LGD_VERSION"        value="..">       <!-- 버전정보 (삭제하지 마세요) -->
  <input type="hidden" name="LGD_TAXFREEAMOUNT"           id="LGD_TAXFREEAMOUNT"  value="..">     <!-- 결제금액 중 면세금액 -->
  <input type="hidden" name="LGD_BUYERIP"                 id="LGD_BUYERIP"        value="..">       <!-- 구매자IP -->
  <input type="hidden" name="LGD_BUYERID"                 id="LGD_BUYERID"        value="..">       <!-- 구매자ID -->
  <input type="hidden" name="LGD_CUSTOM_USABLEPAY"        id="LGD_CUSTOM_USABLEPAY"   value="SC0010">   <!-- 결제가능수단 -->
  <input type="hidden" name="LGD_CASHRECEIPTYN"           id="LGD_CASHRECEIPTYN"  value="N">                                 <!-- 현금영수증 사용 설정 -->
  <input type="hidden" name="LGD_BUYERADDRESS"            id="LGD_BUYERADDRESS"   value="">                                  <!-- 구매자 주소 -->
  <input type="hidden" name="LGD_BUYERPHONE"              id="LGD_BUYERPHONE"     value="">                                  <!-- 구매자 휴대폰번호 -->
  <input type="hidden" name="LGD_RECEIVER"                id="LGD_RECEIVER"       value="">                                  <!-- 수취인 -->
  <input type="hidden" name="LGD_RECEIVERPHONE"           id="LGD_RECEIVERPHONE"  value="">                                  <!-- 수취인 휴대폰번호 -->
  <input type="hidden" name="LGD_EASYPAY_ONLY"            id="LGD_EASYPAY_ONLY"   value="">                                  <!-- 페이나우 결제 호출 -->

  {{-- 에스크로 사용시
  <input type="hidden" name="LGD_ESCROW_ZIPCODE"          id="LGD_ESCROW_ZIPCODE" value="">                                  <!-- 에스크로배송지우편번호 -->
  <input type="hidden" name="LGD_ESCROW_ADDRESS1"         id="LGD_ESCROW_ADDRESS1" value="">                                 <!-- 에스크로배송지우편번호 -->
  <input type="hidden" name="LGD_ESCROW_ADDRESS2"         id="LGD_ESCROW_ADDRESS2" value="">                                 <!-- 에스크로배송지주소동까지 -->
  <input type="hidden" name="LGD_ESCROW_BUYERPHONE"       id="LGD_ESCROW_BUYERPHONE" value="">                               <!-- 에스크로배송지주소상세 -->
  --}}

  <!-- 가상계좌(무통장) 결제연동을 하시는 경우  할당/입금 결과를 통보받기 위해 반드시 LGD_CASNOTEURL 정보를 LG 유플러스에 전송해야 합니다 . -->
  <input type="hidden" name="LGD_CASNOTEURL"              id="LGD_CASNOTEURL"     value="..">     <!-- 가상계좌 NOTEURL -->

  <input type="hidden" name="LGD_RETURNURL"               id="LGD_RETURNURL"      value="..">     <!-- 응답수신페이지 -->

  <input type="hidden" name="LGD_ENCODING"                id="LGD_ENCODING"       value="UTF-8">
  <input type="hidden" name="LGD_ENCODING_RETURNURL"      id="LGD_ENCODING_RETURNURL" value="UTF-8">


  <!-- <input type="hidden" name="good_mny"    value=""> -->

  {{-- tax 사용시
  <input type="hidden" name="comm_tax_mny"	  value="..">         <!-- 과세금액    -->
  <input type="hidden" name="comm_vat_mny"      value="..">         <!-- 부가세	    -->
  <input type="hidden" name="comm_free_mny"     value="..">        <!-- 비과세 금액 -->
  --}}

</form>

@section('scripts')
@parent
<script src="//xpay.uplus.co.kr/xpay/js/xpay_crossplatform.js"></script>
<script>

  /*
* 수정불가.
*/
var LGD_window_type = "{{ $LGD_WINDOW_TYPE }}";

/*
* 수정불가
*/
function launchCrossPlatform(frm) {
  ROUTE.ajaxroute('post', 
    {route: 'market.pay.lg.hashdata', data: $("form[name=payment-form]").serializeObject()}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        frm.LGD_HASHDATA.value = resp.LGD_HASHDATA;
        lgdwin = openXpay(frm, '{{ $CST_PLATFORM }}', LGD_window_type, null, "", "");
      }
    })

  // $.ajax({
  //     url: g5_url+"/shop/lg/xpay_request.php",
  //     type: "POST",
  //     data: $("#LGD_PAYREQUEST input").serialize(),
  //     dataType: "json",
  //     async: false,
  //     cache: false,
  //     success: function(data) {
  //       frm.LGD_HASHDATA.value = data.LGD_HASHDATA;
  //       lgdwin = openXpay(frm, '{{ $CST_PLATFORM }}', LGD_window_type, null, "", "");
  //     },
  //     error: function(data) {
  //       console.log(data);
  //     }
  // });
}
/*
* FORM 명만  수정 가능
*/
function getFormObject() {
  return document.getElementById("forderform");
}

/*
 * 인증결과 처리
 */
function payment_return() {
  var fDoc;

  fDoc = lgdwin.contentWindow || lgdwin.contentDocument;

  if (fDoc.document.getElementById('LGD_RESPCODE').value == "0000") {
    document.getElementById("LGD_PAYKEY").value = fDoc.document.getElementById('LGD_PAYKEY').value;
    document.getElementById("forderform").target = "_self";
    document.getElementById("forderform").action = ""; // 결제 처리 url
    document.getElementById("forderform").submit();
  } else {
    document.getElementById("forderform").target = "_self";
    document.getElementById("forderform").action = ""; // 결제 처리  url  {{--echo $order_action_url;--}}
    alert("LGD_RESPCODE (결과코드) : " + fDoc.document.getElementById('LGD_RESPCODE').value + "\n" + "LGD_RESPMSG (결과메시지): " + fDoc.document.getElementById('LGD_RESPMSG').value);
    closeIframe();
  }
}


/* Payplus Plug-in 실행 */
function preparePayment()
{
var f = document.forms['payment-form']
// f.good_mny.value =  total;
try {
  launchCrossPlatform( f );
} catch (e){
  console.log(e);
    /* IE 에서 결제 정상종료시 throw로 스크립트 종료 */
}
}
</script>
@endsection