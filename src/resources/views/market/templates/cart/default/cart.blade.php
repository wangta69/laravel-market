@extends('market.templates.layouts.'.config('market.template.layout.theme').'.front')
@section('title', '장바구니')
@section('content')

<div class="container body">
  <h2 class="title mt-5">장바구니</h2>

  <div class="row">
    <div class="col-8">
      <form method="POST" name="cart-form" action="{{ route('market.order.set') }}" onsubmit='return checkCart(this);'>
        @csrf

          @forelse ($items as $item)
          <div class="card mt-1" user-attr-id="{{$item->id}}">
            <input type="hidden" name="item_price" value="{{$item->item_price}}">
            <input type="hidden" name="option_price" value="{{$item->option_price}}">
            <div class="card-body">
              <div class="d-flex flex-row">
                <input class="form-check-input me-2 act-item-check" type="checkbox" name="order[]" value="{{$item->id}}">
                <a href="{{ route('market.item', [$item->item_id]) }}" class="link me-2">
                  <img src="{{market_get_thumb($item->image, 100, 100)}}" class="img-thumbnail">
                </a>
                <div class="flex-grow-1">
                  <div class="d-flex justify-content-between ">
                    <a href="{{ route('market.item', [$item->item_id]) }}" class="h5 link"> {{$item->name}}</a>
                    <span class="btn btn-secondary  btn-sm btn-close" onclick="deleteItem({{$item->id}})"></span>
                  </div> 
                  @if($item->model) {{$item->model}} <br> @endif
                  {{number_format($item->price)}}원 <br>

                  @if(isset($item->displayOptions))
                    @foreach($item->displayOptions as $option)
                      @if(isset($option[1]))
                      {{$option[1]}} : {{$option[2]}} @if($option[3]) ({{number_format($option[3])}} 원 추가) @endif<br>
                      @endif
                    @endforeach
                  @endif
                  <div class="d-flex">
                    <button type="button" class="btn btn-light btn-sm act-count-down" >-</button>
                    <input type="text" name="item-qty" value="{{$item->qty}}" class="form-control form-control-sm " style="width: 50px;">
                    <button type="button" class="btn btn-light btn-sm act-count-up">+</button>
                  </div>
                  
                </div>
              </div>
            </div>
            <div class="card-footer text-end">
              <span class="total-price">{{ number_format(($item->item_price + $item->option_price) * $item->qty)}}</span>
            </div>
          </div>

          @empty
          <div>

            장바구니에 담긴 상품이 없습니다.

          </div>
          @endforelse


        <!-- <button type="submit" class="btn btn-danger">구매하기</button> -->
      </form>
    </div>
    <div class="col-4">
      <div class="card card-body">
        주문 예상 금액
        <ul>
          <li>총 상품 가격 <span id="over-view-item-price">0</span></li>
          <!-- <li>총 할인</li> -->
          <li>총 배송비 <span id="over-view-delivery-fee">0</span></li>
        <hr>
        <span id="over-view-total">0</span>
        <button class="btn btn-primary act-purchase"> 구매하기 </button>
      </div>
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
function checkCart(f) {
  var checked = 0;
  var c = document.getElementsByName("order[]");
  for( i = 0, checked = 0; i  < c.length; i++) {
    if( c[i].checked) checked++
  }

  if(checked === 0) {
    showToaster({title: '알림', message: '구매할 상품을 선택하세요.'});
    return false;
  } else {
    return true;
  }
}

function deleteItem(id) { // id: cart id
  ROUTE.ajaxroute('delete', 
    {route: 'market.cart.delete', segments:[id]}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        location.reload();
      }
    })
}


function updateqty(parent, flag) {
  var id = $(parent).attr('user-attr-id');
  var itemQty = parseInt($(parent).find('input[name=item-qty]').eq(0).val());
  
  if(flag=='down' && itemQty > 1) {
    itemQty = itemQty - 1;
  } else if(flag == 'up') {
    itemQty = itemQty + 1;
  }

  $(parent).find('input[name=item-qty]').eq(0).val(itemQty);
  var item_price = $(parent).find('input[name=item_price]').eq(0).val();
  var option_price = $(parent).find('input[name=option_price]').eq(0).val();
  var total_price = $(parent).find('.total-price').eq(0);

  total_price.html(add_comma((parseInt(item_price) + parseInt(option_price)) * itemQty));

  ROUTE.ajaxroute('put', 
    {route: 'market.cart.update.qty', data: {id: id, qty: itemQty}}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        updateoverview();
      }
    })
}

function updateoverview() {
  
  ROUTE.ajaxroute('get', 
    {route: 'market.cart.update.overview', data: $("form[name=cart-form]").serializeObject()}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        $("#over-view-item-price").html(add_comma(resp.display.totalPrice));
        $("#over-view-delivery-fee").html(add_comma(resp.display.delivery_fee));
        $("#over-view-total").html(add_comma(resp.display.totalPrice + resp.display.delivery_fee));
      }
    })
}


$(function(){
  // 전체선택/해제 
  $('input:checkbox[name="check-all"]').on('click', function() {
    var checked = $(this).is(":checked");
    $('input:checkbox[name="order[]"]').each(function() {
      $(this).prop('checked', checked);
    });
  });

  // 카운트 업/다운
  $(".act-count-down").on('click', function(){
    var parent = $(this).parents('.card')[0];
    updateqty(parent, 'down');
  })

  $(".act-count-up").on('click', function(){
    var parent = $(this).parents('.card')[0];
    updateqty(parent, 'up');
  })

  //  구매하기 클릭
  $(".act-purchase").on('click', function(){
    $("form[name=cart-form]").submit();
  });

  $(".act-item-check").on('click', function(){
    updateoverview();
  })
})
</script>
@endsection
