@section('title', '주문내역')
<x-dynamic-component 
  component="market::app-admin" 
  :path="['주문/배송관리', '주문내역']"> 

<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">주문내역</h2>

  <div class="card">
    <div class="card-body">
      <div>주문 내역을 확인하실 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

<form method="get" action="{{ route('market.admin.orders') }}" id="search-form" >
  <div class="card mt-1 p-2">
    <div class="card-body">
      <div class="row">

        <div class="col-6">
            <div >
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="delivery_status[]" value="ready"
                  @if(isset(request()->delivery_status) && in_array('ready', request()->delivery_status)) checked @endif>
                <label class="form-check-label">주문접수</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="delivery_status[]" value="ing" 
                  @if(isset(request()->delivery_status) && in_array('ing', request()->delivery_status)) checked @endif>
                <label class="form-check-label">배송진행</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="delivery_status[]" value="done" 
                  @if(isset(request()->delivery_status) && in_array('done', request()->delivery_status)) checked @endif>
                <label class="form-check-label">거래완료</label>
              </div>
              

              <!-- <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="delivery_status[]" value="50"
                @if(isset(request()->delivery_status) && in_array('50', request()->delivery_status)) checked @endif>
                <label class="form-check-label">주문취소</label>
              </div>

              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="delivery_status[]" value="60"
                 @if(isset(request()->delivery_status) && in_array('60', request()->delivery_status)) checked @endif>
                <label class="form-check-label">반품요청</label>
              </div>

              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="delivery_status[]" value="70"
                 @if(isset(request()->delivery_status) && in_array('70', request()->delivery_status)) checked @endif>
                <label class="form-check-label">교환요청</label>
              </div> -->
            </div>

            <div class="input-group">
            <select class="form-select" name="sk">
                <option value="it.name" @if( request()->get('sk') == 'it.name')) selected="selected" @endif >상품명</option>
                <option value="market_orders.o_id" @if( request()->get('sk') == 'market_orders.o_id')) selected="selected" @endif >주문번호</option>
                <option value="u.name" @if( request()->get('sk') == 'u.name')) selected="selected" @endif >주문자명</option>
              </select>
              <input type="text" name="sv" value="{{ request()->sv}}" placeholder="검색어를 입력해주세요." class="form-control">
              <button class="btn btn-success btn-serch-keyword">검색</button>
            </div>
        </div>

        <div class="ps-5 col-6">
          <div class="input-group mb-1">
            <button type="button" class="btn btn-light act-set-date" user-attr-term="0">오늘</button>
            <button type="button" class="btn btn-light act-set-date" user-attr-term="6">7일</button>
            <button type="button" class="btn btn-light act-set-date" user-attr-term="14">15일</button>
            <button type="button" class="btn btn-light act-set-date" user-attr-term="29">1개월</button>
            <button type="button" class="btn btn-light act-set-date" user-attr-term="179">6개월</button>
          </div>

          <div class="input-group">
            <input type="text" name="from_date" class="form-control" id="from-date" value="{{ request()->from_date}}" readonly>
            <i class="fa fa-calendar from-calendar input-group-text"></i>
            <span class="col-1 text-center">∼</span>
            <input type="text" name="to_date" class="form-control" id="to-date" value="{{ request()->to_date}}" readonly>
            <i class="fa fa-calendar to-calendar input-group-text"></i>
            <button class="btn btn-success btn-serch-date">조회</button>
          </div>
        </div>

      </div> <!-- .row  -->
    </div><!-- .card-body -->
  </div><!-- .card -->
</form>

<div class="card mt-1">
  <div class="card-body">

    <table class="table items">
      <tr>
        <th class="text-center">상품명/주문번호</th>
        <th class="text-center">결재방식</th>
        <th class="text-center">결재상태</th>
        <th class="text-center">배송상태</th>
        <th class="text-center">주문자</th>
        <th class="text-center">주문일</th>
        <th></th>
      </tr>
      @forelse ($items as $item)
      <tr>
        <td class="text-center">
          {{$item->name}} @if($item->count > 1 ) 외 {{($item->count - 1)}}건 @endif
          <br>({{$item->o_id}})
        </td>
        <td class="text-center">{{ __('market::market.pay_method.'.$item->method) }}</td>
        <td class="text-center">{{ __('market::market.pay_status.'.$item->status) }}</td>
        <td class="text-center">{{ __('market::market.delivery_status.'.$item->delivery_status) }}</td>
        <td class="text-center">{{$item->user_name}}</td>
        <td class="text-center">{{$item->created_at}}</td>
        <td class="text-center"><a href="{{ route('market.admin.order', [$item->o_id]) }}" class="btn">상세보기</a></td>
      </tr>
      @empty
      <tr>
        <td colspan="7">
          검색된 상품이 없습니다.
        </td>
      </tr>
      @endforelse
    </table>

  </div> <!-- card-body -->
  <div class="card-footer">
  {{ $items->links('pagination::bootstrap-4') }}
  </div><!-- card-footer -->
</div>
 
@section('styles')
  @parent
<style>
  .items img {
    width: 100px;
    height: 100px;
  }
</style>
@endsection

@section('scripts')
  @parent
@endsection
</x-dynamic-component>
