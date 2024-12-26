<div class="modal fade" id="addressCreateModal" tabindex="-1">
  <form name="address-form">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">배송지 등록</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="row">
            <label for="name" class="col-sm-3 col-form-label">이름</label>
            <div class="col-sm-9">
              <input type="text" name="name" class="form-control" value="">
            </div>
          </div>
        
          <div class="row mt-1">
            <label for="" class="col-sm-3 col-form-label">배송지주소</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input name="zip" type="text"  maxlength="5" value=""  readonly="readonly" class="form-control">
                <button type="button" class="btn btn-primary" onclick="search_zip('address-form', 'zip', 'addr1', 'addr2');">
                  <i class="fa fa-search" aria-hidden="true"></i>
                  <span>우편번호찾기</span>
                </button>
              
              </div>
              
              <input name="addr1" type="text"  value="" readonly="readonly" class="mt-1 form-control">
              <input name="addr2" type="text"  value="" class="mt-1 form-control" placeholder="상세주소">
            </div>
          </div>

          <div class="row mt-1">
            <label for="" class="col-sm-3 col-form-label">연락처</label>
            <div class="col-sm-9">
              <div class="input-group">
                <input type="text" name="tel1" value="" class="form-control" onkeyup="this.value = add_phone_hyphen(this.value)">
              </div>
            </div>
          </div>

        </div><!-- modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
          <button type="button" class="btn btn-primary" id="btn-store-address">저장하기</button>
        </div>
      </div>
    </div>
  </form>
</div>



@section('scripts')
@parent
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="/pondol/search-zip.js"></script>
<script>
$(function(){
  // var addressCreateModal = new bootstrap.Modal(document.getElementById('addressCreateModal'), {})
  $("#btn-store-address").on('click', function(){

    ROUTE.ajaxroute('post', 
    {route: 'market.mypage.address', data: $("form[name=address-form]").serializeObject()}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        location.reload();
        // showToaster({title: '알림', message: '정상적으로 변경처리 되었습니다.', alert: false});
        // addressCreateModal.hide();
        // $('#addressCreateMod').modal('hide');
      }
    })
  }) // $("#btn-change-email").on('click', function(){

}) // $(function(){
</script>
@endsection