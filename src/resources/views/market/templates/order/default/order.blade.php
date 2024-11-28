@extends('market.templates.layouts.'.config('pondol-market.template.layout.theme').'.front')
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
                <input value='{{$display->user_point}}' type="number" name='pointamount' min='0', size=10 onkeyup='paycalculate();'  class="form-control"/>
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
<!-- Modal for create address start -->

@include('market.templates.userpage.default.address.create-modal')

<!-- Modal for create address end -->
<!-- /banner-feature -->
 <!-- 결제 모듈 삽입 -->
@if(Config::get('market.payment.pg') == 'kcp'):
  @include('market::payment.pg.kcp.pay-form')
@elseif(Config::get('market.payment.pg') == 'lg'):
  @include('market::payment.pg.lg.pay-form')
@elseif(Config::get('market.payment.pg') == 'inicis'):
  @include('market::payment.pg.inicis.pay-form')
@endif

@if(Config::get('market.payment.kakao')):
  @include('market::payment.smart.kakaopay.pay-form')
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
  ROUTE.ajaxroute('post', 
    {route: 'market.order.store.address', data: $("form[name=order-form]").serialize()}, 
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
  ROUTE.routetostring({route: 'market.mypage.order.view', segments: [o_id]},
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
      ROUTE.ajaxroute('post', 
        {route: 'market.order.store.payment', data: $("form[name=order-form]").serialize()}, 
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
