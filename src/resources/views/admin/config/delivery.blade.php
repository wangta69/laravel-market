
@section('title', '배송비 설정')
<x-dynamic-component 
  component="market::app-admin" 
  :path="['환경설정', '배송비 설정']"> 

<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">배송비 설정</h2>

  <div class="card">
    <div class="card-body">
      <div>배송비 관련 설정을 변경할 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>


<div class="card">
	<form name="delivery-fee-form">
		<div class="card-body">

			<div class="row align-items-center mt-1">	
				<div class="col-auto">
					<span class='form-text'>배송비</span>
				</div>
				<div class="col-auto">
					<input type="text" name="fee" value='{{ $delivery->fee }}' class="form-control">
				</div>
				<div class="col-auto">
					<span class="form-text">원</span>
				</div>
			</div>

			<div class="row align-items-center mt-1">
				<div class="col-auto">
					<input type="radio" name="type" value="none" class="form-check-input" {{ $delivery->type == 'none' ? 'checked' : '' }} >
				</div>
				<div class="col-auto">
					<span class='form-text'>배송비 무료</span>
				</div>
			</div>

			<div class="row align-items-center mt-1">
				<div class="col-auto">
					<input type="radio" name="type" value="on_delivery" class="form-check-input" {{ $delivery->type == 'on_delivery' ? 'checked' : '' }} >
				</div>
				<div class="col-auto">
					<span class='form-text'>배송비 착불</span>
				</div>
			</div>

			<div class="row align-items-center mt-1">
				<div class="col-auto">
					<input type="radio" name="type" value="apply" class="form-check-input" {{ $delivery->type == 'apply' ? 'checked' : '' }}>
				</div>
				<div class="col-auto">
					<span class='form-text'>구매액에 관계없이 배송비적용</span>
				</div>
			</div>

			<div class="row mt-1 align-items-center">
				<div class="col-auto">
					<input type="radio" name="type" value="partial" class="form-check-input" {{ $delivery->type == 'partial' ? 'checked' : '' }}>
				</div>
				<div class="col-auto">
				<span class='form-text'>상품구매액이 </span>
				</div>
				<div class="col-auto">
					<input type="text" name="min" class="form-control" value='{{ $delivery->min }}' >
				</div>
				<div class="col-auto">
					<span class='form-text'>미만일 경우 배송비 적용</span>
				</div>
			</div>
		
			
		</div>
		<div class="card-footer text-end">
			<button type="button"class="btn btn-primary act-update-delivery">적용</button>
		</div>
	</form>
</div>

@section('styles')
  @parent
@endsection

@section('scripts')
  @parent
<script>


$(function(){
	$(".act-update-delivery").on('click', function(){
		ROUTE.ajaxroute('POST', 
    {route: 'market.admin.config.delivery', data: $("form[name='delivery-fee-form']").serializeObject()}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        showToaster({title: '알림', message: '처리되었습니다.', alert: false});
        callback();
      }
    })
	})
})
</script>
@endsection
</x-dynamic-component>
