@extends('market.templates.layouts.'.config('pondol-market.template.layout.theme').'.front')
@section('title', '상품후기 작성')
@section('content')
<div class="container body">
  <div class="row">
    <div class="col-3">
      @include('market.templates.userpage.'.config('pondol-market.template.userpage.theme').'.tabs')
    </div>
    <div class="col-9">
      <div class="card mt-5">
        <div class="card-header">
        상품후기 작성 하기
        </div>
        <div class="card-body">

          @forelse ($items as $item)
          <div class="row mt-1">
        
            <ul class="list-group list-group-horizontal">
              <li class="list-group-item">
                
                <img src="{{market_get_thumb($item->image, 50, 50)}}" class="img-thumbnail">  
                <div class="text-center">
                  <a href="{{ route('market.item', [$item->item_id]) }}" class="link">
                    <i class="fas fa-search"></i>
                  </a>
                </div>
              </li>
              <li class="list-group-item">
                  <div class="d-inline">
                    {{$item->name}}
                    </br>
                    주문일 : {{date('y-m-d', strtotime($item->created_at))}}
                  </div>
              </li>
              <li class="list-group-item flex-grow-1">
                @if($item->rating)
                <div class="d-flex">
                  <div>
                    <button class="btn btn-warining position-relative">
                      <span class="text-warning">☆</span>
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{$item->rating}}
                        <span class="visually-hidden">rating</span>
                      </span>
                    </button>
                  </div>
                  <div class="ps-2 ms-2">
                    {!! nl2br($item->content) !!}
                  </div>
                </div>
                @if($item->reply)
                <div class="p-3 mt-1 bg-light rounded-3 d-flex">
                  <div><i class="fa-regular fa-comment-dots"></i></div>
                  <div class="ps-2">{!! nl2br($item->reply) !!}</div>
                </div>
                @endif
                @else
                <form user-attr-id="{{$item->id}}">
                  <div class="rating"> 
                    <input type="radio" name="rating[{{$item->id}}]" value="5" id="5-{{$item->id}}"><label for="5-{{$item->id}}">☆</label>
                    <input type="radio" name="rating[{{$item->id}}]" value="4" id="4-{{$item->id}}"><label for="4-{{$item->id}}">☆</label> 
                    <input type="radio" name="rating[{{$item->id}}]" value="3" id="3-{{$item->id}}"><label for="3-{{$item->id}}">☆</label> 
                    <input type="radio" name="rating[{{$item->id}}]" value="2" id="2-{{$item->id}}"><label for="2-{{$item->id}}">☆</label> 
                    <input type="radio" name="rating[{{$item->id}}]" value="1" id="1-{{$item->id}}"><label for="1-{{$item->id}}">☆</label>
                  </div>

                  <div class="input-group">
                    <textarea class="form-control" name="content">{{$item->content}}</textarea>
                    <button type="button" class="btn btn-danger act-save">후기 저장</button>
                  </div>
                </form>
                @endif
                
              </li>
            </ul>
                
              
          </div>
          @empty
          <div class="row">
            리뷰 작성 가능한 상품이 없습니다.
          </div>
          @endforelse
        </div><!-- . card-body -->
        {{ $items->links('pagination::bootstrap-4') }}
      </div><!-- .card -->
    </div>
  </div>
</div>

<!-- /banner-feature -->
@endsection
@section('styles')
@parent
<style>
.items img {
  width: 100px;
  height: 100px;
}

.rating {
  display: flex;
  flex-direction: row-reverse;
  justify-content: center
}

.rating > input {
  display: none
}

.rating > label {
  position: relative;
  width: 1em;
  font-size: 30px;
  font-weight: 300;
  color: #FFD600;
  cursor: pointer
}

.rating>label::before {
  content: "\2605";
  position: absolute;
  opacity: 0
}

.rating>label:hover:before,
.rating>label:hover~label::before {
  opacity: 1 !important
}

.rating>input:checked~label::before {
  opacity: 1
}

.rating:hover>input:checked~label::before {
  opacity: 0.4
}
</style>
@endsection
@section('scripts')
@parent
<script>
$(function(){
  $(".act-save").on('click', function(){
    $form = $(this).parents('form');
    var order_id = $form.attr('user-attr-id')

    ROUTE.ajaxroute('POST', 
    {route: 'market.mypage.review', segments: [order_id], data: $form.serializeObject()}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        // showToaster({title: '알림', message: '더 나은 서비스를 제공하겠습니다.', alert: false});
        location.reload();
      }
    })

  });
})
</script>
@endsection
