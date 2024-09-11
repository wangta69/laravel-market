
@php
$CNSPAY_WEB_SERVER_URL = 'https://kmpay.lgcns.com:8443';
$targetUrl = 'https://kmpay.lgcns.com:8443';
$msgName = '/merchant/requestDealApprove.dev';
$CnsPayDealRequestUrl = 'https://pg.cnspay.co.kr:443';
@endphp
<div id="kakaopay_request">
<input type="hidden" name="merchantTxnNum" value=""> <!-- od_id -->
<input type="hidden" name="GoodsName"      value=""> <!-- 상품명 -->
<input type="hidden" name="Amt"            value=""> <!-- 총금액 -->
<input type="hidden" name="GoodsCnt"       value=""> <!-- 제품 수량 -->
<input type="hidden" name="BuyerEmail"     value="">
<input type="hidden" name="BuyerName"      value="">
<input type="hidden" name="prType"         value="WPM"> <!-- mobile : MPM, web : WPM -->
<input type="hidden" name="channelType"    value="4">
<input type="hidden" name="TransType"      value="0">
<input type="hidden" name="resultCode"     value="" id="resultCode">
<input type="hidden" name="resultMsg"      value="" id="resultMsg">
<input type="hidden" name="txnId"          value="" id="txnId">
<input type="hidden" name="prDt"           value="" id="prDt">
<input type="hidden" name="SPU"            value="">
<input type="hidden" name="SPU_SIGN_TOKEN" value="">
<input type="hidden" name="MPAY_PUB"       value="">
<input type="hidden" name="NON_REP_TOKEN"  value="">
<input type="hidden" name="EdiDate"        value=""> <!--  ediDate -->
<input type="hidden" name="EncryptData"    value="">
{{-- // tax 사용시
<input type="hidden" name="SupplyAmt"     value="">
<input type="hidden" name="GoodsVat"      value="">
<input type="hidden" name="ServiceAmt"    value="0">
--}}
</div>


@section('scripts')
@parent
<script src="{{$CnsPayDealRequestUrl}}/dlp/scripts/lib/easyXDM.min.js" type="text/javascript"></script>
<script src="{{$CnsPayDealRequestUrl}}/dlp/scripts/lib/json3.min.js" type="text/javascript"></script>

<link href="https://pg.cnspay.co.kr:443/dlp/css/kakaopayDlp.css" rel="stylesheet" type="text/css" />

<!-- DLP창에 대한 KaKaoPay Library -->
<script type="text/javascript" src="{{$CNSPAY_WEB_SERVER_URL}}/js/dlp/client/kakaopayDlpConf.js" charset="utf-8"></script>
<script type="text/javascript" src="{{$CNSPAY_WEB_SERVER_URL}}/js/dlp/client/kakaopayDlp.min.js" charset="utf-8"></script>

<script>

	/**
	cnspay	를 통해 결제를 시작합니다.
	*/
	function cnspay(frm) {
    if(document.getElementById("od_settle_kakaopay").checked){
    // TO-DO : 가맹점에서 해줘야할 부분(TXN_ID)과 KaKaoPay DLP 호출 API
        // 결과코드가 00(정상처리되었습니다.)
    if(frm.resultCode.value == '00') {
      // TO-DO : 가맹점에서 해줘야할 부분(TXN_ID)과 KaKaoPay DLP 호출 API
      kakaopayDlp.setTxnId(frm.txnId.value);
      kakaopayDlp.setChannelType('WPM', 'TMS');
      kakaopayDlp.addRequestParams({ MOBILE_NUM : frm.od_hp.value});
      kakaopayDlp.callDlp('kakaopay_layer', frm, submitFunc);
    } else {
      alert('[RESULT_CODE] : ' + frm.resultCode.value + '\n[RESULT_MSG] : ' + frm.resultMsg.value);
    }
  }
	}

  function makeHashData(frm) {
    var result = true;

    $.ajax({
      url: "/shop/kakaopay/makehashdata.php",
      type: "POST",
      data: {
        Amt : frm.good_mny.value,
        ediDate : frm.EdiDate.value
      },
      dataType: "json",
      async: false,
      cache: false,
      success: function(data) {
        if(data.error == "") {
          frm.EncryptData.value = data.hash_String;
        } else {
          alert(data.error);
          result = false;
        }
      }
    });

    return result;
  }

	function getTxnId(frm) {
    if(makeHashData(frm)) {
      frm.Amt.value = frm.good_mny.value;
      frm.BuyerEmail.value = frm.od_email.value;
      frm.BuyerName.value = frm.od_name.value;

      $.ajax({
        url: "/shop/kakaopay/getTxnId.php",
        type: "POST",
        data: $("#kakaopay_request input").serialize(),
        dataType: "json",
        async: false,
        cache: false,
        success: function(data) {
          frm.resultCode.value = data.resultCode;
          frm.resultMsg.value = data.resultMsg;
          frm.txnId.value = data.txnId;
          frm.prDt.value = data.prDt;

          cnspay(frm);
        },
        error: function(data) {
          console.log(data);
        }
      });
    }
	}

	var submitFunc = function cnspaySubmit(data){

    if(data.RESULT_CODE === '00') {

        // 부인방지토큰은 기본적으로 name="NON_REP_TOKEN"인 input박스에 들어가게 되며, 아래와 같은 방법으로 꺼내서 쓸 수도 있다.
        // 해당값은 가군인증을 위해 돌려주는 값으로서, 가맹점과 카카오페이 양측에서 저장하고 있어야 한다.
        // var temp = data.NON_REP_TOKEN;

        document.forderform.submit();
    } else if(data.RESLUT_CODE === 'KKP_SER_002') {
      // X버튼 눌렀을때의 이벤트 처리 코드 등록
      alert('[RESULT_CODE] : ' + data.RESULT_CODE + '\n[RESULT_MSG] : ' + data.RESULT_MSG);
    } else {
      alert('[RESULT_CODE] : ' + data.RESULT_CODE + '\n[RESULT_MSG] : ' + data.RESULT_MSG);
    }
	};

/* Payplus Plug-in 실행 */
function preparePaymentforkakaopay()
{
  var f = document.forms['payment-form']
}
</script>
@endsection
