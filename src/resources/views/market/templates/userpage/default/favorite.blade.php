@extends('market.templates.layouts.'.config('market.template.layout.theme').'.front')
@section('title', '관심상품')
@section('content')
<div class="container body">
  <div class="row">
    <div class="col-3">
      @include('market.templates.userpage.'.config('market.template.userpage.theme').'.tabs')
    </div>
    <div class="col-9">
      <h2 class="mt-5">관심상품</h2>
      <div class="row mt-5 item-list" typeof="ItemList">
        <ul>
          @forelse ($items as $item)
          <li class="mt-1">
            
              <dl class="product-wrap">
                <div class="d-flex flex-column act popover" user-attr-favorite="{{$item->fav_id}}">
                  <a href="{{ route('market.item', [$item->id]) }}" class="btn"><i class="fas fa-search"></i></a>
                  <button class="btn act-fav-remove"><i class="fa-solid fa-trash"></i></button>
                </div>
              
                <dt class="image">
                  <img src="{{market_get_thumb($item->image, 150, 150)}}" class="img-thumbnail">
                </dt>
                <dd class="text-center">
                  <span>{{$item->name}}</span>
                  <div>{{number_format($item->price)}}</div>
                </dd>
              </dl>
              <a href="{{ route('market.item', [$item->id]) }}" class="link">
            </a>
          </li>
          @empty
          <li>
            <dl class="product-wrap">
              검색된 상품이 없습니다.
            </dl>
          </li>
          @endforelse
        </ul>
      </div>

      {{ $items->links('pagination::bootstrap-4') }}
    </div>
  </div>
</div>

<!-- /banner-feature -->
@endsection
@section('styles')
@parent
<style>
.product-wrap {
  position: relative;
}
.act.popover {
  position: absolute;
  right: 0;
}
</style>
@endsection
@section('scripts')
@parent
<script>
$(function(){
  $(".act-fav-remove").on('click', function(){
    $li = $(this).parents('li');
    var favId = $(this).parent().attr('user-attr-favorite');
    if (favId) { 
      ROUTE.ajaxroute('delete', 
      {route: 'market.item.favorite', segments: [favId]},
      function(resp) {
        if(resp.error) {
          showToaster({title: '알림', message: resp.error});
        } else {
          $li.remove();
        }
      })
    }
  })
})
</script>
@endsection
