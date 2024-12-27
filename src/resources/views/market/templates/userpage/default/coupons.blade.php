@extends(market_theme('layouts').'.front')
@section('title', '할인쿠폰')
@section('content')
<div class="container body">
  <div class="row">
    <div class="col-3">
      @include(market_theme('layouts').'.tabs')
    </div>
    <div class="col-9">
      <h2 class="mt-5">발급된 쿠폰</h2>
      <div class="p-3 mb-4 bg-light rounded-3">

      <div class="card mt-1">
        <div class="card-body">

          <table class="table items mt-2">
          <tr>
            <th>쿠폰명</th>
            <th>할인액(율)</th>
            <th>사용조건</th>
            <th>유효기한</th>
            <th>사용여부</th>
          </tr>
          @forelse ($items as $item)
          <tr>
            <td>{{$item->title}}</td>
            <td>
              @if($item->apply_amount_type == 'price')
                  {{ number_format($item->price)}} 원 할인
              @elseif($item->apply_amount_type == 'percentage')
                  {{ $item->percentage}}% 할인 (최대 {{ number_format($item->percentage_max_price)}})
              @endif
            </td>
            <td>{{number_format($item->min_price)}} 원 이상 구매시</td>

            <td>
            {{ date('Y-m-d', strtotime($item->expired_at))}}
            </td>
            <td>
              @if($item->used_at)
                  Y
              @else
                  N
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6">
            발급된 쿠폰이 없습니다.
            </td>
          </tr>
          @endforelse
          </table>

        </div><!-- .card-body -->
        <div  class="card-footer">
          {{ $items->links('pagination::bootstrap-4') }}
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div>
  </div>
</div>

@endsection

@section('styles')
<link href="/assets/css/mypage.css" rel="stylesheet">
@parent
@endsection

@section('scripts')
@parent
<script>
</script>
@endsection
