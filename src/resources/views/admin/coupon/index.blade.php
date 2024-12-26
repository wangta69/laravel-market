@section('title', '쿠폰발급')
<x-dynamic-component 
  component="market::app-admin" 
  :path="['쿠폰관리', '쿠폰발급내역']"> 

<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">쿠폰발급</h2>

  <div class="card">
    <div class="card-body">
      <div>등록된 쿠폰을 이용하여 고객에게 쿠폰을 발급하실 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>
{{-- 
<form method="get" action="{{ route('market.admin.items') }}" id="search-form" >
  <div class="card mt-1 p-2">
    <div class="card-body">
      <div class="row">

        <div class="col-xl-6 col-md-6">
          <div class="">
            <span>기간설정 ▶</span>
            <div>
              <button type="button" class="btn set-date" user-attr-term="0">오늘</button>
              <button type="button" class="btn set-date" user-attr-term="6">7일</button>
              <button type="button" class="btn set-date" user-attr-term="14">15일</button>
              <button type="button" class="btn set-date" user-attr-term="29">1개월</button>
              <button type="button" class="btn set-date" user-attr-term="179">6개월</button>
            </div>
          </div>
          <div class="mt-2">
            <!-- <div class="form-check">
              <input class="form-check-input" type="checkbox" name="sort_out" value="1" @if (request()->sort_out == "1") checked @endif>
              <label class="form-check-label">품절</label>
            </div> -->
          </div>
        </div>

        <div class="p-0 col-xl-6 col-md-6 ">
          <div class="">
            <div class="input-group">
              <input type="text" name="from_date" class="form-control" id="from-date" value="{{ request()->from_date}}" readonly>
              <i class="fa fa-calendar from-calendar input-group-text"></i>
              <span class="col-1 text-center">∼</span>
              <input type="text" name="to_date" class="form-control" id="to-date" value="{{ request()->to_date}}" readonly>
              <i class="fa fa-calendar to-calendar input-group-text"></i>
              <button class="btn btn-success btn-serch-date">조회</button>
            </div>
          </div>

          <div class="mt-2">
            <div class="input-group">
              <select class="form-select" name="sk">
                <option value="market_items.name" @if( request()->get('sk') == 'market_items.name')) selected="selected" @endif >상품명</option>
                <option value="market_items.brand" @if( request()->get('sk') == 'market_items.brand')) selected="selected" @endif >브랜드</option>
                <option value="market_items.model" @if( request()->get('sk') == 'market_items.model')) selected="selected" @endif >모델</option>
              </select>
              <input type="text" name="sv" value="{{ request()->sv}}" placeholder="검색어를 입력해주세요." class="form-control">
              <button class="btn btn-success btn-serch-keyword">검색</button>
            </div>
          </div>
        </div>

      </div> <!-- .row  -->
    </div><!-- .card-body -->
  </div><!-- .card -->
</form>
--}}

<a href="{{ route('market.admin.coupon.create') }}" class="btn btn-primary mt-2">쿠폰등록</a>

<div class="card mt-1">
  <div class="card-body">

    <table class="table items mt-2">
      <tr>
        <th>쿠폰명</th>
        <th>쿠폰 종류</th>
        <th> 최소 구매 금액</th>
        <th>적용방식</th>
        <th></th>
        <th></th>
      </tr>
      @forelse ($items as $item)
      <tr>
        <td>{{$item->title}}</td>
        <td>@lang('market::market.coupon.apply_type.'.$item->apply_type)</td>
        <td>{{number_format($item->min_price)}}</td>
        <td>@lang('market::market.coupon.apply_amount_type.'.$item->apply_amount_type)</td>
        <td>
        @if($item->apply_amount_type == 'price')
        {{ number_format($item->price)}} 원 할인
        @elseif($item->apply_amount_type == 'percentage')
        {{ $item->percentage}}% 할인 (최대 {{ number_format($item->percentage_max_price)}})
        @endif

        </td>
        <td>
          <a href="{{ route('market.admin.coupon.issue', [$item->id])}}" class="btn btn-info btn-sm">발급하기</a>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6">
          검색된 쿠폰이 없습니다.
        </td>
      </tr>
      @endforelse
    </table>

  </div><!-- .card-body -->
  <div  class="card-footer">
    {{ $items->links('pagination::bootstrap-4') }}
  </div><!-- .card-footer -->
</div><!-- .card -->

@section('styles')
  @parent
@endsection

@section('scripts')
  @parent
@endsection
</x-dynamic-component>