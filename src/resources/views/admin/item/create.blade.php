@section('title', '상품등록')
<x-dynamic-component 
  component="market::app-admin" 
  :path="['상품관리', '상품등록']"> 

<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">상품등록</h2>

  <div class="card">
    <div class="card-body">
      <div>상품 등록 및 수정이 가능합니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

@if($item->id)
<form method="POST" action="{{ route('market.admin.item',[$item->id] ) }}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';" >
  @method('PUT')
@else
<form method="POST" action="{{ route('market.admin.item.store') }}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
@endif
@csrf

  <div class="card mt-1 p-2">
    <div class="card-body">

      <table class="table">
        <col width="120px" />
        <col width="*" />
        <tr>
          <th>카테고리</th>
          <td>@include("market::admin.item.sub-category", ['category'=>$categories])</td>
        </tr>
        <tr>
          <th>상품명</th>
          <td><input name="name" value="{{$item->name}}" class="form-control"></td>
        </tr>
        <tr>
          <th>상품모델명</th>
          <td><input name="model" value="{{$item->model}}" class="form-control">- 사용하지 않을경우 공백처리</td>
        </tr>
        <tr>
          <th>시중가</th>
          <td><input name="cost" value="{{number_format($item->cost)}}" class="form-control" onkeyup="this.value = add_comma(this.value)"></td>
        </tr>
        <tr>
          <th>판매가</th>
          <td><input name="price" value="{{number_format($item->price)}}" class="form-control" onkeyup="this.value = add_comma(this.value)"></td>
        </tr>
        <tr>
          <th>지급포인트</th>
          <td><input name="t_point" value="{{number_format($item->t_point)}}" class="form-control" onkeyup="this.value = add_comma(this.value)"></td>
        </tr>
        <tr>
          <th>재고수량</th>
          <td><input name="stock" value="{{$item->stock}}" class="form-control">제한없음(-1), 품절(0), 기타 재고수량 입력</td>
        </tr>
        <tr>
          <th>등록옵션</th>
          <td>@include("market::admin.item.sub-option", [])</td>
        </tr>
        <tr>
          <th>추가필드</th>
          <td>@include("market::admin.item.sub-spec", [])</td>
        </tr>
        <tr>
          <th>이미지</th>
          <td>@include("market::admin.item.sub-image", ['images'=>$images])</td>
        </tr>
        <tr>
          <th>간략설명</th>
          <td><textarea name="shorten_description" class="form-control">{{$item->shorten_description}}</textarea></td>
        </tr>
        <tr>
          <th>자세한설명</th>
          <td>
          @include ('editor::default', ['name'=>'description', 'id'=>'description', 'value'=>$item->description, 'attr'=>['class'=>'form-control']])
          </td>
        </tr>
        <tr>
          <th>태그</th>
          <td>@include("market::admin.item.sub-tag")</td>
        </tr>
        <tr>
          <th>표시 옵션</th>
          <td class="input-group">
            <div class="form-check">
              <input class="form-check-input" name="display[main] "type="checkbox" value="" id="display-main" 
                  @if( in_array('main', $display)) checked="checked" @endif>
              <label class="form-check-label" for="display-main">메인노출</label>
            </div>
            <div class="ms-4 form-check">
              <input class="form-check-input" name="display[rec] "type="checkbox" value="" id="display-rec"
                  @if( in_array('rec', $display)) checked="checked" @endif>
              <label class="form-check-label" for="display-rec">추천</label>
            </div>
            <div class="ms-4 form-check">
              <input class="form-check-input" name="display[new] "type="checkbox" value="" id="display-new"
                  @if( in_array('new', $display)) checked="checked" @endif>
              <label class="form-check-label" for="display-new">신규</label>
            </div>
            <div class="ms-4 form-check">
              <input class="form-check-input" name="display[hit] "type="checkbox" value="" id="display-hit"
                  @if( in_array('hit', $display)) checked="checked" @endif>
              <label class="form-check-label" for="display-hit">인기</label>
            </div>
          </td>
        </tr>
      </table>
    </div><!-- .card-body -->
    
    @if($item->id)
    <div class="card-footer text-end" user-attr-id="{{$item->id}}">
      <button type="submit" class="btn btn-primary">제품수정</button> <!-- onclick="submitContents(this);" -->
      <button type="button" class="btn btn-danger btn-delete">제품삭제</button>
    </div>
    @else
    <div class="card-footer text-end">
      <button type="submit" class="btn btn-primary">제품등록</button> <!--  onclick="submitContents(this);" -->
    </div>
    @endif
  </div><!-- .card -->
</form>

@section('styles')
@parent
@endsection

@section('scripts')
@parent
<script>
var listUrl = "{{ route('market.admin.items') }}";
$(function () {
  $(".btn-delete").on('click', function () {
    var item_id = $(this).parent().attr("user-attr-id");

    ROUTE.ajaxroute('DELETE', 
      {route: 'market.admin.item', segments: [item_id]}, 
      function(resp) {
        if(resp.error) {
          showToaster({title: '알림', message: resp.error});
        } else {
          location.href = listUrl;
        }
      })
  })
})

</script>

@endsection
</x-dynamic-component>