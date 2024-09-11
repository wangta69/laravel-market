@extends('market.admin.layouts.main')
@section('title', '주문내역 상세보기')
@section('content')
@include('market.admin.layouts.main-top', ['path'=>['주문/배송관리', '주문내역', '상세보기']])
<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">상세보기</h2>

  <div class="card">
    <div class="card-body">
      <div>주문의 상세내역을 확인하실 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

<div class="card mt-4">
  <div class="card-header">
  주문내역
  </div>
  <div class="card-body">
    <table class="table items">
      <tr>
        <th>이미지</th>
        <th>상품명</th>
        <th>주문수량</th>
        <th>단가</th>
        <th></th>
      </tr>
      @forelse ($items as $item)
      <tr>
        <td><img src="{{market_get_thumb($item->image, 50, 50)}}" class="img-thumbnail"></td>
        <td>{{$item->name}}@if($item->model)(모델: {{$item->model}})@endif</td>
        <td>{{number_format($item->qty)}}</td>
        <td>{{number_format($item->price)}}</td>
      </tr>
      @empty
      <tr>
        <td>
          검색된 상품이 없습니다.
        </td>
      </tr>
      @endforelse
    </table>
  </div><!-- .card-body -->
</div><!-- .card -->

<div class="card mt-4">
  <div class="card-header">
  배송지 정보
  </div>
  <div class="card-body">
    <div class="input-group mt-1">
      <label class="col-sm-3 col-md-2">받을 분 성함: </label>
      <div class="col-sm-9 col-md-10">
      {{ $display->name }}
      </div>
    </div>

    <div class="input-group mt-1">
      <label class="col-sm-3 col-md-2">배송지주소: </label>
      <div class="col-sm-9 col-md-10">
      ({{ $display->zip }})
      {{ $display->addr1 }}
      {{ $display->addr1 }}
      </div>
    </div>

    <div class="input-group mt-1">
      <label class="col-sm-3 col-md-2">받을 분 연락처</label>
      <div class="col-sm-9 col-md-10">{{ $display->tel1 }}</div>
    </div>

    <div class="input-group mt-1">
      <label class="col-sm-3 col-md-2">배송메세지</label>
      <div class="col-sm-9 col-md-10">{{ $display->message }}</div>
    </div>
  </div><!-- .card-body -->
</div><!-- .card -->

<div class="card mt-4">
  <div class="card-header">
  배송정보
  </div>
  <div class="card-body">
    <form name="delivery-form">
      <input type="hidden" name="o_id" value="{{$display->o_id}}">
      <div class="input-group mt-1">
          <label class="col-sm-3 col-md-2">배송상태</label>
          <div class="col-sm-9 col-md-10">
              <select name="delivery_status" class="form-select">
              
              @foreach($delivery_status as $k => $v)
                <option value="{{$k}}" @if($k == $display->delivery_status) selected @endif> {{$v}}</option>
                @endforeach
              </select>
          </div>
      </div>
      <div class="input-group mt-1">
          <label class="col-sm-3 col-md-2">배송업체</label>

            <select name="courier" class="form-select">
              @foreach($couriers as $c)
                <option value="{{$c->id}}" @if($c->id == $display->courier) selected @endif>{{$c->name}}</option>
              @endforeach
              </select>

      </div>
      <div class="input-group mt-1">
        <label class="col-sm-3 col-md-2">송장번호</label>
        <input type="text" name="invoice_no" value="{{ $display->invoice_no }}" class="form-control">
        <button type="button" class="btn btn-danger act-update-devery">배송정보 업데이트</button>
      </div>
    </form>




  </div><!-- .card-body -->
</div><!-- .card -->

<div class="card mt-4">
  <div class="card-header">
  결제 정보
  </div>
  <div class="card-body">
    <div class="input-group mt-1">
      <label class="col-sm-3 col-md-2">물품금액</label>
      <div class="col-sm-9 col-md-10">{{number_format($display->amt_product)}}원</div>
    </div>
      
    <div class="input-group mt-1">
      <label class="col-sm-3 col-md-2">배송비</label>
      <div class="col-sm-9 col-md-10">{{number_format($display->amt_delivery)}} 원</div>
    </div>
  
  
    <!-- 포인트 결재 시작 -->
    <div class="input-group mt-1">
      <label class="col-sm-3 col-md-2">포인트사용금액</label>
      <div class="col-sm-9 col-md-10">{{number_format($display->amt_point)}} 원</div>
    </div>


    <div class="input-group mt-1">
      <label class="col-sm-3 col-md-2">최종결제 금액</label>
      <div class="col-sm-9 col-md-10">{{number_format($display->amt_total)}} 원</div>
    </div>
                  
    <div class="input-group mt-1">
      <label class="col-sm-3 col-md-2">결제방식</label>
      <div class="col-sm-9 col-md-10">{{ __('market.pay_method.'.$display->method) }}</div>
    </div>

    @if(@$display->method == 'online')
    <div class="input-group mt-1">
      <label class="col-sm-3 col-md-2">입금은행</label>
      <div class="col-sm-9 col-md-10">{{$display->code}} {{$display->no}}(소유주: {{$display->owner}})</div>
    </div>

    <div class="input-group mt-1">
      <label class="col-sm-3 col-md-2">입금자명</label>
      <div class="col-sm-9 col-md-10">{{$display->inputer}}</div>
    </div>
    @endif

    <form name="pay-form">
      <input type="hidden" name="o_id" value="{{$display->o_id}}">
      <div class="input-group mt-1">
        <label class="col-sm-3 col-md-2">결제상태</label>
        <select name="pay_status" class="form-select">
          @foreach($pay_status as $k => $v)
          <option value="{{$k}}" @if($k == $display->pay_status) selected @endif> {{$v}}</option>
          @endforeach
        </select>
        <button type="button" class="btn btn-danger act-update-pay">결제정보 업데이트</button>

      </div>
    </form>


  </div><!-- .card-body -->
</div><!-- .card -->


@endsection
@section('styles')
@parent
@endsection

@section('scripts')
@parent
<script>
$(".act-update-devery").on('click', function(){
  MARKET.ajaxroute('PUT', 
    {'name': 'market.admin.order.update.delivery'}, 
    $("form[name='delivery-form']").serializeObject(), 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        showToaster({title: '알림', message: '처리되었습니다.', alert: false});
      }
    })
})

$(".act-update-pay").on('click', function(){
  MARKET.ajaxroute('PUT', 
    {'name': 'market.admin.order.update.pay'}, 
    $("form[name='pay-form']").serializeObject(), 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        showToaster({title: '알림', message: '처리되었습니다.', alert: false});
      }
    })

  // var url = "{{ route('market.admin.order.update.pay') }}";
  // $.ajax({
  //   url : url,
  //   type : "put",
  //   data : $("form[name='pay-form']").serialize(),
  //   success : function(){
  //     alert('Success!');          
  //   },
  //   error : function(){
  //     alert("Error!")
  //   }
  // })
})
</script>
@endsection
