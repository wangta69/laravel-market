@section('title', '쿠폰등록')
<x-dynamic-component 
  component="market::app-admin" 
  :path="['쿠폰관리', '쿠폰등록']"> 

<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">쿠폰등록</h2>

  <div class="card">
    <div class="card-body">
      <div>쿠폰 등록 및 수정이 가능합니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

@if($item->id)
<form method="POST" action="{{ route('market.admin.coupon.create',[$item->id] ) }}">
  @method('PUT')
@else
<form method="POST" action="{{ route('market.admin.coupon.create') }}">
@endif
@csrf
  <div class="card mt-1 p-2">
    <div class="card-body">

      <table class="table">
        <col width="120px" />
        <col width="*" />
        <tr>
          <th>쿠폰명</th>
          <td><input name="title" value="{{$item->title}}" class="form-control"></td>
        </tr>
        <tr>
          <th>쿠폰 종류</th>
          <td>
            <div class="row">
              <div class="col-auto">
                <x-pondol::radio class="form-check-input act-switch-apply-type" name="apply_type" value="all" 
                curval="{{ old('apply_type', $item->apply_type ? $item->apply_type :'all')}}"/>
                <label class="form-check-label">전체</label>
              </div>
              <div class="col-auto">
                <x-pondol::radio class="form-check-input act-switch-apply-type" name="apply_type" value="product" 
                curval="{{ old('apply_type', $item->apply_type ? $item->apply_type :'all')}}"/>
                <label class="form-check-label">상품별</label>
              </div>
              <div class="col-auto">
                <x-pondol::radio class="form-check-input act-switch-apply-type" name="apply_type" value="category" 
                curval="{{ old('apply_type', $item->apply_type ? $item->apply_type :'all')}}"/>
                <label class="form-check-label">카테고리별</label>
              </div>
            </div>
          </td>
        </tr>
        <tr class="apply-type product" style="display: none;">
          <th>적용 상품코드</th>
          <td>
            <div class="input-group">
              <input name="item_id" value="{{$item->item_id}}" class="form-control" readonly>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#findProductModal">검색</button>
            </div>
          </td>
        </tr>
        <tr class="apply-type category" style="display: none;">
          <th>카테고리</th>
          <td>@include("market::admin.coupon.sel-category", ['category'=>$item->category])</td>
        </tr>
        
      
        <tr>
          <th>총 구매금액</th>
          <td>
            <div class="input-group">
              <input name="min_price" value="{{number_format($item->min_price)}}" class="form-control" onkeyup="this.value = add_comma(this.value)"> 
              <div class="input-group-text">이상</div>
            </div>
          </td>
        </tr>
        <tr>
          <th rowspan="2">적용방식</th>
          <td>
            <div class="row">
              <div class="col-auto">
                <x-pondol::radio class="form-check-input act-switch-apply-amount-type" name="apply_amount_type" value="price" 
                curval="{{ old('apply_amount_type', $item->apply_amount_type ? $item->apply_amount_type :'price')}}"/>
                <label class="form-check-label">금액</label>
              </div>
              <div class="col-auto">
                <x-pondol::radio class="form-check-input act-switch-apply-amount-type" name="apply_amount_type" value="percentage" 
                curval="{{ old('apply_amount_type', $item->apply_amount_type ? $item->apply_amount_type :'price')}}"/>
                <label class="form-check-label">할인율</label>
              </div>
            </div>
          </td>
        </tr>
        
        <tr>

          <td>
            <div class="input-group apply-amount-type price">
              <input name="price" value="{{number_format($item->price)}}" class="form-control" onkeyup="this.value = add_comma(this.value)"> 
              <div class="input-group-text">원</div>
            </div>
            <div class="input-group apply-amount-type percentage" style="display: none;">
              <input name="percentage" value="{{number_format($item->percentage)}}" class="form-control" onkeyup="this.value = add_comma(this.value)"> 
              <div class="input-group-text">%</div>
              <div class="input-group-text">최대</div>
              <input name="percentage_max_price" value="{{number_format($item->percentage_max_price)}}" class="form-control" onkeyup="this.value = add_comma(this.value)"> 
              <div class="input-group-text">미만</div>
            </div>
          </td>
        </tr>


      </table>
    </div><!-- .card-body -->
    
    @if($item->id)
    <div class="card-footer text-end" user-attr-id="{{$item->id}}">
      <button type="button" class="btn btn-danger btn-delete">쿠폰삭제</button>
    </div>
    @else
    <div class="card-footer text-end">
      <button type="submit" class="btn btn-primary">쿠폰등록</button> <!--  onclick="submitContents(this);" -->
    </div>
    @endif
  </div><!-- .card -->
</form>




@include("market::admin.coupon.modal-find-product")

@section('styles')
@parent
@endsection

@section('scripts')
@parent
<script>
var listUrl = "{{ route('market.admin.items') }}";
$(function () {
  // 쿠폰 종류 선택시 필요항목 활성화
  $(".act-switch-apply-type").on('click', function(){
    var apply_type = $(this).val();
    $(".apply-type").hide();
    $(".apply-type."+apply_type).show();
  })

  // 적용방식(금액,  할인율)에 따른 필요항목 활성화
  $(".act-switch-apply-amount-type").on('click', function(){
    var apply_amount_type = $(this).val();
    $(".apply-amount-type").hide();
    $(".apply-amount-type."+apply_amount_type).show();
  })


  // $(".btn-delete").on('click', function () {
  //   var item_id = $(this).parent().attr("user-attr-id");

  //   ROUTE.ajaxroute('DELETE', 
  //     {route: 'market.admin.item', segments: [item_id]}, 
  //     function(resp) {
  //       if(resp.error) {
  //         showToaster({title: '알림', message: resp.error});
  //       } else {
  //         location.href = listUrl;
  //       }
  //     })
  // })
})

</script>

@endsection
</x-dynamic-component>