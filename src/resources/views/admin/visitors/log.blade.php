@extends('market::admin.layouts.main')
@section('title', '방문자통계')
@section('content')

@include('market::admin.layouts.main-top', ['path'=>['방문자통계', '로그']])
<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">상세로그</h2>

  <div class="card">
    <div class="card-body">
      <div>방문자별 상세로그를 확인 하실 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>


<form method="get" action="{{ route('market.admin.visitors.log') }}" id="search-form" >
  <div class="card mt-1 p-2">
    <div class="card-body">
      <div class="row">

        <div class="col-6">

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

</div>
<div class="card mt-1">
  <div class="card-body">
    <table class="table table-borderless table-striped listTable">
      <col width="*">
      <col width="*">
      <col width="*">
      <col width="*">
      <col width="*">
      <col width="*">
      <thead>
        <tr>
          <th class="text-center">IP</th>
          <th class="text-center">User Id</th>
          <th class="text-center">Continent</th>
          <th class="text-center">Country</th>
          <th class="text-center">City</th>
          <th class="text-center">Device</th>
          <th class="text-center">Browser</th>
          <th class="text-center"></th>
        </tr>
      </thead>
      <tbody>

        @forelse($logs as $log)
        <tr>
          <td class="text-center">{{ $log->ip }}</td>
          <td class="text-center">{{ $log->user_id }}</a></td>
          <td class="text-center">{{ $log->continent }} </td>
          <td class="text-center">{{ $log->country }} </td>

          <td class="text-center">{{ $log->city }} </td>
          <td class="text-center">{{ $log->device }} </td>
          <td class="text-center">{{ $log->browser }} </td>
          <td class="text-center">{{ $log->referer }} </td>
          <td class="text-center">{{ $log->created_at }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center">
            디스플레이할 데이타가 없습니다.
          </td>
        </tr>
        @endforelse
      </tbody>

    </table>
  </div><!-- .card-body -->
  <div  class="card-footer">
     {{$logs->links("pagination::bootstrap-4")}}
  </div><!-- .card-footer -->
</div><!-- .card -->
@endsection
