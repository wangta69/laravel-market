<!-- 제품 찾기 odal -->
<div class="modal fade" id="findProductModal" tabindex="-1" aria-labelledby="findProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="findProductModalLabel">제품찾기</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="input-group">
          <input name="sv" value="" class="form-control">
          <button type="button" class="btn btn-success act-search-product">검색</button>
        </div>
      </div>
      <div class="modal-body result">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@section('scripts')
@parent
<script>
$(function(){
  $(".act-search-product").on('click', function(){
    var name = $(this).prev().val();
    
    ROUTE.ajaxroute('get', 
      {route: 'market.admin.items', data: {sk: 'market_items.name', sv: name}},
      function(resp) {
        console.log(resp);
        if(resp.error) {
          showToaster({title: '알림', message: resp.error});
        } else {
          var str = 
          `<table class="table">
            <tr>
              <th>이미지</th>
              <th>상품명</th>
              <th></th>
            </tr>`;

            $.each(resp.items, function(i, item) {
            str += `<tr user-attr-id="`+item.id+`" user-attr-name="`+item.name+`">
              <td><img src="`+item.image.replace("public/", "/storage/")+`" class="img-thumbnail" style="width: 50px; height: 50px;"></td>
              <td>`+item.name+`</td>
              <td><button type="button" class="btn act-set-item">적용</button></td>
            </tr>`;
            });

            str += `</table>`
        }

        console.log(str);
        $(".result").html(str);
      })
  })

  $("#findProductModal").on('click', '.act-set-item', function(){
    var id = $(this).parents('tr').attr('user-attr-id');
    $("input[name=item_id]").val(id);
    $('#findProductModal').modal('toggle');
  })
})

  
</script>

@endsection