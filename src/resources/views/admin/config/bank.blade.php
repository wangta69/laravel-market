
@extends('market::admin.layouts.main')
@section('title', '무통장 입금 계좌')
@section('content')
@include('market::admin.layouts.main-top', ['path'=>['환결설정', '무통장 입금 계좌']])
<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">무통장 입금 계좌</h2>

  <div class="card">
    <div class="card-body">
      <div>무통장 입금 계좌의 설정 및 변경</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        
        <table class="table table-borderless table-striped listTable">
          <col width="*">
          <col width="*">
          <col width="*">
          <col width="*">
          <thead>
            <tr>
              <th class="text-center">은행명</th>
              <th class="text-center">계좌번호</th>
              <th class="text-center">예금주</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse($banks as $bank)
            <tr user-attr-id="{{ $bank->id }}">
              <td class="text-center">{{ config('pondol-market.banks.'.$bank->code.'.name') }}</td>
              <td class="text-center">{{ $bank->no }}</td>
              <td class="text-center">{{ $bank->owner }}</td>
              <td class="text-center">
                  <button class="btn btn-danger btn-sm act-bank-delete">삭제</button>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center">
                디스플레이할 데이타가 없습니다.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
        <div>
        {{ $banks->links("pagination::bootstrap-4") }}
        </div>


      </div><!-- .card-body -->
    </div><!-- .card -->
  </div>
  <div class="col">
    <div class="card">
      <form name="bank-create-form">
        <div class="card-body">

          <div class="input-group mt-1">
            <label class="col-sm-3 col-form-label">은행명</label>

            <select name="code" class="form-select">
              @foreach($codes as $k=>$v)
              <option value="{{$k}}">{{$v['name']}}</option>
              @endforeach
            </select>
          </div>
          <div class="input-group mt-1">
            <label class="col-sm-3 col-form-label">계좌번호</label>
            <input class="form-control" type="text" name="no">
          </div>
          <div class="input-group mt-1">
            <label class="col-sm-3 col-form-label">예금주</label>
            <input class="form-control" type="text" name="owner">
          </div>


        </div><!-- .card-body -->
        <div class="card-footer text-end">
          <button type="button" class="btn btn-primary act-bank-create">추가</button>
        </div><!-- .card-footer -->
      </form>
    </div><!-- .card -->
  </div><!--.col -->
</div><!-- .row -->


@endsection

@section('styles')
@parent
@endsection

@section('scripts')
@parent
<script>
$(function(){
  $(".act-bank-create").on('click', function(){
		ROUTE.ajaxroute('POST', 
    {route: 'market.admin.config.bank', data: $("form[name='bank-create-form']").serializeObject()}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        // showToaster({title: '알림', message: '처리되었습니다.', alert: false});
        location.reload();
      }
    })
	})

  $(".act-bank-delete").on('click', function(){
    var id = $(this).parents('tr').attr('user-attr-id')
    ROUTE.ajaxroute('delete', 
    {route: 'market.admin.config.bank.delete', segments: [id]}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        location.reload();
      }
    })
  })

})

// function deleteItem(id) { // id: cart id
//   var url =  "/market-adm/config/bank/" + id;
//   $.ajax({
//     url : url,
//     type : "delete",
//     data:{'_token': $('meta[name="csrf-token"]').attr('content')},
//     success : function(data){
//       location.reload();
//     },
//     error : function(data){
//       console.log(data);
//       alert("Error!")
//       return false;
//     }
//   })
// }
</script>
@endsection
