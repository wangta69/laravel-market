@extends('market::admin.layouts.main')
@section('title', 'SMS 설정')
@section('content')
@include('market::admin.layouts.main-top', ['path'=>['환경설정', 'SMS 설정']])
<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">SMS 설정</h2>

  <div class="card">
    <div class="card-body">
      <div>숍에 사용할 SMS를 변경할 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

<div class="card">

  <form name="sms-form">
    <div class="card-body">

      <div class="input-group">
        <label class='col-sm-3 col-form-label'>SMS 업체</label>
        <select class="form-select" name="vendor">
          @foreach($vendors as $k=>$v)
          <option value="{{$k}}" @if($k == $sms['vendor']) selected @endif>{{$v}}</option>
          @endforeach
        </select>
      </div>
      
      <div class="input-group mt-1">
        <label class='col-sm-3 col-form-label'> </label>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="manager_rec_order" value="1" @if($sms['manager_rec_order']) checked @endif>
          <label class="form-check-label">주문접수시 관리자 문자수신</label>
        </div>
      </div>

      <div class="input-group mt-1">
        <label class='col-sm-3 col-form-label'>Mobil No.</label>
        <input type="text" name="sender" class="form-control" value="{{ $sms['sender'] }}">
      </div>

      <div class="input-group mt-1">
        <label class='col-sm-3 col-form-label'>SMS ID</label>
        <input type="text" name="id" class="form-control" value="{{ $sms['id'] }}">
      </div>

      <div class="input-group mt-1">
        <label class='col-sm-3 col-form-label'>SMS PWD</label>
        <input type="text" name="key" class="form-control" value="{{ $sms['key'] }}">
      </div>

    </div><!-- .card-body -->
    <div class="card-footer text-end">
      <button type="button" class="btn btn-primary act-sms-save">설정완료</button>
    </div><!-- .card-footer -->
  </form>
</div><!-- . card --><!-- .card-body -->
@endsection

@section('styles')
  @parent
@endsection

@section('scripts')
  @parent
  <script>
$(function(){
	$(".act-sms-save").on('click', function(){
    ROUTE.ajaxroute('put', 
    {route: 'market.admin.config.sms', data: $("form[name='sms-form']").serializeObject()}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        showToaster({title: '알림', message: '처리되었습니다.', alert: false});
      }
    })
	})
})
</script>
@endsection