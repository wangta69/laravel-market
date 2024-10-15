@extends('market.admin.layouts.main')
@section('title', '메일테스트')
@section('content')
@include('market.admin.layouts.main-top', ['path'=>['Dev', '메일테스트']])
<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">메일테스트</h2>

  <div class="card">
    <div class="card-body">
      <div>메일의 작동유무를 확인하실 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

<div class="card">

<form method="POST" name="mail-form" action="{{ route('market.admin.dev.mail') }}">
@csrf
    <div class="card-body">
    <div class="input-group">
        <label class='col-sm-3 col-form-label'>메일타입</label>
        <select class="form-select" name="type">
        <option value="">선택</option>
          <option value="notice">알림</option>
          <option value="order">주문</option>
          <option value="register">회원가입</option>
        </select>
      </div>
      <div class="input-group mt-1">
        <label class='col-sm-3 col-form-label'>To(users.id)</label>
        <input type="text" name="to" class="form-control" value="">
      </div>

      <div class="input-group mt-1">
        <label class='col-sm-3 col-form-label'> subject</label>
        <input type="text" name="subject" class="form-control" value="">
      </div>

      <div class="input-group mt-1">
        <label class='col-sm-3 col-form-label'>message (알림)</label>
        <textarea name="message" class="form-control"></textarea>
      </div>

      <div class="input-group mt-1">
        <label class='col-sm-3 col-form-label'>o_id(주문)</label>
        <input type="text" name="o_id" class="form-control" value="">
      </div>

    </div><!-- .card-body -->
    <div class="card-footer text-end">
      <button type="button" class="btn btn-primary act-mail-preview">미리보기</button>
      <button type="submit" class="btn btn-primary ">발송</button>
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
  $(".act-mail-preview").on('click', function(){
    ROUTE.routetostring({route: 'market.admin.dev.mail.preview', segments: $("form[name='mail-form']").serialize(), },
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        // location.href=resp.url;
        window.open(resp.url, '', '');
      }
    })
  });
})
</script>
@endsection