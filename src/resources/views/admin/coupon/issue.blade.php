@section('title', '쿠폰등록')
<x-dynamic-component 
  component="market::app-admin" 
  :path="['쿠폰관리', '쿠폰발급']"> 

<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">쿠폰발급</h2>

  <div class="card">
    <div class="card-body">
      <div>선택된 현재 쿠폰에 대하여 고객에게 쿠폰을 발급할 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

  <div class="card mt-1 p-2">
    <div class="card-body">

      <table class="table">
        <col width="120px" />
        <col width="*" />
        <tr>
          <th>쿠폰명</th>
          <td>{{$coupon->title}}</td>
        </tr>
        <tr>
          <th>쿠폰 종류</th>
          <td>@lang('market::market.coupon.apply_type.'.$coupon->apply_type)</div>
          </td>
        </tr>
        <tr class="apply-type product" style="display: none;">
          <th>적용 상품코드</th>
          <td>
            <div class="input-group">
              <input name="item_id" value="{{$coupon->item_id}}" class="form-control" readonly>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#findProductModal">검색</button>
            </div>
          </td>
        </tr>
        <tr class="apply-type category" style="display: none;">
          <th>카테고리</th>
          <td>@include("market::admin.coupon.sel-category", ['category'=>$coupon->category])</td>
        </tr>
        
      
        <tr>
          <th>총 구매금액</th>
          <td>{{number_format($coupon->min_price)}} 이상</td>
        </tr>
        <tr>
          <th rowspan="2">적용방식</th>
          <td>@lang('market::market.coupon.apply_amount_type.'.$coupon->apply_amount_type)</td>
        </tr>
        
        <tr>

          <td>
            @if($coupon->apply_amount_type == 'price')
            <div class="input-group apply-amount-type price">
              <input name="price" value="{{number_format($coupon->price)}}" class="form-control" readonly> 
              <div class="input-group-text">원</div>
            </div>
            @elseif($coupon->apply_amount_type == 'percentage')
            <div class="input-group apply-amount-type percentage">
              <input value="{{number_format($coupon->percentage)}}" class="form-control" readonly> 
              <div class="input-group-text">%</div>
              <div class="input-group-text">최대</div>
              <input  value="{{number_format($coupon->percentage_max_price)}}" class="form-control" readonnly> 
              <div class="input-group-text">미만</div>
            </div>
            @endif
          </td>
        </tr>


      </table>
    </div><!-- .card-body -->
    

    <div class="card-footer text-end" user-attr-id="{{$coupon->id}}">
      <button type="button" class="btn btn-danger btn-delete">쿠폰삭제</button>
    </div>

  </div><!-- .card -->


  <div class="card">   
    <div class="card-header">
      <span class="fw-bold">쿠폰 발급</span>
    </div>

    <form method="POST" action="{{ route('market.admin.coupon.issue', [$coupon->id]) }}" enctype="multipart/form-data">
    @csrf  
    <div class="card-body">
      <div class="mt-3">
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input act-check-to" id="to-all" name="to" value="all" {{ old('to', 'all') == 'all' ? 'checked' : '' }}>
          <label class="form-check-label" for="to-all">회원전체</label>
        </div>
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input act-check-to" id="to-individual" name="to" value="individual" {{ old('to') == 'individual' ? 'checked' : '' }}>
          <label class="form-check-label" for="cto-individual">회원개별</label>
        </div>
        <!-- 
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input act-check-to" id="to-select" name="to" value="select" {{ old('to') == 'guest' ? 'checked' : '' }}>
          <label class="form-check-label" for="to-guest">조건선택회원</label>
        </div>
-->
      </div>


      <div class="row mt-3 align-items-center d-none opt-show opt-show-to-individual">
        <label class="col col-md-2 form-control-label fw-bold">회원 id</label>
        <div class="col col-md-10">

          <input type="text" name="recv_users" value="{{ old('recv_users') }}"
          placeholder="다중 회원일 경우 ','를 사용하여 id(숫자)를 입력해주세요." class="form-control">
        </div>
      </div>

      <div class="row mt-3 align-items-center d-none opt-show opt-show-to-select">
        <label class="col col-md-2 form-control-label fw-bold">선택</label>
        <div class="col col-md-10">

         .........
        </div>
      </div>

      <div class="row mt-3 align-items-center">
        <label class="col col-md-2 form-control-label fw-bold">유효기간</label>
        <div class="col col-md-10">
          <div class="input-group">
            <input type="text" name="expired_at" class="form-control" id="to-date" value="{{ request()->to_date}}" readonly>
            <i class="fa fa-calendar to-calendar input-group-text"></i>
          </div>
        </div>
      </div>

    </div>

    <div class="card-footer">
      <button type="submit" class="btn btn-primary btn-sm">
        <i class="fa fa-check-circle"></i> 쿠폰 발급
      </button>

      @if (!$errors->isEmpty())
        <div class="alert alert-danger" role="alert">
        {!! $errors->first() !!}
        </div>
      @endif
    </div>
    

  </form>
</div>



@section('styles')
@parent
@endsection

@section('scripts')
@parent
<script>
var to = "{{old('to')}}";
function showhide_option(v) {
  console.log('showhide_option:', v);
  $(".opt-show").addClass('d-none');
  switch(v) {
    case 'individual': 
      $(".opt-show-to-individual").removeClass('d-none');break;
    case 'select': 
      $(".opt-show-to-select").removeClass('d-none');break;


  }
}

showhide_option(to);
$(function(){
  $(".act-check-to").on('click', function(){
    var v = $(this).val();
    showhide_option(v) 

  })
})
</script>
@endsection
</x-dynamic-component>