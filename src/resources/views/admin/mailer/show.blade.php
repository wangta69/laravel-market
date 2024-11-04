@extends('market::admin.layouts.main')
@section('title', '리뷰')
@section('content')
@include('market::admin.layouts.main-top', ['path'=>['메일', '발송리스트']])
<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">발송리스트</h2>

  <div class="card">
    <div class="card-body">
      <div>발송내역입니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>


  <div class="card mt-1 p-2">
    <div class="card-body">
        <table class="table">
          <tr>
            <td>title</td>
            <td>{{$message->title}}</td>
          </tr>
          <tr>
            <td>body</td>
            <td>{!! $message->body !!}</td>
          </tr>
          <tr>
            <td>type</td>
            <td>{{$message->type}}</td>
          </tr>
          <tr>
            <td>created at</td>
            <td>{{$message->created_at}}</td>
          </tr>
        </table>
    </div><!-- .card-body -->
  </div><!-- .card -->



<div class="text-end mt-2">
    발송건 수 {{ number_format($items->total())}}명
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
          <th class="text-center">
            email
          </th>
          <th class="text-center">
            name
          </th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $item)
        <tr>
          <td class="text-center">{{ $item->email }}</td>
          <td class="text-center">{{ $item->name }} </td>
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
