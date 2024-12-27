@extends(market_theme('layouts').'.front')
@section('content')

<div class="container body">
  <div class="row">
    <div class="col-3">
      @include(market_theme('userpage').'.tabs')
    </div>
    <div class="col-9">
    <div class="card mt-5">
  <div class="card-header d-flex justify-content-between">
    <div>
      @if($item->type == "exchange")
        <span class="btn btn-warning btn-sm">교환</span>
      @elseif($item->type == "refund")
        <span class="btn btn-danger btn-sm">반품</span>
      @endif

      <span class="btn btn-info btn-sm">{{$configs[$item->status] }}</span>
    </div>
    <div>
      접수일 : {{date('Y/m/d', strtotime($item->created_at))}} | 주문일 {{date('Y/m/d', strtotime($item->order_created_at))}} | 주문번호 : {{ $item->o_id}}
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

    </div>
  </div> <!-- .card-body -->
  <div class="card-body">
    <div class="input-group mt-1">
      <span class="input-group-text"><i class="fa-solid fa-square-phone"></i></span>
      <span class="input-group-text">
        {{$item->contact}}
      </span>
      
    </div>

    <div class="input-group mt-1">
      <span class="input-group-text"><i class="fa-solid fa-file-pen"></i></span>
      <div class="form-floating flex-grow-1">
      <span class="input-group-text text-start">
        {!! nl2br($item->reason) !!}
      </span>
      </div>
      
    </div>
  </div><!-- card-body -->

</div> <!-- card -->

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
