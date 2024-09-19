@extends('market.templates.layouts.'.config('market.template.layout.theme').'.front')
@section('title', '상품구매')
@section('content')
<div class="container body">
  <h2 class="title mt-5">주문 / 결제</h2>

  <div class="card">
    <div class="card-header">
      주문 상품
    </div>
    <div class="card-body">
      <table class="table items">
        <tr>
          <th></th>
          <th></th>
          <th>갯수</th>
          <th>금액</th>
          <th></th>
        </tr>
          @forelse ($items as $item)
          <tr>
            <td>
            <img src="{{market_get_thumb($item->image, 100, 100)}}" class="img-thumbnail">
            </td>
            <td>
              {{$item->name}} <br>
              @if($item->model) {{$item->model}} <br> @endif
              {{number_format($item->price)}} 원 <br>

              @if(isset($item->displayOptions))
                @foreach($item->displayOptions as $option)
                  {{$option[1]}} : {{$option[2]}} @if($option[3]) ({{number_format($option[3])}} 원 추가) @endif<br>
                @endforeach
              @endif
            </td>
            <td>
              {{number_format($item->qty)}}
            </td>
            <td>
              {{number_format(($item->item_price + $item->option_price) * $item->qty)}}
            </td>
            <td>
              <a href="{{ route('market.item', [$item->id]) }}" class="btn">보기</a>
            </td>
          </tr>
          @empty
          <tr>
            <td>
              주문상품이 없습니다.
            </td>
          </tr>
          @endforelse
      </table>
    </div><!-- .card-body -->
  </div><!-- .card -->

  <form method="POST" action="{{ route('market.order') }}" name='order-form' onsubmit='return saveOrder(this);'>
    @csrf
    <!-- <input type="hidden" name="delivery_fee" value="{{$display->delivery_fee}}"> -->
    <div class="card mt-2">
      <div class="card-header">
      배송지 정보
      </div>
      <div class="card-body">
        <div class="row">
          <label for="name" class="col-sm-3 col-form-label">받을 분 성함</label>
          <div class="col-sm-9">
            <input type="text" name="name" class="form-control" value="{{$buyer->name ?? ''}}">
          </div>
        </div>
      
        <div class="row mt-1">
          <label for="" class="col-sm-3 col-form-label">배송지주소</label>
          <div class="col-sm-9">
            <div class="input-group">
              <input name="zip" type="text"  maxlength="5" value="{{$buyer->zip ?? ''}}"  readonly="readonly" class="form-control">
              <button type="button" class="btn btn-primary" onclick="search_zip('order-form', 'zip', 'addr1', 'addr2');">
                <i class="fa fa-search" aria-hidden="true"></i>
                <span>우편번호찾기</span>
              </button>
              <button type="button" class="btn btn-warning act-latest-address" >
                <i class="fa-solid fa-list"></i>
                <span>배송지변경</span>
              </button>
              
            </div>
            
            <input name="addr1" type="text"  value="{{$buyer->addr1 ?? ''}}" readonly="readonly" class="mt-1 form-control">
            <input name="addr2" type="text"  value="{{$buyer->addr2 ?? ''}}" class="mt-1 form-control" placeholder="상세주소">
          </div>
        </div>

        <div class="row mt-1">
          <label for="" class="col-sm-3 col-form-label">받을 분 연락처</label>
          <div class="col-sm-9">
            <div class="input-group">
              <input type="text" name="tel1" value="{{$buyer->tel1 ? addHypenToMobile($buyer->tel1) : ''}}" class="form-control" onkeyup="this.value = add_phone_hyphen(this.value)">

            </div>
          </div>
        </div>

        <div class="row mt-1">
          <label class="col-sm-3 col-form-label">배송메세지</label>
          <div class="col-sm-9">
            <textarea name="message" class="form-control" placeholder="배송메세지란에는 배송시 참고할 사항이 있으면 적어주세요">{{$buyer->message ?? ''}}</textarea>
          </div>
        </div>
      </div> <!-- .card-body -->
    </div> <!-- .card -->

    <div class="card mt-2">
      <div class="card-header">
      결제 정보
      </div>
      <div class="card-body">
        <div class="payment">
          <div class="row mt-1">
            <label class="col-sm-3 col-form-label">물품금액</label>
            <label class="col-sm-9 col-form-label">{{number_format($display->totalPrice)}} 원</label>
          </div>
          
          <div class="row mt-1">
            <label class="col-sm-3 col-form-label">배송비</label>
            <label class="col-sm-9 col-form-label">{{number_format($display->delivery_fee)}} 원</label>
          </div>


          <!-- 포인트 결재 시작 -->
          <div class="row mt-1">
            <label class="col-sm-3 col-form-label">보유 포인트</label>
            <label class="col-sm-9 col-form-label">{{number_format($display->user_point)}} 원</label>
          </div>

          <div class="row mt-1">
            <label class="col-sm-3 col-form-label">사용 포인트</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input value='{{$display->user_point}}' type="number" name='pointamount' size=10 onkeyup='paycalculate();'  class="form-control"/>
                <span class="input-group-text">원</span>
              </div>
            </div>
          </div>


          <div class="row mt-1">
            <label class="col-sm-3 col-form-label">최종결제 금액</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input type="text" name='total' readonly value='' class="form-control">
                <span class="input-group-text">원</span>
              </div>
            </div>
          </div>

          <div class="row mt-1">
            <label class="col-sm-3 form-check-label">결제방식</label>
            <div class="col-sm-9">
              <input name="paytype" class="form-check-input" type="radio" value="online" checked="checked" onClick="selectPayType()"/>
                  무통장 입금
              <input name="paytype" class="form-check-input" type="radio" value="card" onClick="selectPayType()"/>
              신용카드
            </div>
          </div>

          <div class="paytype-online">
            <div class="row mt-1">
              <label class="col-sm-3 col-form-label">입금은행</label>
              <div class="col-sm-9">
                <select name='bank' class="form-select">
                  <option value="">입금계좌선택</option>
                  @forelse($banks as $v)
                  <option value="{{$v->id}}">{{$v->name}} {{$v->no}}(소유주: {{$v->owner}})</option>
                  @empty
                  <option>무통장 입금 계좌가 등록되지 않았습니다.</option>
                  @endforelse
                </select>
              </div>
            </div>
            
            <div class="row mt-1">
              <label class="col-sm-3 col-form-label">입금자명</label>
              <div class="col-sm-9">
                <input name="inputer" type="text" value="" class="form-control">
              </div>
            </div>
          </div><!-- .paytype-online -->
        </div>
      </div> <!-- .card-body -->
      <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" >결제하기</button>	<!-- 결제하기누르면 현재 정보를 저장하고 결제창을 활성화 시키고 결제가 정상적으로 이루어지면 결제 완료창으로 넘긴다 -->	
      </div>
    </div> <!-- .card -->
  </form>
</div>



<div class="modal fade" id="latestAddressModal" tabindex="-1" aria-labelledby="latestAddressModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="latestAddressModalLabel">배송지</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      @forelse ($addresses as $addr)
        <div class="d-flex mt-2 ">
          <div class="flex-grow-1">(<span class="addr-zip">{{$addr->zip}}</span>) <span class="addr-addr1">{{$addr->addr1}}</span> <span class="addr-addr2">{{$addr->addr2}}</span> <br>
          <i class="fa-solid fa-square-phone"></i> <span class="addr-tel1">{{addHypenToMobile($addr->tel1)}}</span> </div>
          <button class="btn btn-primary btn-sm act-set-address" style="width: 60px;">선택</button>
        </div>
      @empty
        <div>최근 배송지 정보가 없습니다.</div>
      @endforelse

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addressCreateModal">배송지추가</button>
      </div>
    </div>
  </div>
</div>
{{ Config::get('market.payment.pg') }}
<!-- Modal for create address start -->

@include('market.templates.userpage.default.address.create-modal')

<!-- Modal for create address end -->
<!-- /banner-feature -->
 <!-- 결제 모듈 삽입 -->
@if(Config::get('market.payment.pg') == 'kcp'):
  @include('market.payment.pg.kcp.pay-form')
@elseif(Config::get('market.payment.pg') == 'lg'):
  @include('market.payment.pg.lg.pay-form')
@elseif(Config::get('market.payment.pg') == 'inicis'):
  @include('market.payment.pg.inicis.pay-form')
@endif

@if(Config::get('market.payment.kakao')):
  @include('market.payment.smart.kakaopay.pay-form')
@endif
@endsection

@section('styles')
@parent
@endsection

@section('scripts')
@parent
<!-- 
market.templates.userpage.default.address.create-modal 에 포함되어 있으므로 주석처리(만약 위의 것이 없으면 주석 해제 하고 처리)
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
  -->

<script>
var point = {{$display->user_point}};
var delivery_fee = {{$display->delivery_fee}}; // 배송 금액
var totalPrice = {{$display->totalPrice}}; // 물품총 금액
var total = {{$display->totalPrice + $display->delivery_fee}} // 총 결제 금액
paycalculate();

function saveOrder(){
  MARKET.ajaxroute('post', 
    {'name': 'market.order.store.address'}, 
      $("form[name=order-form]").serialize(), 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        // 배송지가 성공적으로 저장되면 결제창을 호출합니다.
        return payMentProcessing(); 
      }
    })
  return false;	
}

// my page > order > view 로 이동
function gotoOrderView(o_id) {
  MARKET.routetostring({'name': 'market.mypage.order.view', 'params[0]': o_id},
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        location.href=resp.url;
      }
    })

}

function payMentProcessing(){
  var paytype = $("input[name='paytype']:checked").val();
  switch(paytype) {
    case 'online': // 별도 결제 없이 진행
      MARKET.ajaxroute('post', 
        {'name': 'market.order.store.payment'}, 
        $("form[name=order-form]").serialize(), 
        function(resp) {
          if(resp.error) {
            showToaster({title: '알림', message: resp.error});
          } else {
            gotoOrderView(resp.o_id);
          }
        })
      break;
    case 'card':
      preparePayment();
      break;
  }
  return false;
}

/**
 * 결제 방식 선택
 */
function selectPayType(){
  var paytype = $("input[name='paytype']:checked").val();
  if(paytype == "online"){
    $(".paytype-online").show();
  } else {
    $(".paytype-online").hide();
  }
}

function paycalculate() {
  var pointamount = $("input[name='pointamount']").val();
  if(pointamount > point) {
    $("input[name='pointamount']").val(0)
  }
  var finalPrice = totalPrice + delivery_fee - pointamount;

  $("input[name='total']").val(add_comma(finalPrice));
}

{{-- 
  // 추후 결제 방식 추가하면서 다시 볼것

function forderform_check(f)
{

  @if($default['de_pg_service'] == 'inicis'):
  if( f.action != form_action_url ){
    f.action = form_action_url;
    f.removeAttribute("target");
    f.removeAttribute("accept-charset");
  }
  @endif

  // 카카오페이 지불
  if(settle_method == "KAKAOPAY") {
    @if($default['de_tax_flag_use']):
    f.SupplyAmt.value = parseInt(f.comm_tax_mny.value) + parseInt(f.comm_free_mny.value);
    f.GoodsVat.value  = parseInt(f.comm_vat_mny.value);
    @endif
    getTxnId(f);
    return false;
  }

  // pay_method 설정
  @if($default['de_pg_service'] == 'kcp'):
    f.site_cd.value = f.def_site_cd.value;
    f.payco_direct.value = "";
    switch(settle_method)
    {
    case "계좌이체":
      f.pay_method.value   = "010000000000";
      break;
    case "가상계좌":
      f.pay_method.value   = "001000000000";
      break;
    case "휴대폰":
      f.pay_method.value   = "000010000000";
      break;
    case "신용카드":
      f.pay_method.value   = "100000000000";
      break;
    case "간편결제":
      @if($default['de_card_test']):
      f.site_cd.value      = "S6729";
      @endif
      f.pay_method.value   = "100000000000";
      f.payco_direct.value = "Y";
      break;
    default:
      f.pay_method.value   = "무통장";
      break;
    }
  @elseif($default['de_pg_service'] == 'lg'):
  f.LGD_EASYPAY_ONLY.value = "";
  if(typeof f.LGD_CUSTOM_USABLEPAY === "undefined") {
    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", "LGD_CUSTOM_USABLEPAY");
    input.setAttribute("value", "");
    f.LGD_EASYPAY_ONLY.parentNode.insertBefore(input, f.LGD_EASYPAY_ONLY);
  }

  switch(settle_method)
  {
    case "계좌이체":
      f.LGD_CUSTOM_FIRSTPAY.value = "SC0030";
      f.LGD_CUSTOM_USABLEPAY.value = "SC0030";
      break;
    case "가상계좌":
      f.LGD_CUSTOM_FIRSTPAY.value = "SC0040";
      f.LGD_CUSTOM_USABLEPAY.value = "SC0040";
      break;
    case "휴대폰":
      f.LGD_CUSTOM_FIRSTPAY.value = "SC0060";
      f.LGD_CUSTOM_USABLEPAY.value = "SC0060";
      break;
    case "신용카드":
      f.LGD_CUSTOM_FIRSTPAY.value = "SC0010";
      f.LGD_CUSTOM_USABLEPAY.value = "SC0010";
      break;
    case "간편결제":
      var elm = f.LGD_CUSTOM_USABLEPAY;
      if(elm.parentNode)
        elm.parentNode.removeChild(elm);
      f.LGD_EASYPAY_ONLY.value = "PAYNOW";
      break;
    default:
      f.LGD_CUSTOM_FIRSTPAY.value = "무통장";
      break;
  }
  @elseif($default['de_pg_service'] == 'inicis'):
  switch(settle_method)
  {
    case "계좌이체":
      f.gopaymethod.value = "DirectBank";
      break;
    case "가상계좌":
      f.gopaymethod.value = "VBank";
      break;
    case "휴대폰":
      f.gopaymethod.value = "HPP";
      break;
    case "신용카드":
      f.gopaymethod.value = "Card";
      f.acceptmethod.value = f.acceptmethod.value.replace(":useescrow", "");
      break;
    case "간편결제":
      f.gopaymethod.value = "Kpay";
      break;
    default:
      f.gopaymethod.value = "무통장";
      break;
  }
  @elseif($default['de_pg_service'] == 'kcp'):
    f.buyr_name.value = f.od_name.value;
    f.buyr_mail.value = f.od_email.value;
    f.buyr_tel1.value = f.od_tel.value;
    f.buyr_tel2.value = f.od_hp.value;
    f.rcvr_name.value = f.od_b_name.value;
    f.rcvr_tel1.value = f.od_b_tel.value;
    f.rcvr_tel2.value = f.od_b_hp.value;
    f.rcvr_mail.value = f.od_email.value;
    f.rcvr_zipx.value = f.od_b_zip.value;
    f.rcvr_add1.value = f.od_b_addr1.value;
    f.rcvr_add2.value = f.od_b_addr2.value;

    if(f.pay_method.value != "무통장") {
        jsf__pay( f );
    } else {
        f.submit();
    }
  @elseif($default['de_pg_service'] == 'lg'):
    f.LGD_BUYER.value = f.od_name.value;
    f.LGD_BUYEREMAIL.value = f.od_email.value;
    f.LGD_BUYERPHONE.value = f.od_hp.value;
    f.LGD_AMOUNT.value = f.good_mny.value;
    f.LGD_RECEIVER.value = f.od_b_name.value;
    f.LGD_RECEIVERPHONE.value = f.od_b_hp.value;
    <?php if($default['de_escrow_use']) { ?>
    f.LGD_ESCROW_ZIPCODE.value = f.od_b_zip.value;
    f.LGD_ESCROW_ADDRESS1.value = f.od_b_addr1.value;
    f.LGD_ESCROW_ADDRESS2.value = f.od_b_addr2.value;
    f.LGD_ESCROW_BUYERPHONE.value = f.od_hp.value;
    <?php } ?>
    <?php if($default['de_tax_flag_use']) { ?>
    f.LGD_TAXFREEAMOUNT.value = f.comm_free_mny.value;
    <?php } ?>

    if(f.LGD_CUSTOM_FIRSTPAY.value != "무통장") {
        launchCrossPlatform(f);
    } else {
        f.submit();
    }
  @elseif($default['de_pg_service'] == 'inicis'):
    f.price.value       = f.good_mny.value;
    <?php if($default['de_tax_flag_use']) { ?>
    f.tax.value         = f.comm_vat_mny.value;
    f.taxfree.value     = f.comm_free_mny.value;
    <?php } ?>
    f.buyername.value   = f.od_name.value;
    f.buyeremail.value  = f.od_email.value;
    f.buyertel.value    = f.od_hp.value ? f.od_hp.value : f.od_tel.value;
    f.recvname.value    = f.od_b_name.value;
    f.recvtel.value     = f.od_b_hp.value ? f.od_b_hp.value : f.od_b_tel.value;
    f.recvpostnum.value = f.od_b_zip.value;
    f.recvaddr.value    = f.od_b_addr1.value + " " +f.od_b_addr2.value;

    if(f.gopaymethod.value != "무통장") {
        // 주문정보 임시저장
        var order_data = $(f).serialize();
        var save_result = "";
        $.ajax({
            type: "POST",
            data: order_data,
            url: g5_url+"/shop/ajax.orderdatasave.php",
            cache: false,
            async: false,
            success: function(data) {
                save_result = data;
            }
        });

        if(save_result) {
            alert(save_result);
            return false;
        }

        if(!make_signature(f))
            return false;

        paybtn(f);
    } else {
        f.submit();
    }
  @endif
}

--}}

$(function(){
  // 배송지 변경 창 open
  $('.act-latest-address').on('click', function(){
    $('#latestAddressModal').modal('show')
  })

  // 선택된 배송지로 변경
  $(".act-set-address").on('click', function(){
    $parent = $(this).parent();
    var zip = $parent.find('.addr-zip').eq(0).html();
    var addr1 = $parent.find('.addr-addr1').eq(0).html();
    var addr2 = $parent.find('.addr-addr2').eq(0).html();
    var tel1 = $parent.find('.addr-tel1').eq(0).html();


    var orderform = $('form[name=order-form]');
    $("input[name=zip]", orderform).val(zip);
    $("input[name=addr1]", orderform).val(addr1);
    $("input[name=addr2]", orderform).val(addr2);
    $("input[name=tel1]", orderform).val(tel1);

    $('#latestAddressModal').modal('hide')
  });
})
</script>
@endsection
