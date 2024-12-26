<h5><span class="act-add-field">추가필드</span> <i class="fa-solid fa-plus act-add-field"></i></h5>
<div>추가필드 : 상품상세페이지에 단순한 출력용으로만 사용할 경우
<div id="sub-field-box">
</div>
@section('styles')
@parent
<style>
</style>
@endsection
@section('scripts')
@parent
<script>
var specs = {!! json_encode($item->specs) !!};
function createFieldElements(spec) {
  if(spec) {
    title = spec.title || '';
    comment = spec.comment || '';
  } else {
    title = ''
    comment = '';
  }
  
  var ele = `<div class="input-group mt-1">` +
    `<div class="form-floating">` +
    `  <input name="specs[name][]" value="${title}" class="form-control" placeholder="Color">` +
    `  <label>필드명</label>` +
    `</div>` +

    `<div class="form-floating">` +
    `  <input name="specs[val][]" value="${comment}" class="form-control" placeholder="Blue:1000:0|Red:2000:0">` +
    `  <label>설명</label>  ` +
    `</div>` +
  `</div>`;
  return ele;
}

$(function(){
  for(spec of specs){
    console.log('spec', spec);
    $elm = createFieldElements(spec);
    $('#sub-field-box').append($elm);
  }

  // 서브 카테고리 추가
  $(".act-add-field").click('on', function() {
    $elm = createFieldElements();
    $('#sub-field-box').append($elm);
  })
})
</script>
@endsection