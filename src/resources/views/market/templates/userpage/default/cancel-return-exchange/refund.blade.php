@extends('market.templates.layouts.'.config('market.template.layout.theme').'.front')
@section('content')

<div class="container body">
  <div class="row">
    <div class="col-3">
      @include('market.templates.userpage.'.config('market.template.userpage.theme').'.tabs')
    </div>
    <div class="col-9">


    <ul class="nav nav-tabs mt-5">
      <li class="nav-item">
        <a class="nav-link " aria-current="page" href="{{ route('market.mypage.order.cancel-return-exchanges') }}">교환/반품</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="{{ route('market.mypage.order.refund') }}">무통장환불</a>
      </li>
    </ul>



      <div class="card mt-1">

        <div class="card-body">
          <div class="row">
            <div class="col-5">무통장환불계좌 정보</div>
            <div class="col-7">
              @if($bank->id)
              {{ config('market.banks.'.$bank->code.'.name') }} {{ $bank->no }} (예금주: {{ $bank->owner }}) <span data-bs-toggle="modal" data-bs-target="#bankCreateModal">[수정]</span>
              @else
                <span data-bs-toggle="modal" data-bs-target="#bankCreateModal">[등록]</span>
              @endif
            </div>
          </div>
        </div> <!-- .card-body -->
      </div> <!-- card -->


    </div>
  </div>
</div>
<!-- /banner-feature -->

<!-- Modal for bank create start -->
<div class="modal fade" id="bankCreateModal" tabindex="-1" aria-labelledby="bankCreateModalLabel" aria-hidden="true">
  <form method="post" name="bank-create-form" action="{{ route('market.mypage.order.refund') }}" >
  @csrf
    <input type="hidden" name="id" value="{{$bank->id}}">

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          @if($bank->id)
          <h5 class="modal-title" id="bankCreateModalLabel">환불계좌 변경</h5>
          @else
          <h5 class="modal-title" id="bankCreateModalLabel">환불계좌 등록</h5>
          @endif
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="input-group mt-1">
            <label class="col-sm-3 col-form-label">은행명</label>

            <select name="code" class="form-select">
              @foreach($codes as $k=>$v)
              <option value="{{$k}}" @if($bank->code == $k) selected @endif>{{$v['name']}}</option>
              @endforeach
            </select>
          </div>
          <div class="input-group mt-1">
            <label class="col-sm-3 col-form-label">계좌번호</label>
            <input class="form-control" type="text" name="no" value="{{$bank->no}}">
          </div>
          <div class="input-group mt-1">
            <label class="col-sm-3 col-form-label">예금주</label>
            <input class="form-control" type="text" name="owner" value="{{$bank->owner}}">
          </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
          @if($bank->id)
          <button type="button" class="btn btn-primary act-create-bank" id="btn-change-email">변경하기</button>
          @else
          <button type="button" class="btn btn-primary act-create-bank" id="btn-change-email">등록하기</button>
          @endif
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal for bank create end -->

@endsection

@section('styles')
@parent
@endsection

@section('scripts')
@parent
<script>

$(function(){
  
  // 카운트 업/다운
  $(".act-create-bank").on('click', function(){
    ROUTE.ajaxroute('POST', 
    {route: 'market.mypage.order.refund', data: $("form[name='bank-create-form']").serializeObject()}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        // showToaster({title: '알림', message: '처리되었습니다.', alert: false});
        location.reload();
      }
    })
  })



})
</script>
@endsection
