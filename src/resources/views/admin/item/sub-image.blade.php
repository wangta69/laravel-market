<h5>대표이미지</h5>
<div id="main-image-box">
  <div class="input-group">
    <input type='file' name='files[0]' class="form-control" value="adfadsfaf">
    @if($item->image)
    <img src="{{market_get_thumb($item->image, 30, 30)}}" class="img-thumbnail">
    @endif
  </div>
</div>
<h5><span class="act-add-image">서브이미지</span> <i class="fa-solid fa-plus act-add-image"></i></h5>
<div id="sub-image-box">
</div>
@section('styles')
@parent
<style>
  .prod-image {
    width: 38px;
    height: 38px;
  }
</style>
@endsection
@section('scripts')
@parent
<script>
var images = {!! $images !!}
function createImageElements(src) {
  src = src ? src.replace('public/', '/storage/'): '';
  var ele = `<div class="input-group image-box mt-1">` + 
  `<input type='file' name='files[]' class="form-control">`;
  if (src) {
    ele = ele + `<img src="${src}" class="prod-image">`;
  }
  ele = ele + `</div>`;

  return ele;
}

function showImageField() {
  if (images.length <= 1) return;
  for(var i = 1; i < images.length; i++) {
    var src = images[i].image;
    $elm = createImageElements(src);
    $('#sub-image-box').append($elm);
    var index = $(".category-box").length;
  }
}

$(function(){

  // 서브 카테고리 추가
  $(".act-add-image").click('on', function() {
    $elm = createImageElements();
    $('#sub-image-box').append($elm);
    var index = $(".category-box").length;
  })

  showImageField() 
})
</script>
@endsection