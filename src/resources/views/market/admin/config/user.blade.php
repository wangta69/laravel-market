@extends('market.admin.layouts.main')
@section('title', '회원가입 설정')
@section('content')
@include('market.admin.layouts.main-top', ['path'=>['환경설정', '회원가입 설정']])
<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">회원가입 설정</h2>

  <div class="card">
    <div class="card-body">
      <div>회원가입시 다양한 설정을 변경할 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

<div class="card">
	 <!-- <form name="user-form" method="POST" action="{{ route('market.admin.config.user') }}" onsubmit="return checkUserForm();">
    @csrf
    @method('PUT') -->
  <form name="user-form">
		<div class="card-body">
			<div class="input-group">
				<label for='name' class='col-sm-2 col-form-label'>회원 활성</label>
				<select class="form-select" name="active">
          <option value="auto" @if($user['active'] == "auto") selected @endif>회원가입시</option>
          <option value="email" @if($user['active'] == "email") selected @endif>이메일 인증시</option>
          <option value="admin" @if($user['active'] == "admin") selected @endif>관리자 별도 인증</option>
				</select>
			</div>
			<div class="input-group mt-1">
        <div class="col-2">
				  <label class='form-label'>이용약관</label>
        </div>
        <div class="col-10">

          <x-editor-components 
            name="termsOfUse" 
            id="termsOfUse" 
            :value=$termsOfUse 
            :attr="['class'=>'form-control']"
            type="start" />
        </div>
			</div>
			<div class="row mt-1">
        <div class="col-2">
				  <label class='form-label'>개인정보 수집 및 이용</label>
        </div>

        <div class="col-10">
        <x-editor-components 
          name="privacyPolicy" 
          id="privacyPolicy" 
          :value=$privacyPolicy 
          :attr="['class'=>'form-control']"
          type="end"/>

        </div>

			</div>
		</div> <!-- .card-body -->

		<div class="card-footer text-end">
			<!-- <button type="submit"class="btn btn-primary">적용</button> -->
      <button type="button"class="btn btn-primary act-update-user">적용</button>
		</div> <!-- .card-footer -->
	</form>
</div><!-- .card -->

@endsection

@section('styles')
@parent
@endsection

@section('scripts')
@parent
<script>
function checkUserForm() {
  updateContentsField();
  return true;
}
$(function(){
	$(".act-update-user").on('click', function(){
    updateContentsField();
    MARKET.ajaxroute('put', 
    {'name': 'market.admin.config.user'}, 
		$("form[name='user-form']").serializeObject(), 
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