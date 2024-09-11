
<div class="qna-form mb-5 mt-2">
  <!-- <form name="qna-form" method="post" 
    action="{{ route('market.item.qna', [$item->id]) }}" 
    enctype='multipart/form-data'>
      @csrf -->
  <form name="qna-form">
    <div class="card">
      <div class="card-body">
        <div class="input-group mt-1">
          <input type="text" class="form-control" name="title" placeholder="타이틀을 입력해 주세요"> 
          <input type="checkbox" name="secret" id="secret-qna" class="form-check-input ms-2" value='1'>
          <label for="secret-qna" class="form-check-label ms-1">비밀글</label>
        </div>

        <div class="input-group mt-1">
            <textarea class="form-control" aria-label="With textarea" name="content" placeholder="문의내용을 입력해 주세요"></textarea>
        </div>
      </div><!-- card-body -->
      <div class="card-footer text-end">
        <button type="button" class="btn btn-primary act-qna-submit">문의하기</button>
      </div><!-- .card-footer> -->
    </div><!-- .card -->
  </form>
</div>

@section('styles')
@parent
<style>
.qna-form {
  display: none;
}
</style>
@endsection

@section('scripts')
@parent
<script>
var item_id = '{{$item->id}}';
$(function(){

  $("#btn-open-qna-form").on('click', function(){
    $(".qna-form").show();
  })

  $(".act-qna-submit").on('click', function(){
    MARKET.ajaxroute('POST', 
    {'name': 'market.item.qna', 'params[0]': item_id}, 
    $("form[name=qna-form]").serializeObject(), 
    function(resp) {
      console.log('resp >>', resp);
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        showToaster({title: '알림', message: '상품문의가 접수되었습니다.', alert: false, url: resp.next});
        // location.reload();
      }
    })
  })
})

</script>
@endsection
