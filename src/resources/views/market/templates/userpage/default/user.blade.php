@extends('market.templates.layouts.'.config('market.template.layout.theme').'.front')
@section('title', '개인정보')
@section('content')
<div class="container body">

  <div class="row">
    <div class="col-3">
      @include('market.templates.userpage.'.config('market.template.userpage.theme').'.tabs')
    </div>
    <div class="col-9">
      <div class="card mt-5">
        <div class="card-header">
          <h4>개인정보</h4>
        </div>
        <div class="card-body">
          <h5 class="card-title">{{$user->name}} 님의 개인정보 입니다.</h5>
          
          <div class="input-group mt-5">
            <label class='col-sm-2 col-form-label'>이메일</label>
            <span class="btn btn-warning disabled"><i class="fa fa-envelope"></i></span>
            <input type="text" id="user-email" class="form-control" value="{{$user->email}}" disabled>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#emailChangeModal"><i class="fa fa-pen-to-square"></i></button>
          </div>

          <div class="input-group mt-1">
            <label class='col-sm-2 col-form-label'>연락처</label>
            <span class="btn btn-warning disabled"><i class="fa-solid fa-square-phone"></i></span>
            <input type="text" id="user-mobile" class="form-control" value="{{addHypenToMobile($user->mobile)}}" disabled>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#mobileChangeModal"><i class="fa fa-pen-to-square"></i></button>
          </div>

          <div class="input-group mt-1">
            <label class='col-sm-2 col-form-label'>비밀번호</label>
            <span class="btn btn-warning disabled"><i class="fa fa-lock"></i></span>
            <input type="text" class="form-control" value="**********" disabled>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#passwordChangeModal"><i class="fa fa-pen-to-square"></i></button>
            
          </div>
        </div>
      </div><!-- .card -->

    </div>
  </div>
</div><!-- .container -->

<!-- /banner-feature -->

<!-- Modal for email change start -->
<div class="modal fade" id="emailChangeModal" tabindex="-1" aria-labelledby="emailChangeModalLabel" aria-hidden="true">
  <form name="email-change-form">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="emailChangeModalLabel">이메일 변경</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="input-group">
          
          <label class='col-sm-4 col-form-label'>이메일</label>
          <span class="btn btn-warning disabled"><i class="fa fa-envelope"></i></span>
          <input type="email" name="email" class="form-control" value="{{$user->email}}">
        </div>
        <span style="font-size: small; color: red;">* 보안을 위해 현재 비밀번호를 입력해 주세요</span>
        <div class="input-group mt-1">
          <label class='col-sm-4 col-form-label'>현재 비밀번호</label>
          <span class="btn btn-warning disabled"><i class="fa fa-lock"></i></span>
          <input type="password" name="password" class="form-control">
        </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
          <button type="button" class="btn btn-primary" id="btn-change-email">변경하기</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal for email change end -->
 <!-- Modal for mobile change start -->
<div class="modal fade" id="mobileChangeModal" tabindex="-1" aria-labelledby="mobileChangeModalLabel" aria-hidden="true">
  <form name="mobile-change-form">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mobileChangeModalLabel">연락처 변경</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="input-group">
          
          <label class='col-sm-4 col-form-label'>연락처</label>
          <span class="btn btn-warning disabled"><i class="fa fa-envelope"></i></span>
         <input type="text" name="mobile" class="form-control" value="{{addHypenToMobile($user->mobile)}}" onkeyup="this.value = add_phone_hyphen(this.value)">
        </div>
        <span style="font-size: small; color: red;">* 보안을 위해 현재 비밀번호를 입력해 주세요</span>
        <div class="input-group mt-1">
          <label class='col-sm-4 col-form-label'>현재 비밀번호</label>
          <span class="btn btn-warning disabled"><i class="fa fa-lock"></i></span>
          <input type="password" name="password" class="form-control">
        </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
          <button type="button" class="btn btn-primary" id="btn-change-mobile">변경하기</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal for mobile change end -->
<!-- Modal for password change start -->
<div class="modal fade" id="passwordChangeModal" tabindex="-1" aria-labelledby="passwordChangeModalLabel" aria-hidden="true">
  <form name="password-change-form">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="passwordChangeModalLabel">비밀번호 변경</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="input-group">
            <label class='col-sm-4 col-form-label'>새로운 패스워드</label>
            <span class="btn btn-warning disabled"><i class="fa fa-envelope"></i></span>
            <input type="password" name="password" class="form-control">
          </div>
          <div class="input-group">
            <label class='col-sm-4 col-form-label'> 패스워드 확인</label>
            <span class="btn btn-warning disabled"><i class="fa fa-envelope"></i></span>
            <input type="password" name="password_confirmation" class="form-control">
          </div>
          <span style="font-size: small; color: red;">* 보안을 위해 현재 비밀번호를 입력해 주세요</span>
          <div class="input-group mt-1">
            <label class='col-sm-4 col-form-label'>현재 비밀번호</label>
            <span class="btn btn-warning disabled"><i class="fa fa-lock"></i></span>
            <input type="password" name="current_password" class="form-control">
          </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
          <button type="button" class="btn btn-primary" id="btn-change-password">변경하기</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal for password change end -->
@endsection

@section('styles')
@parent
@endsection

@section('scripts')
@parent
<script>
$(function(){
  $("#btn-change-email").on('click', function(){
    MARKET.ajaxroute('put', 
    {'name': 'market.mypage.user.update.email'}, 
      $("form[name=email-change-form]").serializeObject(), 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        showToaster({title: '알림', message: '정상적으로 변경처리 되었습니다.', alert: false});
        var newEmail = $("form[name=email-change-form] input[name='email']").eq(0).val();
        $("#user-email").val(newEmail);
        $('#emailChangeModal').modal('hide');
        $("form[name=email-change-form] input[name='password']").eq(0).val(null);
      }
    })
  }) // $("#btn-change-email").on('click', function(){


  $("#btn-change-mobile").on('click', function(){
    MARKET.ajaxroute('put', 
    {'name': 'market.mypage.user.update.mobile'}, 
      $("form[name=mobile-change-form]").serializeObject(), 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        showToaster({title: '알림', message: '정상적으로 변경처리 되었습니다.', alert: false});
        var newMobile = $("form[name=mobile-change-form] input[name='mobile']").eq(0).val();
        $("#user-mobile").val(newMobile);
        $('#mobileChangeModal').modal('hide');
        $("form[name=mobile-change-form] input[name='password']").eq(0).val(null);
      }
    })
  }) // $("#btn-change-email").on('click', function(){


  $("#btn-change-password").on('click', function(){
    MARKET.ajaxroute('put', 
    {'name': 'market.mypage.user.update.password'}, 
      $("form[name=password-change-form]").serializeObject(), 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        showToaster({title: '알림', message: '정상적으로 변경처리 되었습니다', alert: false});
        var newEmail = $("form[name=password-change-form] input[name='email']").eq(0).val();
        $("#user-email").val(newEmail);
        $('#emailChangeModal').modal('hide');
        $("form[name=email-change-form] input[name='password']").eq(0).val(null);
      }
    })
  }) // $("#btn-change-email").on('click', function(){

}) // $(function(){
</script>
@endsection
