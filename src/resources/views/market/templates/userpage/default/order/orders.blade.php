@extends('market.templates.layouts.'.config('pondol-market.template.layout.theme').'.front')
@section('title', '주문내역')
@section('content')

<div class="container body">

  <div class="row">
    <div class="col-3">
      @include('market.templates.userpage.'.config('pondol-market.template.userpage.theme').'.tabs')
    </div>
    <div class="col-9">
      <h2 class="mt-5">주문내역</h2>
      <table class="table items">
        <tr>
          <th></th>
          <th></th>
          <th>배송상태</th>
          <th>주문일</th>
          <th></th>
        </tr>
        @forelse ($items as $item)
        <tr>
          <td><img src="{{market_get_thumb($item->image, 100, 100)}}" class="img-thumbnail"></td>
          <td>{{$item->name}} @if($item->count > 1 ) 외 {{($item->count - 1)}}건 @endif</td>
          <!-- <td>{{ __('market::market.pay_method.'.$item->method) }}</td>
          <td>
            {{ __('mmarket::arket.pay_status.'.$item->status) }}
            
          </td> -->
          <td>
            {{ __('market::market.delivery_status.'.$item->delivery_status) }}
            
          </td>
          <td>{{date('Y/m/d', strtotime($item->created_at))}}</td>
          <td><a href="{{ route('market.mypage.order.view', [$item->o_id]) }}" class="btn">상세보기</a></td>
        </tr>
        @empty
        <tr>
          <td colspan="6">
            검색된 상품이 없습니다.
          </td>
        </tr>
        @endforelse
      </table>
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
</script>
@endsection
