@extends('market.templates.layouts.'.config('pondol-market.template.layout.theme').'.front')
@section('content')

<div class="container body">
  <div class="row">
    <div class="col-3">
      @include('market.templates.userpage.'.config('pondol-market.template.userpage.theme').'.tabs')
    </div>
    <div class="col-9">
      <form method="post"  action="{{ route('market.mypage.order.cancel-return-exchange', [$type, $o_id]) }}" >
      @csrf
        <div class="card mt-5">
          <div class="card-header">
          {{$typeStr}}상품 선택
          </div>
          <div class="card-body">
            <table class="table items">

              @forelse ($items as $item)
              <tr>
                <td>
                  <input class="form-check-input" type="checkbox" name="order_id[]" value="{{$item->order_id}}" >
                </td>
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
  
                <div class="d-flex">
                    <button type="button" class="btn btn-light btn-sm act-count-down" >-</button>
                    <input type="text" name="qty[{{$item->order_id}}]" value="{{old('qty.'.$item->order_id, $item->qty)}}" user-attr-max="{{$item->qty}}" class="form-control form-control-sm " style="width: 50px;">
                    <button type="button" class="btn btn-light btn-sm act-count-up">+</button>
                  </div>
                </td>
                <!-- <td>
                {{number_format(($item->item_price + $item->option_price) * $item->qty)}}
                </td> -->
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
        </div> <!-- card -->

        <div class="card mt-5">
          <div class="card-header">
          {{$typeStr}}이유
          </div>
          <div class="card-body">
          <p>반품이 접수되면 먼저 상담원이 연락을 드릴 예정입니다.</p>
            <div class="input-group mt-1">
              <span class="input-group-text"><i class="fa-solid fa-square-phone"></i></span>
              <div class="form-floating flex-grow-1">
                <input type="tel" name="contact" class="form-control" id="floatingInputTel" value="{{old('contact', Auth::user()->mobile)}}">
                <label for="floatingInputTel">연락처</label>
              </div>
              
            </div>

            <div class="input-group mt-1">
              <span class="input-group-text"><i class="fa-solid fa-file-pen"></i></span>
              <div class="form-floating flex-grow-1">
                <textarea name="reason" class="form-control" id="floatingInputReason" style="height: 150px;">{{old('reason')}}</textarea>
                <label for="floatingInputReason">{{$typeStr}}이유</label>
              </div>
              
            </div>

            
          </div> <!-- .card-body -->
          <div class="card-footer text-end">
            

          @if (!$errors->isEmpty())
          <div class="alert alert-danger" role="alert">
            {!! $errors->first() !!}
          </div>
          @endif
            <button class="btn btn-primary act-order-confirm">접수하기</button>

          </div><!--  .card-footer -->
        </div> <!-- card -->
      </form>
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
