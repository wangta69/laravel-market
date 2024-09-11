<input type="hidden" name="tags">
<div class="col-10 col-lg-5">
  <div class="input-group">
    <input type="text" name="taginput" class="form-control">
    <button type="button" class="btn btn-light" id="act-add-tag"><i class="fa-solid fa-plus"></i></btn>
  </div>
</div>
<div id="sub-tag-box">
</div>

@section('styles')
@parent
<style>
#sub-tag-box .close {
  /* color: white;
  width: 24px; */
}
</style>
@endsection

@section('scripts')
@parent
<script>

var tagsObj = {!! $tags !!};
var tags = [];
// var options = {!! $options !!}
function createTagElement(str, id) {
  var ele = `<div class="bg-light me-1 rounded-3 mt-1 p-1 d-inline-block" user-tag-id="`+id+`">` +
    `<label>` + str + `</label>` +
    `<span class="btn btn-sm  close act-tag-remove">x</span>` +
    `</div>`;
  return ele;
}

function setTagValue() {
  $('input[name=tags]').val(tags.join());
}


$(function(){

  // 태그 추가
  function addTag() {
    var tag = $('input[name=taginput]').val();
    MARKET.ajaxroute('POST', 
    {'name': 'market.admin.tag'}, 
      {tag}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        array_push_unique(tags, resp.id);
        $('input[name=taginput]').val('')
        $('#sub-tag-box').append(createTagElement(tag, resp.id));
        setTagValue();
      }
    })
  }
  $("#act-add-tag").on('click', function() {
    addTag();
  })

  $("input[name=taginput]").on('keydown', function(e) {
    if(e.key === 'Enter') {
      addTag();
    }
  })

  // $(".act-tag-remove").click('on', function(){
  $('body').on('click', '.act-tag-remove', function(){
    var tag_id = $(this).parent().attr("user-tag-id");
    removeElement(tags, parseInt(tag_id));
    $(this).parent().remove();
    setTagValue();
  })

  if(tagsObj.length > 0) { // tag 가 존재하면(수정시)
    for(var i = 0; i < tagsObj.length; i++) {
      var tag = tagsObj[i];
      array_push_unique(tags, tag.id);
      $('#sub-tag-box').append(createTagElement(tag.tag, tag.id));
    }
    setTagValue();
  }
})
</script>
@endsection