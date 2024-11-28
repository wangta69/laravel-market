@section('title', 'PG 설정')
<x-dynamic-component 
  component="market::app-admin" 
  :path="['환경설정', 'PG 설정']"> 

<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">PG 설정</h2>

  <div class="card">
    <div class="card-body">
      <div>숍에 사용할 PG를 변경할 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

<div class="card">
	<form name="pg-form">
		<div class="card-body">
			<div class="input-group">
				<label for='name' class='col-sm-2 col-form-label'>기본 PG</label>
				<select class="form-select" name="pg">
					@foreach($pgs as $k=>$v)
					<option value="{{$k}}" @if($k == $payment['pg']) selected @endif>{{$v}}</option>
					@endforeach
				</select>
			</div>
			<div class="input-group mt-1">
				<label class='col-sm-2 col-form-label'>상점아이디</label>
				<input name="mid" type="text" class="form-control" value="{{$payment['mid']}}">
			</div>
			<div class="input-group mt-1">
				<label class='col-sm-2 col-form-label'>사이트키</label>
				<input name="sitekey" type="text" class="form-control" value="{{$payment['sitekey']}}">
			</div>
			<!-- <div class="input-group mt-1">
				<label class='col-sm-2 col-form-label'>결제 URL</label>
				<input name="submit_url" type="text" class="form-control" value="{{$payment['submit_url']}}">
			</div> -->
			<div class="input-group mt-1">
				<label class='col-sm-2 col-form-label'></label>
				<div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="service" value="dev" @if(!$payment['service']) checked @endif>
          <label class="form-check-label">Development</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="service" value="prod" @if($payment['service']) checked @endif>
          <label class="form-check-label">Production</label>
        </div>
			</div>
			<hr>
			<div class="input-group mt-1">
				<label class='col-sm-2 col-form-label'>간편결제</label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" name="naver" value="1" @if($payment['naver']) checked @endif>
					<label class="form-check-label">Naver Pay</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="checkbox" name="kakao" value="1" @if($payment['kakao']) checked @endif>
					<label class="form-check-label">Kakao Pay</label>
				</div>
			</div>
		</div> <!-- .card-body -->

		<div class="card-footer text-end">
			<button type="button"class="btn btn-primary act-update-pg">적용</button>
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
	$(".act-update-pg").on('click', function(){
    ROUTE.ajaxroute('put', 
    {route: 'market.admin.config.pg', data: $("form[name='pg-form']").serializeObject()}, 
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