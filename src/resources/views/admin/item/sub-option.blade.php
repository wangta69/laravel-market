<h5><span class="act-add-option">옵션</span> <i class="fa-solid fa-plus act-add-option"></i></h5>
<div>옵션등록법 : 옵션1:추가가격1:재고여부1|옵션2:추가가격1:재고여부2 (예, blue:0:1|red:1000:0) (재고여부 : 0: 품절, 1: 재고있음)
<div id="sub-option-box">
</div>
@section('styles')
@parent
<style>
</style>
@endsection
@section('scripts')
@parent
<script>
var options = {!! $options !!};
function createOptionElements(title, val) {
  title = title || '';
  val = val || '';
  var ele = `<div class="input-group mt-1">` +
    `<div class="form-floating">` +
    `  <input name="option[name][]" value="${title}" class="form-control" placeholder="Color">` +
    `  <label>옵션명</label>` +
    `</div>` +

    `<div class="form-floating">` +
    `  <input name="option[val][]" value="${val}" class="form-control" placeholder="Blue:1000:0|Red:2000:0">` +
    `  <label>옵션</label>  ` +
    `</div>` +
  `</div>`;
  return ele;
}

$(function(){
  for(title in options){
    $elm = createOptionElements(title, options[title]);
    $('#sub-option-box').append($elm);
  }

  // 서브 카테고리 추가
  $(".act-add-option").click('on', function() {
    $elm = createOptionElements();
    $('#sub-option-box').append($elm);
  })
})
</script>
@endsection