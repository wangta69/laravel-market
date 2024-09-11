@extends('market.admin.layouts.main')
@section('title', 'Dashboard')
@section('content')

@include('market.admin.layouts.main-top', ['path'=>['대쉬보드']])

<div class="row">
  <div class="col-6">
    <div class="card">
      <div class="card-header">
        <span>최근 가입 회원</span>
      </div><!-- .card-header -->
      <div class="card-body">
        <table class="table">
          <col width="*">
          <col width="120px">
          @forelse ($users as $user)
          <tr>
            <td>{{ $user->name }} ({{ $user->email }}) <span onclick="win_user('{{ route('market.admin.user', $user->id) }}')"><i class="fas fa-search"></i></span></td>  
            <td>{{ date('m-d H:m', strtotime($user->created_at)) }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="2">최근 가입된 회원이 존재하지 않습니다.</td>
          </tr>
          @endforelse
        </table>
      </div><!-- .card-body -->
      <div class="card-footer text-end">
        <a href="{{ route('market.admin.users') }}" class="btn btn-primary btn-sm">더 보기</a>
      </div><!-- .card-footer -->
    </div><!-- .card -->
  </div>

  <div class="col-6">
    <div class="card">
      <div class="card-header">
        <span>최근 주문 내역</span>
      </div>
      <div class="card-body">
        <table class="table">
          <col width="*">
          <col width="120px">
          @forelse ($orders as $order)
          <tr>
            <td><a href="{{ route('market.admin.order', [$order->o_id]) }}">{{$order->name}} @if($order->count > 1 ) 외 {{($order->count - 1)}}건 @endif</a></td>  
            <td>{{ date('m-d H:m', strtotime($order->created_at)) }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="2">최근 주문내역이 존재하지 않습니다.</td>
          </tr>
          @endforelse
        </table>
      </div><!-- .card-body -->
      <div class="card-footer text-end">
        <a href="{{ route('market.admin.orders') }}" class="btn btn-primary btn-sm">더 보기</a>
      </div><!-- .card-footer -->
    </div><!-- .card -->
  </div>
</div><!-- .row -->
<div class="line"></div>
<div class="row">
<div class="col-6">
    <div class="card">
      <div class="card-header">
        <span>상품문의</span>
      </div><!-- .card-header -->
      <div class="card-body">
        <table class="table">
          <col width="120px">
          <col width="*">
          <col width="120px">
          <col width="120px">
          @forelse ($qnas as $item)
          <tr>
            <td>
              <img src="{{market_get_thumb($item->image, 50, 50)}}" class="img-thumbnail">  
              <div>{{ $item->name }}</div>
            </td>
            <td>{{ $item->title }}</td>  
            <td>{{ date('m-d H:m', strtotime($user->created_at)) }}</td>
            <td>
            @if($item->reply) 
              <span class="btn btn-secondary btn-sm">답변완료</span> 
            @else 
              <span class="btn btn-warning btn-sm">답변준비중</span> 
            @endif

            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4">최근 상품문의가 존재하지 않습니다.</td>
          </tr>
          @endforelse
        </table>
      </div><!-- .card-body -->
      <div class="card-footer text-end">
        <a href="{{ route('market.admin.qnas') }}" class="btn btn-primary btn-sm">더 보기</a>
      </div><!-- .card-footer -->
    </div><!-- .card -->
  </div>

  <div class="col-6">
    <div class="card">
      <div class="card-header">
        <span>리뷰</span>
      </div>
      <div class="card-body">
        <table class="table">
          <col width="120px">
          <col width="*">
          <col width="120px">
          @forelse ($reviews as $item)
          <tr>
            <td>
              <div class="position-relative">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{$item->rating}}</span>
                <span class="visually-hidden">rating</span>
              </div>
              <img src="{{market_get_thumb($item->image, 50, 50)}}" class="img-thumbnail">  
              <div>{{ $item->name }}</div>
            </td>  
            <td>
              <span class="d-inline-block text-truncate" style="max-width: 250px;">
                {{ $item->content }}
              </span>
            </td>
            <td>{{ date('m-d H:m', strtotime($order->created_at)) }}</td>
          </tr>
          @empty
          <tr>
            <td>최근 리뷰가 존재하지 않습니다.</td>
          </tr>
          @endforelse
        </table>
      </div><!-- .card-body -->
      <div class="card-footer text-end">
        <a href="{{ route('market.admin.reviews') }}" class="btn btn-primary btn-sm">더 보기</a>
      </div><!-- .card-footer -->
    </div><!-- .card -->
  </div>
</div>




@endsection
@section('styles')
    @parent


        
@endsection
@section('scripts')
    @parent

    @endsection
