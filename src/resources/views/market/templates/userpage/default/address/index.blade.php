@extends('market.templates.layouts.'.config('market.template.layout.theme').'.front')
@section('title', '개인정보')
@section('content')
<div class="container body">

  <div class="row">
    <div class="col-3">
      @include('market.templates.userpage.'.config('market.template.userpage.theme').'.tabs')
    </div>
    <div class="col-9">

      <h2 class="mt-5">배송지 관리</h2>

      <table class="table">
        <tr>
          <th>기본</th>
          <th>수령인</th>
          <th>연락처</th>
          <th>주소</th>
          <th></th>
        </tr>
      @forelse ($addresses as $adr)
        <tr user-attr-id="{{$adr->id}}">
          <td>@if($adr->default) <span class="btn btn-light btn-sm">기본</span> @endif</td>
          <td>{{$adr->name}}</td>
          <td>{{$adr->tel1}}</td>
          <td>({{$adr->zip}}) {{$adr->addr1}} {{$adr->addr2}}</td>
          <td>
            <button class="btn btn-danger btn-sm act-delete-address">삭제</button>
            @if(!$adr->default)<button class="btn btn-primary btn-sm act-change-to-default">기본주소로 변경</button>@endif
            
          </td>
        </tr>
    @empty
        <tr>
          <td colspan="5">등록된 배송지 정보가 없습니다.</td>
        </tr>
    @endforelse
      </table>
      <div class="text-end">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addressCreateModal">배송지 등록</button>
      </div>
    </div>
  </div>
</div><!-- .container -->

<!-- /banner-feature -->

<!-- Modal for create address start -->
@include('market.templates.userpage.'.config('market.template.userpage.theme').'.address.create-modal')
<!-- Modal for create address end -->
@endsection

@section('styles')
@parent
@endsection

@section('scripts')
@parent
<script>
$(function(){
  $(".act-change-to-default").on('click', function(){
    var id =  $(this).parents('tr').attr('user-attr-id');
    MARKET.ajaxroute('put', 
      {'name': 'market.mypage.address.default', 'params[0]': id}, 
      {}, 
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
  })

  $(".act-delete-address").on('click', function(){
    var id =  $(this).parents('tr').attr('user-attr-id');
    MARKET.ajaxroute('delete', 
      {'name': 'market.mypage.address.destroy', 'params[0]': id}, 
      {}, 
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
  })
  

}) // $(function(){
</script>
@endsection
