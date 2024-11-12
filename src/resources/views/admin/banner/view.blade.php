@extends('market::admin.layouts.main')
@section('title', '베너관리')
@section('content')
@include('market::admin.layouts.main-top', ['path'=>['베너관리', '베너관리']])
<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">베너관리</h2>

  <div class="card">
    <div class="card-body">
      <div>위치별 베너관리가 가능합니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>



<div class="text-end mt-2">
<a href="{{ route('market.admin.banner.create', [$type])}}" class="btn btn-primary">생성하기</a>
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
          <th class="text-center">이미지</th>
          <th class="text-center">위치</th>
          <th class="text-center">타이틀</th>
          <th class="text-center"></th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $item)
        <tr user-attr-id="{{ $item->id }}">
          <td class="text-center"><img src="{{market_get_thumb($item->image, 50, 50)}}" class="img-thumbnail"></td>
          <td class="text-center">{{ $item->position }}</td>
          <td class="text-center">{{ $item->title }}</td>
          <td>
            <a href="{{ route('market.admin.banner.edit', ['MainTop',  $item->id])}}" class="btn btn-primary btn-sm">  수정 </a>
            <a href="" class="btn btn-danger btn-sm">  삭제 </a>
          </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">
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
<script>
var csrf_token = $("meta[name=csrf-token]" ).attr("content");
</script>
@endsection
