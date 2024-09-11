@extends('market.templates.layouts.'.config('market.template.layout.theme').'.front')
@section('content')

<div class="container body">

@include('market.templates.main.default.carousel')

  <h3 class="mt-5">MD 추천 상품 </h3>

  <div class="row item-list" typeof="ItemList">
    <ul>
      @forelse($main['rec'] as $item)
      <li>
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
  <h3 class="mt-5">인기 상품 </h3>
  <div class="row item-list" typeof="ItemList">
    <ul>
      @forelse($main['hit'] as $item)
      <li>
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
  <h3 class="mt-5">신규 상품 </h3>
  <div class="row item-list" typeof="ItemList">
    <ul>
      @forelse($main['new'] as $item)
      <li>
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

</div>


<!-- /banner-feature -->
@endsection
@section('styles')
@parent
@endsection

@section('scripts')
@parent

@endsection
