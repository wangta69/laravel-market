@extends('market::admin.layouts.main')
@section('title', '리뷰')
@section('content')
@include('market::admin.layouts.main-top',  ['path'=>['메일', '발송리스트']])
<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">발송리스트</h2>

  <div class="card">
    <div class="card-body">
      <div>발송내역입니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>


<form method="get" action="{{ route('mailer.admin.index') }}" id="search-form" >
  <div class="card mt-1 p-2">
    <div class="card-body">
      <div class="row">

        <div class="col-6">
            <div class="form-check">

            </div>
   
            <div class="input-group">
              <select class="form-select" name="sk">
                <option value="msg.title" @if( request()->get('sk') == 'msg.title') selected="selected" @endif >Title</option>
                <option value="msg.body" @if( request()->get('sk') == 'msg.body') selected="selected" @endif >Body</option>
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


<div class="text-end mt-2">
    검색 기간내:  발송건 수 {{ number_format($items->total())}}명
</div>
<div class="card mt-1">
  <div class="card-body">
    <table class="table table-borderless table-striped listTable">
      <col width="*">
      <col width="*">
      <col width="*">
      <col width="*">
      <thead>
        <tr>
          <th class="text-center">Id</th>
          <th class="text-center">전송수단</th>
          <th class="text-center">Title</th>
          <th class="text-center">생성일</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $item)
        <tr user-attr-id="{{ $item->id }}">
          <td class="text-center">{{ $item->id }}</td>
          <td class="text-center">{{ $item->type }} </td>
          <td class="text-center">{{ $item->title }}<a href="{{ route('market.admin.mailer.show', $item->id) }}"><i class="fas fa-search"></i></a></td>
          <td class="text-center">{{ date("Y-m-d H:i", strtotime($item->created_at)) }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center">
            디스플레이할 데이타가 없습니다.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div><!-- .card-body -->
  <div  class="card-footer">
    {{ $items->links("pagination::bootstrap-4") }}
  </div><!-- .card-footer -->
</div><!-- .card -->
@endsection

@section('styles')
@parent
@endsection

@section('scripts')
@parent
@endsection
