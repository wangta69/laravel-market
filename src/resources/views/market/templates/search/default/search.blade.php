@extends(market_theme('layouts').'.front')
@section('meta')
@include('market.meta')
@endsection
@section('title', $meta->title)
@section('content')

  <div class="container body">
  
    <div class='d-flex'>
      <div class="search-left" style="width: 200px;">
        
        <form action="{{ route('market.search') }}" onsubmit="return search_submit(this);">
          <input type="hidden" name="q" value="{{request()->get('q')}}">
          <div class="card card-body">
            <select name="cat" class="form-select">
              <option value="">전체 카테고리</option>
              @foreach($categories as $c)
              <option value="{{$c->category}}" @if(request()->get('cat') == $c->category) selected @endif>{{$c->name}}</option>
              @endforeach
            </select>

            <!-- 전체 카테고리가 있으면 그 하위 카테고리 리스트업 -->

            <div class="input-group input-group-sm mt-2">
              <input type="text" name="minPrice" class="form-control form-control-sm" value="{{request()->get('minPrice')}}">
              <div class="input-group-text bg-light">~</div>
              <input type="text" name="maxPrice" class="form-control form-control-sm" value="{{request()->get('maxPrice')}}"> 
              <div class="input-group-text">원</div>
              <button type="submit" class="btn btn-sm">검색</button>
            </div>
          </div><!-- card card-bod -->
        </form>
      </div>
      <div class="flex-glow-1 w-100 search-body">
      <div class="ms-3 mt-2">"{{request()->get('q')}}" 에 대한 검색</div>
      <div class="row mt-5 item-list" typeof="ItemList">
      <ul>
        @forelse ($items as $item)
        <li class="mt-1">
          <a href="{{ route('market.item', [$item->id]) }}" class="link">
            <dl class="product-wrap">
              <dt class="image">
                <img src="{{market_get_thumb($item->image, 150, 150)}}" class="img-thumbnail">
              </dt>
              <dd class="text-center">
                <span>{{$item->name}}</span>
                <div>{{number_format($item->price)}}</div>
              </dd>
            </dl>
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
      </div><!-- search-body -->
    </div>


  </div><!-- .container -->
<!-- /banner-feature -->
@endsection

@section('styles')
@parent
@endsection

@section('scripts')
@parent
@endsection
