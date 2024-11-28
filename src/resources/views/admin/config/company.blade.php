@section('title', '쇼핑몰정보 설정')
<x-dynamic-component 
  component="market::app-admin" 
  :path="['환경설정', '쇼핑몰정보 설정']"> 

<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">쇼핑몰정보 설정</h2>

  <div class="card">
    <div class="card-body">
      <div>쇼핑몰정보에 대한 설정을 변경할 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

<div class="card">
  <form name="company-form">
		@csrf
		@method('PUT')
		<div class="card-body">
			<div class="input-group">
				<label class='col-sm-2 col-form-label'>쇼핑몰명</label>
				<span>쇼핑몰명은 .env 파일의 APP_NAME 에서 설정 하시기 바랍니다.</span>
			</div>
			<div class="input-group mt-1">
				<label class='col-sm-2 col-form-label'>상호</label>
				<input name="name" type="text" class="form-control" value="{{$company['name']}}">
			</div>
			<div class="input-group mt-1">
				<label class='col-sm-2 col-form-label'>사업자등록번호</label>
				<input name="businessNumber" type="text" class="form-control" value="{{$company['businessNumber']}}">
			</div>
      <div class="input-group mt-1">
				<label class='col-sm-2 col-form-label'>통신판매업신고번호</label>
				<input name="mailOrderSalesRegistrationNumber" type="text" class="form-control" value="{{$company['mailOrderSalesRegistrationNumber']}}">
      </div>
      <div class="input-group mt-1">
				<label class='col-sm-2 col-form-label'>사업장주소</label>
				<input name="address" type="text" class="form-control" value="{{$company['address']}}">
      </div>
      <div class="input-group mt-1">
				<label class='col-sm-2 col-form-label'>대표자명</label>
				<input name="representative" type="text" class="form-control" value="{{$company['representative']}}">
      </div>
      <div class="input-group mt-1">
				<label class='col-sm-2 col-form-label'>연락처</label>
				<input name="tel1" type="text" class="form-control" value="{{$company['tel1']}}">
      </div>
      <div class="input-group mt-1">
				<label class='col-sm-2 col-form-label'>팩스</label>
				<input name="fax1" type="text" class="form-control" value="{{$company['fax1']}}">
      </div>
		</div> <!-- .card-body -->

		<div class="card-footer text-end">
			<!-- <button type="submit"class="btn btn-primary">적용</button> -->
      <button type="button"class="btn btn-primary act-update-company">적용</button>
		</div> <!-- .card-footer -->
	</form>
</div><!-- .card -->

@section('styles')
@parent
@endsection

@section('scripts')
@parent
<script>
$(function(){
	$(".act-update-company").on('click', function(){
    ROUTE.ajaxroute('put', 
    {route: 'market.admin.config.company', data: $("form[name='company-form']").serializeObject()}, 
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
</x-dynamic-component>