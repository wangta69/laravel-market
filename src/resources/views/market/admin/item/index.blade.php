@extends('market.admin.layouts.main')
@section('title', '상품관리')
@section('content')
@include('market.admin.layouts.main-top', ['path'=>['상품관리', '상품관리']])

<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">상품관리</h2>

  <div class="card">
    <div class="card-body">
      <div>상품 등록 및 수정이 가능합니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

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


<a href="{{ route('market.admin.item.create') }}" class="btn btn-primary mt-2">상품등록</a>

<div class="card mt-1">
  <div class="card-body">

    <table class="table items mt-2">
      <tr>
        <th>이미지</th>
        <th>상품명</th>
        <th>가격</th>
        <th>제고수량</th>
        <th></th>
      </tr>
      @forelse ($items as $item)
      <tr>
        <td><img src="{{market_get_thumb($item->image, 50, 50)}}" class="img-thumbnail"></td>
        <td>{{$item->name}}</td>
        <td>{{number_format($item->price)}}</td>
        <td>{{number_format($item->stock)}}</td>
        <td><a href="{{ route('market.admin.item', [$item->id]) }}" class="btn">보기</a></td>
      </tr>
      @empty
      <tr>
        <td colspan="5">
          검색된 상품이 없습니다.
        </td>
      </tr>
      @endforelse
    </table>

  </div><!-- .card-body -->
  <div  class="card-footer">
    {{ $items->links('pagination::bootstrap-4') }}
  </div><!-- .card-footer -->
</div><!-- .card -->
@endsection

@section('styles')
  @parent
@endsection

@section('scripts')
  @parent
@endsection
