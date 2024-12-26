@extends('market.templates.layouts.'.config('pondol-market.template.layout.theme').'.front')
@section('meta')
@include('market.meta')
@endsection

@section('title', $meta->title)
@section('content')
<div class="container body product-show">
  <x-market-navy-category :categoryObj=$categoryObj />

  <div class="row mt-5 prd-view">
    <div class="col">
      <div class="row">
        <div class="image"><img src="{{getImageUrl($item->image)}}" id="prd-image"></div>
        <div class="thumb">
          <ul class="ps-0">
            @foreach($images as $v)
            <li class="p-1"><img src="{{getImageUrl($v->image)}}" onmouseover="swapImage(this)"></li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>

    <div class="col">
      <article>
        <div class="d-flex title">
          <div class="">{{$item->name}}</div>
          @include('market.templates.shop.'.config('pondol-market.template.shop.theme').'.sns')
        </div>
        @if($item->shorten_description)
        <div class="p-2 mt-1 bg-light rounded-3">{{$item->shorten_description}}</div>
        @endif
        <table class="table items">
          @foreach($item->specs as $spec)
          <tr>
            <th>{{$spec->title}}</th>
            <td>{{$spec->comment}}</td>
          </tr>
          @endforeach
          <tr>
            <th>판매가격</th>
            <td>{{number_format($item->price)}}</td>
          </tr>
          @if($item->t_point)
          <tr>
            <th>포인트</th>
            <td>{{number_format($item->t_point)}}/td>
          </tr>
          @endif
          <tr>
            <th>배송비</th>
            <td>{{delivery_fee_show()}}</td>
          </tr>
        </table>
      </article>

      <form method="POST" action="{{ route('market.cart.add') }}" name="cart-form">
        @csrf
        <input type="hidden" name="item" value="{{ $item->id}}">
        <input type="hidden" name="item_price" value="{{$item->price}}">
        <input type="hidden" name="optionPrice" value="0">

        <article>
          @if(count($options))
          <p>선택옵션</p>
          @foreach($options as $title => $option)
          <label>{{$title}}</label>

          <select name="options[]" class="form-select">
            <option value="" selected="">선택</option>
            @foreach($option as $v)
            <option value="{{$v->id}}" @if($v->sale == 0) disabled @endif  user-attr-option="{{$v->id}}|{{$v->title}}|{{$v->name}}|{{$v->price}}">
              {{$v->name}} 
              @if($v->price != 0) (+{{number_format($v->price)}}) @endif
              @if($v->sale == 0) <span>품절</span> @endif
            </option>
            @endforeach
          </select>
          @endforeach
          @endif 
          <div class="mt-2 pay-over-view @if(count($options)) d-none @endif">
            <div class="option-selected-box">
              <label class="col-form-label">
                <span id="option-text"></span>
                <span id="option-price"></span>
              </label>
              <div class="qty-adjust">
                <input type="number" name="qty" value="1" class="float-start form-control" style="width: 100px">
                <div class="float-start" style="width: 30px; text-align: center">
                  <div style="height: 20px"><i class="fa-solid fa-plus"></i></div>
                  <div style="height: 20px"><i class="fa-solid fa-minus"></i></div>
                </div>
                <div class="float-start" style="width: 40px; text-align: right;">
                  <i class="fa-solid fa-trash"></i>
                </div>
              </div>
            
            </div>
            <hr>
            <div class="d-flex" style="justify-content: space-between;">
              <label class="fs-4">총 금액: </label><span id="total-price" class="fs-4 fw-bolder text-danger"></span>
            </div>
          </div>
          
          <div class="mt-3">
            <button type="button" class="btn btn-primary" onclick="saveCart()">장바구니</button>
            <button type="button" class="btn btn-primary" onclick="directOrder()">바로구매</button>
            <button type="button" class="btn btn-light act-favorite" user-attr-favorite="{{$favorite}}">
<!-- 
            <div class="act-favorite" user-attr-favorite="{{$favorite}}">
            @if($favorite)
            <i class="fa-solid fa-heart text-danger"></i>
            @else
            <i class="fa-regular fa-heart"></i> 
            @endif
          </div> -->

          @if($favorite)
            <i class="fa-solid fa-heart text-danger"></i>
            @else
            <i class="fa-regular fa-heart"></i> 
            @endif
            </button>
          </div>
        </article>
      </form>
    </div>
  </div>  


  <ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="prod-info-tab" data-bs-toggle="tab" data-bs-target="#prod-info" type="button" role="tab" aria-controls="prod-info" aria-selected="true">상품정보</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="prod-review-tab" data-bs-toggle="tab" data-bs-target="#prod-review" type="button" role="tab" aria-controls="prod-review" aria-selected="false">사용후기</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="prod-qna-tab" data-bs-toggle="tab" data-bs-target="#prod-qna" type="button" role="tab" aria-controls="prod-qna" aria-selected="false">상품문의</button>
    </li>
  </ul>
  <div class="tab-content pb-5" id="productTabContent">
    <!-- 상품정보 -->
    <div class="tab-pane fade show active" id="prod-info" role="tabpanel" aria-labelledby="prod-info-tab">
    {!! $item->description !!} 
    </div>

    <!-- 사용 후기 -->
    <div class="tab-pane fade" id="prod-review" role="tabpanel" aria-labelledby="prod-review-tab">

      @forelse ($reviews as $review)
      <div class="d-flex flex-row bd-highlight mt-1">
        
        <div class="rating" style="width: 150px;"> 
          @for ($i = 0; $i < $review->rating; $i++)
            <span class="fill">☆</span>
          @endfor
          @for ($i = 5; $i > $review->rating; $i--)
            <span>☆</span>
          @endfor
          <span> ({{$review->rating}} 점) </span>
        </div>
        <div class="flex-grow-1 flex-shrink-1 ps-2" style="width: 120px;">{{$review->content}}</div>
        <div class=" text-end" style="width: 120px;">{{astro($review->user_name, 1)}}</div>
      </div>
      @empty
      <div>아직 등록된 사용후기가 없습니다.</div>
      @endforelse

    </div>

    <!-- 상품문의 -->
    <div class="tab-pane fade" id="prod-qna" role="tabpanel" aria-labelledby="prod-qna-tab">
      <div class="item-qna-form">
        <div class="d-flex justify-content-end mt-2">
          <button class="btn btn-primary" id="btn-open-qna-form">상품문의</button>
        </div>
        @include('market.templates.shop.'.config('pondol-market.template.shop.theme').'.qna-form')
      </div>

      <div>
       @forelse ($qnas as $qna)
        <div  style="border-bottom: 1px solid #dee2e6;">
          <div class="d-flex pt-2" data-bs-toggle="collapse" data-bs-target="#collapseQna-{{$qna->id}}">
            <div class="flex-grow-1">{{$qna->title}}</div>
            <div style="width: 60px">{{astro($qna->user_name, 1)}}</div>
            <div style="width: 120px">{{ date('m-d H:i', strtotime($qna->created_at))}}</div>
          </div>
          <div class="collapse mb-1" id="collapseQna-{{$qna->id}}">
            @if(!$qna->secret || ($qna->secret && Auth::user() &&  Auth::user()->id == $qna->user_id))
            <div class="card card-body">
            {!! nl2br($qna->content) !!}
            </div>
            <div class="card mt-1 card-body bt-light d-flex">
              <div><i class="fa-regular fa-comment-dots"></i></div>
              <div class="ps-2">{!! nl2br($qna->reply) !!}</div>
            </div>
            @else 
              <div class="card card-body">
              비밀글 입니다.
              </div>
            @endif
          </div>
        </div>
        @empty
        <div>
          등록된 상품문의가 없습니다.
        </div>
        @endforelse
      </div>

    </div>
  </div>


</div><!-- .container -->

<!-- /banner-feature -->
@endsection

@section('styles')
@parent
<style>
.prd-view .image img {
  width: 300px;
  height: 300px;
}

/* image translate 효과 주기 */
.prd-view .image img.on {
  filter: blur(1px);
  transition: transform 0.3s linear;
  transform: translate(0px, 0px);
}

.prd-view .thumb img {
  width: 50px;
  height: 50px;
}

.prd-view .thumb li {
  float: left;
}

.prd-info > ul  {
}

.prd-info > ul > li   {
  float: left;
  height: 50px;
  width: 33%;
  border-left: 1px solid #ccc;
  border-top: 1px solid #ccc;
  border-bottom: 1px solid #000;
  background: #f4f4f4;
}
.prd-info > ul > li.on  {
  border-top: 1px solid #000;
  border-left: 1px solid #000;
  border-right: 1px solid #000;
  border-bottom: 1px solid #fff;
}

.option-selected-box {
  display: flex;
  justify-content: space-between;
}


.qty-adjust {
  display: flex;
 justify-content: center;
 align-items: center;
}

#productTabContent #prod-info img{
  max-width: 100%;
}

.rating > span {
  font-weight: 300;
}
.rating > span.fill {
  color: #FFD600;
}


.product-show .title {
  padding 10px;
  overflow: hidden;
  height: 40px;
}



</style>
@endsection
@section('scripts')
@parent
<script>
var item_id = {{$item->id}};
var prodPrice = {{$item->price}};
var optionPrice = 0;
var payPriceforEachItem = 0;
var prdImage = document.getElementById('prd-image');
function swapImage(el) {
  prdImage.src = el.src;
  prdImage.classList.add('on');
}

prdImage.addEventListener("transitionend", function() {
  prdImage.classList.remove('on');
}, true);


function cal_total() {
  var total = (optionPrice + prodPrice) * parseInt($("input[name=qty]").val());
  $("#total-price").html(add_comma(total));
}
var options = [];
var selectedAll = false;

function setOptionPrice(price) {
  optionPrice = price;
  $("input[name=optionPrice]").val(price);
}
$(function(){
  $("select[name='options[]']").on('change', function(){
    // 모든 옵션값이 정상적으로 세팅되었는지 확인
    selectedAll = true;
    $("select[name='options[]']").each(function(index, el){
      var option = $(el).children("option:selected").attr('user-attr-option');
      if (!option) selectedAll = false;
      options[index] = option;
    })

    // 모든 옵션이 선택되면 가격등을 입력한다.
    if (selectedAll) {
      var optionText = [];
      setOptionPrice(0);
      for(var i=0; i < options.length; i++) {
        var option = options[i].split('|');
        var text = option[1]+': ' + option[2];
        optionText.push(text)
        setOptionPrice(optionPrice + parseInt(option[3]));
      }

      // 출력처리
      $("#option-text").html(optionText.join(' / '));
      if(optionPrice) {
        $("#option-price").html('(+'+add_comma(optionPrice)+'원)');
      }
      $(".pay-over-view").removeClass('d-none');
    }
    cal_total();
  });

  // 구매갯수 선택
  var $qty = $("input[name=qty]");
  $(".qty-adjust .fa-plus").on('click', function(){
    var qty = $qty.val();
    $qty.val(++qty);
    cal_total();
  })
  $(".qty-adjust .fa-minus").on('click', function(){
    var qty = $qty.val();
    if (qty > 1) {
      $qty.val(--qty);
    }
    cal_total();
  })

  // favorite 추가
  $(".act-favorite").on('click', function(){
    $this = $(this);
    var favId = $this.attr('user-attr-favorite');
    if (favId) { 
      ROUTE.ajaxroute('delete', 
      {route: 'market.item.favorite', segments: [favId]}, 
      function(resp) {
        if(resp.error) {
          showToaster({title: '알림', message: resp.error});
        } else {
          
          $this.attr('user-attr-favorite', '');
          $('.act-favorite .fa-heart').removeClass('fa-solid text-danger').addClass('fa-regular');
        }
      })
    } else {
      ROUTE.ajaxroute('post', 
      {route: 'market.item.favorite', segments: item_id},
      function(resp) {
        if(resp.error) {
          showToaster({title: '알림', message: resp.error});
        } else {
          $this.attr('user-attr-favorite', resp.id);
          $('.act-favorite .fa-heart').addClass('fa-solid text-danger').removeClass('fa-regular');
          // showToaster({title: '알림', message: '찜되었습니다.', alert: false, url: resp.next});
        }
      })
    }
  })
  
})

function saveCart(){

  ROUTE.ajaxroute('post', 
    {route: 'market.cart.add', data: $("form[name=cart-form]").serialize()}, 
    function(resp) {
      console.log('saveCart >> resp >>', resp);
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        showToaster({title: '알림', message: '장바구니에 담겼습니다.', alert: false, url: resp.next});
      }
    })

  return false;	
}

function directOrder(){

  var data = $("form[name=cart-form]").serialize();
  data += '&direct=1';

  ROUTE.ajaxroute('post', 
    {route: 'market.cart.add', data: data}, 
    function(resp) {
      console.log(resp);
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        location.href=resp.order;
        // showToaster({title: '알림', message: '장바구니에 담겼습니다.', alert: false, url: resp.next});
      }
    })

  return false;	
}
cal_total();
</script>
@endsection
