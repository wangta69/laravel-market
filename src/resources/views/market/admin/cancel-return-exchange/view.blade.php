@extends('market.admin.layouts.main')
@section('title', '교환/반품내역')
@section('content')
@include('market.admin.layouts.main-top', ['path'=>['주문/배송관리', '교환/반품']])

<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">교환/반품내역</h2>

  <div class="card">
    <div class="card-body">
      <div>교환/반품내역을 확인하실 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>


<div class="card mt-5">
  <div class="card-header d-flex justify-content-between">
    <div>
      @if($item->type == "exchange")
        <span class="btn btn-warning btn-sm">교환</span>
      @elseif($item->type == "return")
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
  <div class="card-footer">
      

    <!-- @if (!$errors->isEmpty())
    <div class="alert alert-danger" role="alert">
      {!! $errors->first() !!}
    </div>
    @endif -->
    <div class="row  justify-content-end">
      <form action="" method="POST" action="{{ route('market.admin.cancel-return-exchange.view', [$item->id]) }}" class="col-5 col-lg-3">
      @method('PUT')
      @csrf
        <div class="input-group">
        
          <select class="form-select" name="status">
            @foreach($configs as $k => $v)
            <option value="{{$k}}" @if($item->status == $k) selected @endif>{{$v}}</option>
            @endforeach
            </select>
          <button type="submit" class="btn btn-primary">변경</button>
        </div>
      </form>
    </div>  
  </div><!--  .card-footer -->
</div> <!-- card -->


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
