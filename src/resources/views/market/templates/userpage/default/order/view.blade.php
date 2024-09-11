@extends('market.templates.layouts.'.config('market.template.layout.theme').'.front')
@section('content')

<div class="container body">
  <div class="row">
    <div class="col-3">
      @include('market.templates.userpage.'.config('market.template.userpage.theme').'.tabs')
    </div>
    <div class="col-9">
      <div class="card mt-5">
        <div class="card-header">
        주문 내역
        </div>
        <div class="card-body">
          <table class="table items">
            <tr>
              <th><!-- 이미지 --></th>
              <th><!-- 상품명--></th> 
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
              {{number_format($item->item_price)}} 원 <br>

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
            </tr>
            @empty
            <tr>
              <td>
                검색된 상품이 없습니다.
              </td>
            </tr>
            @endforelse
          </table>
        </div> <!-- .card-body -->
        <div class="card-footer">
          <!-- 배송대기 상태에서만 취소 가틍 -->
          @if($display->delivery_status < 30)
          <button class="btn act-order-cancel">주문취소</button>
          @elseif($display->delivery_status == 50)
          주문 취소 및 환불중
          @elseif($display->delivery_status == 59)
          주문 취소 완료
          @else
          <!-- 배송중 시점에서 아래 3개가 뜲 -->
          <a class="btn" href="{{ route('market.mypage.order.cancel-return-exchange', ['return', $display->o_id]) }}">반품신청</a>
          <a class="btn" href="{{ route('market.mypage.order.cancel-return-exchange', ['exchange', $display->o_id]) }}">교환신청</a>
          <button class="btn btn-primary act-order-confirm">수취확인</button>
          @endif
        </div><!--  .card-footer -->
      </div> <!-- card -->

      <div class="card mt-4">
        <div class="card-header">
        배송지 정보
        </div>
        <div class="card-body">
          <div class="row">
            <label class="col-sm-3 col-md-2">받을 분 성함: </label>
            <div class="col-sm-9 col-md-10">{{ $display->name }}</div>
          </div>

          <div class="row">
            <label class="col-sm-3 col-md-2">배송지주소: </label>
            <div class="col-sm-9 col-md-10">
            ({{ $display->zip }})
            {{ $display->addr1 }}
            {{ $display->addr1 }}
            </div>
          </div>

          <div class="row">
            <label class="col-sm-3 col-md-2">받을 분 연락처:</label>
            <div class="col-sm-9 col-md-10">{{ $display->tel1 }}</div>
          </div>

          <div class="row">
            <label class="col-sm-3 col-md-2">배송메세지:</label>
            <div class="col-sm-9 col-md-10">
              {{ $display->message }}
            </div>
          </div>
        </div><!-- .card-body -->
      </div><!-- .card -->

      <div class="card mt-4">
        <div class="card-header">
        배송 정보
        </div>
        <div class="card-body">
          <div class="row">
            <label class="col-sm-3 col-md-2">배송상태</label>
            <div class="col-sm-9 col-md-10">
            {{ __('market.delivery_status.'.$display->delivery_status) }}
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-md-2">배송업체</label>
            <div class="col-sm-9 col-md-10">
              {{ $display->delivery_company ? $display->delivery_company->name : '' }}
            </div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-md-2">송장번호</label>
            <div class="col-sm-9 col-md-10">
              {{ $display->invoice_no }}
            </div>
          </div>           
        </div><!-- .card-body -->
      </div><!-- .card -->


      <div class="card mt-4">
        <div class="card-header">
        결제 정보
        </div>
        <div class="card-body">
          <div class="row">
            <label class="col-sm-3 col-md-2">물품금액</label>
            <div class="col-sm-9 col-md-10">{{number_format($display->amt_product)}} 원</div>
          </div>
          
          <div class="row">
            <label class="col-sm-3 col-md-2">배송비</label>
            <div class="col-sm-9 col-md-10">{{number_format($display->amt_delivery)}} 원</div>
          </div>
      
      
          <!-- 포인트 결재 시작 -->
          <div class="row">
            <label class="col-sm-3 col-md-2">포인트사용금액</label>
            <div class="col-sm-9 col-md-10">{{number_format($display->amt_point)}} 원</div>
          </div>

          <div class="row">
          <label class="col-sm-3 col-md-2">최종결제 금액</label>
            <div class="col-sm-9 col-md-10">{{number_format($display->amt_total)}} 원</div>
          </div>
                      
          <div class="row">
            <label class="col-sm-3 col-md-2">결제방식</label>
            <div class="col-sm-9 col-md-10">{{ __('market.pay_method.'.$display->method) }}</div>
          </div>

          @if(@$display->method == 'online')
          <div class="row">
            <label class="col-sm-3 col-md-2">입금은행</label>
            <div class="col-sm-9 col-md-10">{{$display->code}} {{$display->no}}(소유주: {{$display->owner}})</div>
          </div>
          <div class="row">
            <label class="col-sm-3 col-md-2">입금자명</label>
            <div class="col-sm-9 col-md-10">{{$display->inputer}}</div>
          </div>
          @endif

          <div class="row">
            <label class="col-sm-3 col-md-2">결제상태</label>
            <div class="col-sm-9 col-md-10">{{ __('market.pay_status.'.$display->pay_status) }}</div>
          </div>  
        </div><!-- .card-body -->
      </div><!-- .card -->
    </div>
  </div>
</div>
<!-- /banner-feature -->
@endsection

@section('styles')
@parent
@endsection

@section('scripts')
@parent
<script>
var changeto = null;
var o_id = '{{$display->o_id}}';
function statusChange() {
    MARKET.ajaxroute('put', 
    {'name': 'market.mypage.order.status', 'params[0]': o_id, 'params[1]': changeto}, 
      {}, 
    function(resp) {
      changeto = null;
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        showToaster({title: '알림', message: '정상적으로 변경처리 되었습니다.', alert: false});
        location.reload();
      }
    })


}

$(function(){
  
  
  
  // 주문취소
  $(".act-order-cancel").on('click', function(){
    if(confirm('주문을 취소하시겠습니까?')){
      changeto = 50;
      statusChange();
    }
  })

  // // 반품신청
  // $(".act-order-refund").on('click', function(){
  //   changeto = 60;
  //   statusChange();
  // })

  // // 교환신청
  // $(".act-order-exchange").on('click', function(){
  //   changeto = 70;
  //   statusChange();
  // })
  // 수취확인
  $(".act-order-confirm").on('click', function(){
    changeto = 90;
    statusChange();
  })
})
</script>
@endsection
