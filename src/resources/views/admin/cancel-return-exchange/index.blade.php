@section('title', '교환/반품내역')
<x-dynamic-component 
  component="market::app-admin" 
  :path="['주문/배송관리', '교환/반품']"> 
<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">교환/반품내역</h2>

  <div class="card">
    <div class="card-body">
      <div>교환/반품내역을 확인하실 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

<form method="get" action="{{ route('market.admin.cancel-return-exchanges') }}" id="search-form" >
  <div class="card mt-1 p-2">
    <div class="card-body">
      <div class="row">

        <div class="col-6">
            <div >


              <!-- <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="delivery_status[]" value="50"
                @if(isset(request()->delivery_status) && in_array('50', request()->delivery_status)) checked @endif>
                <label class="form-check-label">주문취소</label>
              </div> -->

              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="delivery_status[]" value="60"
                 @if(isset(request()->delivery_status) && in_array('60', request()->delivery_status)) checked @endif>
                <label class="form-check-label">반품요청</label>
              </div>

              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="delivery_status[]" value="70"
                 @if(isset(request()->delivery_status) && in_array('70', request()->delivery_status)) checked @endif>
                <label class="form-check-label">교환요청</label>
              </div>
            </div>

            <div class="input-group">
              <button class="btn btn-primary btn-serch-keyword">검색</button>
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
            <button class="btn btn-primary btn-serch-date">조회</button>
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
        <th class="text-center"></th>
        <th class="text-center">상품정보</th>
        <th class="text-center">상태</th>
        <th class="text-center">원주문</th>
        <th class="text-center">주문일</th>
        <th class="text-center">요청일</th>
        <th></th>
      </tr>
      @forelse ($items as $item)
      <tr>
        <td class="text-center">
          @if($item->type == "exchange")
            <span class="btn btn-warning btn-sm">교환</span>
          @elseif($item->type == "return")
            <span class="btn btn-danger btn-sm">반품</span>
          @endif

        </td>
        <td class="text-center">{{$item->name}} <br> {{$item->qty}}개</td>
        <td class="text-center">
          @if($item->type == "exchange")
            {{$exchange_status[$item->status]}}
          @elseif($item->type == "return")
            {{$return_status[$item->status]}}
          @endif
        </td>
        <td class="text-center"><a href="{{ route('market.admin.order', [$item->o_id]) }}" class="btn">{{$item->o_id}}</a></td>
        <td class="text-center">{{date("Y/m/d", strtotime($item->order_created_at))}}</td>
        <td class="text-center">{{date("Y/m/d", strtotime($item->created_at))}}</td>
        <td class="text-center"><a href="{{ route('market.admin.cancel-return-exchange.view', [$item->id]) }}" class="btn">상세보기</a></td>
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