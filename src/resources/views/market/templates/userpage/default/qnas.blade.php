@extends(market_theme('layouts').'.front')
@section('title', '상품문의')
@section('content')

<div class="container body">

  <div class="row">
    <div class="col-3">
      @include(market_theme('userpage').'.tabs')
    </div>
    <div class="col-9">
      <div class="card mt-5">
        <div class="card-header">
        상품문의
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
                <a href="{{ route('market.item', [$item->item_id]) }}" class="link">
                  <div class="d-inline">
                    {{$item->name}}
                    </br>
                    문의접수일 : {{date('y-m-d', strtotime($item->created_at))}}
                  </div>
                </a>
              </li>
              <li class="list-group-item flex-grow-1">
                <div class="bg-light p-1 rounded-3">
                  <div>{{$item->title}}</div>
                </div>
                <div class="mt-1 p-1">
                  <div>{!! nl2br($item->content) !!}</div>
                </div>
                @if($item->reply)
                <button class="btn w-100 act-show-answer"><i class="fa-solid fa-angles-down"></i></button>
                <div class="card d-none">
                  <div class="card-body">
                  {!! nl2br($item->reply) !!}
                  </div>
                </div>
                @else 
                <button class="btn btn-light w-100">답변 준비중</button>
                @endif
              </li>
            </ul>
                
              
          </div>
        @empty
        <div class="row">
          문의하신 상품이 없습니다.
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
@endsection
@section('scripts')
@parent
<script>
$(function(){
  $('.act-show-answer').on('click', function(){
    $(this).next().removeClass('d-none');
  })
})
</script>
@endsection
