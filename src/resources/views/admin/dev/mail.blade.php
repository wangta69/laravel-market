@section('title', '메일테스트')
<x-dynamic-component 
  component="market::app-admin" 
  :path="['Dev', '메일테스트']"> 

<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">메일테스트</h2>

  <div class="card">
    <div class="card-body">
      <div>메일의 작동유무를 확인하실 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

<div class="card">

<form method="POST" name="mail-form" action="{{ route('market.admin.dev.mail') }}">
@csrf
    <div class="card-body">
    <div class="input-group">
        <label class='col-sm-3 col-form-label'>메일타입</label>
        <select class="form-select" name="type">
        <option value="">선택</option>
          <option value="notice">알림</option>
          <option value="order">주문</option>
          <option value="register">회원가입</option>
          <option value="resetpassword">패스워드 찾기</option>
          
        </select>
      </div>
      <div class="input-group mt-1 element register">
        <label class='col-sm-3 col-form-label'>User Id(Number)</label>
        <input type="text" name="to" class="form-control" value="">
      </div>
      <div class="input-group mt-1 element resetpassword">
        <label class='col-sm-3 col-form-label'>Email</label>
        <input type="text" name="email" class="form-control" value="">
      </div>

      <div class="input-group mt-1 element notice">
        <label class='col-sm-3 col-form-label'> subject</label>
        <input type="text" name="subject" class="form-control" value="">
      </div>

      <div class="input-group mt-1 element notice">
        <label class='col-sm-3 col-form-label'>message (알림)</label>
        <textarea name="message" class="form-control"></textarea>
      </div>

      <div class="input-group mt-1 element order">
        <label class='col-sm-3 col-form-label'>o_id(주문)</label>
        <input type="text" name="o_id" class="form-control" value="">
      </div>

    </div><!-- .card-body -->
    <div class="card-footer text-end">
      <button type="button" class="btn btn-primary act-mail-preview">미리보기</button>
      <button type="submit" class="btn btn-primary ">발송</button>
    </div><!-- .card-footer -->
  </form>
</div><!-- . card --><!-- .card-body -->

@section('styles')
  @parent
<style>
.element {
  display: none;
}
</style>
@endsection

@section('scripts')
@parent
<script>
$(function(){
  $(".act-mail-preview").on('click', function(){
    ROUTE.routetostring({route: 'market.admin.dev.mail.preview', segments: $("form[name='mail-form']").serialize(), },
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        // location.href=resp.url;
        window.open(resp.url, '', '');
      }
    })
  });

  $("select[name='type']").on('change', function(){
    var val = $(this).val();
    $(".element").hide();
    switch(val) {
      case 'notice': //알림
        $(".element.notice").css('display', 'flex');
        break;
      case 'order': //주문
        $(".element.order").css('display', 'flex');
        break;
      case 'register': //회원가입
        $(".element.register").css('display', 'flex');
        break;
      case 'resetpassword': // 패스워드 찾기
        $(".element.resetpassword").css('display', 'flex');
        break;
    }
  })
})
</script>
@endsection
</x-dynamic-component>