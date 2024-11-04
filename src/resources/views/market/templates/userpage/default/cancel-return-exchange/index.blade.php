@extends('market.templates.layouts.'.config('pondol-market.template.layout.theme').'.front')
@section('content')

<div class="container body">
  <div class="row">
    <div class="col-3">
      @include('market.templates.userpage.'.config('pondol-market.template.userpage.theme').'.tabs')
    </div>
    <div class="col-9">


    <ul class="nav nav-tabs mt-5">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{ route('market.mypage.order.cancel-return-exchanges') }}">교환/반품</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('market.mypage.order.refund') }}">무통장환불</a>
      </li>
    </ul>

      @forelse ($items as $item)

      교환/반품      / 무통장환불


      무통장환불계좌 정보 : [환불계좌등록하기]


      예금주: 류영형
      은행 : 은행을 선택해 주세요
      계좌번호: 

      취소 확인


      <div class="card mt-1">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <div>
              @if($item->type == "exchange")
              <span class="btn btn-warning btn-sm">교환</span>
              @elseif($item->type == "return")
              <span class="btn btn-danger btn-sm">반품</span>
              @endif
              {{$item->statusStr}}
            </div>
            <div>
            접수일 : {{date('Y/m/d', strtotime($item->created_at))}} | 주문일 {{date('Y/m/d', strtotime($item->order_created_at))}} | 주문번호 : {{ $item->o_id}}
            </div>
          </div>
      </div>
        <div class="card-body">
          <div class="row">
            <div class="col-2">
              <img src="{{market_get_thumb($item->image, 100, 100)}}" class="img-thumbnail">
            </div>
            <div class="col-6">
              {{$item->name}} <br>
              @if($item->model) {{$item->model}} <br> @endif
              {{number_format($item->item_price)}} 원 <br>

              @if(isset($item->displayOptions))
                @foreach($item->displayOptions as $option)
                  {{$option[1]}} : {{$option[2]}} @if($option[3]) ({{number_format($option[3])}} 원 추가) @endif<br>
                @endforeach
              @endif
            </div>
            <div class="col-2">

              {{$item->qty}} 개 <br>
              {{number_format($item->item_price + $item->option_price)}} 원
            </div>
            <div class="col-2">

              <a class="btn btn-sm btn-primary" href="{{ route('market.mypage.order.cancel-return-exchange.view', [$item->issue_id]) }}">상세내역</a>
            </div>
          </div>
        </div> <!-- .card-body -->
      </div> <!-- card -->
      @empty
      <div>
        제품이 존재하지 않습니다.
      </div>
      @endforelse

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

function updateqty($input, flag) {

  var itemQty = parseInt($input.val());
  var max = parseInt($input.attr('user-attr-max'));  
  if(flag=='down' && itemQty > 1) {
    itemQty = itemQty - 1;
  } else if(flag == 'up' && itemQty < max) {
    itemQty = itemQty + 1;
  }

  $input.val(itemQty);

}

$(function(){
  
  // 카운트 업/다운
  $(".act-count-down").on('click', function(){
    var inputqty = $(this).siblings('input[type=text]')[0];
    updateqty($(inputqty), 'down');
  })

  $(".act-count-up").on('click', function(){
    var inputqty = $(this).siblings('input[type=text]')[0];
    updateqty($(inputqty), 'up');
  })

})
</script>
@endsection
