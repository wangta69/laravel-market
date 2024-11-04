
@extends('market::admin.layouts.main')
@section('title', '배송비 설정')
@section('content')
@include('market::admin.layouts.main-top', ['path'=>['환경설정', '배송비 설정']])
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
					<input type="text" name="fee" value='{{$cfg["delivery"]["fee"]}}' class="form-control">
				</div>
				<div class="col-auto">
					<span class="form-text">원</span>
				</div>
			</div>

			<div class="row align-items-center mt-1">
				<div class="col-auto">
					<input type="radio" name="type" value="none" class="form-check-input" {{ $cfg["delivery"]["type"] == 'none' ? 'checked' : '' }} >
				</div>
				<div class="col-auto">
					<span class='form-text'>배송비 미 적용</span>
				</div>
			</div>

			<div class="row align-items-center mt-1">
				<div class="col-auto">
					<input type="radio" name="type" value="apply" class="form-check-input" {{ $cfg["delivery"]["type"] == 'apply' ? 'checked' : '' }}>
				</div>
				<div class="col-auto">
					<span class='form-text'>구매액에 관계없이 배송비적용</span>
				</div>
			</div>

			<div class="row mt-1 align-items-center">
				<div class="col-auto">
					<input type="radio" name="type" value="partial" class="form-check-input" {{ $cfg["delivery"]["type"] == 'partial' ? 'checked' : '' }}>
				</div>
				<div class="col-auto">
				<span class='form-text'>상품구매액이 </span>
				</div>
				<div class="col-auto">
					<input type="text" name="min" class="form-control" value='{{$cfg["delivery"]["min"]}}' >
				</div>
				<div class="col-auto">
					<span class='form-text'>미만일 경우 배송비 적용</span>
				</div>
			</div>
{{-- 
			<input type="radio" name="delivery_fee_type" value="qty" {{ $cfg["delivery"]["delivery_fee_type"] == 'qty' ? 'checked' : '' }}>
			제품(수)당 배송비적용(
			<input type="checkbox" name="ENABLE_ADD_TACKBAE_MONEY" value='checked' {{ $cfg["padeliveryy"]["ENABLE_ADD_TACKBAE_MONEY"]}}>
			기본배송료+추가 수량당
			<input type="text" name="ADD_TACKBAE_MONEY" value='{{ $cfg["delivery"]["ADD_TACKBAE_MONEY"]}}'>
			원 추가)
			<br />

			<input type="checkbox" name="ENABLE_EXPRESS_TACKBAE_MONEY" value='checked' {{ $cfg["delivery"]["ENABLE_EXPRESS_TACKBAE_MONEY"]}}>
			추가배송료
			<input type="text" name="EXPRESS_TACKBAE_MONEY" value='{{ $cfg["delivery"]["EXPRESS_TACKBAE_MONEY"]}}' >
			(기본배송료에 추가배송료(장바구니에서 사용자 체크시 적용))
			<br /> --}}


			
			
		</div>
		<div class="card-footer text-end">
			<button type="button"class="btn btn-primary act-update-delivery">적용</button>
		</div>
	</form>
</div>
@endsection
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
