@extends('market.templates.layouts.'.config('pondol-market.template.layout.theme').'.front')
@section('meta')
@include('market.meta')
@endsection
@section('title', $meta->title)
@section('content')

  <div class="container body">

    <x-market-navy-category :categoryObj=$categoryObj />
    
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
  </div><!-- .container -->
<!-- /banner-feature -->
@endsection

@section('styles')
@parent
@endsection

@section('scripts')
@parent
@endsection
