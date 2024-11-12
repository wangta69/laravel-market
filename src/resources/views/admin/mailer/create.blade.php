@extends('market::admin.layouts.main')
@section('title', '리뷰')
@section('content')
@include('market::admin.layouts.main-top', ['path'=>['메일', '메일발송']])

<div class="card">
       
    <div class="card-header">
      <span class="fw-bold">메일발송</span>
    </div>

    <form method="POST" action="{{ route('market.admin.mailer.create') }}" enctype="multipart/form-data">
    @csrf  
    <div class="card-body">
      <div class="mt-3">
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input act-check-to" id="to-all" name="to" value="all" {{ old('to', 'all') == 'all' ? 'checked' : '' }}>
          <label class="form-check-label" for="to-all">회원전체</label>
        </div>
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input act-check-to" id="to-individual" name="to" value="individual" {{ old('to') == 'individual' ? 'checked' : '' }}>
          <label class="form-check-label" for="cto-individual">회원개별</label>
        </div>
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input act-check-to" id="to-role" name="to" value="role" {{ old('to') == 'role' ? 'checked' : '' }}>
          <label class="form-check-label" for="to-role">회원권한별</label>
        </div>
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input act-check-to" id="to-guest" name="to" value="guest" {{ old('to') == 'guest' ? 'checked' : '' }}>
          <label class="form-check-label" for="to-guest">비회원</label>
        </div>
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input act-check-to" id="to-csv" name="to" value="csv" {{ old('to') == 'csv' ? 'checked' : '' }}>
          <label class="form-check-label" for="to-csv">비회원(csv)</label>
        </div>
      </div>

      <div class="row mt-3 align-items-center d-none opt-show opt-show-to-individual">
        <label class="col col-md-2 form-control-label fw-bold">수신자</label>
        <div class="col col-md-10">

          <input type="text" name="recv_users" value="{{ old('recv_users') }}"
          placeholder="다중 수신일경우 ','를 사용하여 이메일을 입력해주세요." class="form-control @if($errors->has('recv_users')) parsley-error @endif">

        </div>
      </div>

      <div class="row mt-3 align-items-center d-none opt-show opt-show-to-role">
        <label class="col col-md-2 form-control-label fw-bold">수신자</label>
        <div class="col col-md-10">
          <select name="role" class="form-control">
            <option value="">선택</option>
            @foreach($roles as $role)
            <option value="{{$role->id}}">{{$role->name}}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="row mt-3 align-items-center d-none opt-show opt-show-to-csv">

        <label class="col col-md-2 form-control-label fw-bold">수신자</label>
        <div class="col col-md-10">
        <input type="file" name="csv"  class="form-control" accept=".csv">
        </div>
      </div>

      <div class="row mt-2 align-items-center">
        <label class="form-control-label fw-bold col col-sm-2">발신자</label>
        <div class="col col-md-10">
          <input type="text" class="form-control" name="from" value="{{ Auth::user()->email }}" readonly>
        </div>
      </div>
      <div class="row mt-2 align-items-center">
        <label class="form-control-label fw-bold col col-sm-2">Title</label>
        <div class="col col-md-10">
          <input type="text" class="form-control" name="title" value="{{ old('title') }}">
        </div>
      </div>
      <div class="row form-group mt-2">
        <div class="col col-md-12">
          @include ('editor::default', ['name'=>'body', 'id'=>'body', 'value'=>old('body'), 'attr'=>['class'=>'form-control']])
        </div>
      </div>
    </div>

    <div class="card-footer">
      <button type="submit" class="btn btn-primary btn-sm">
        <i class="fa fa-check-circle"></i> 보내기
      </button>

      @if (!$errors->isEmpty())
        <div class="alert alert-danger" role="alert">
        {!! $errors->first() !!}
        </div>
      @endif
    </div>
    

  </form>
</div>
@endsection

@section('scripts')
@parent
<script>
var to = "{{old('to')}}";
function showhide_option(v) {
  console.log('showhide_option:', v);
  $(".opt-show").addClass('d-none');
  switch(v) {
    case 'individual': 
    case 'guest': 
      $(".opt-show-to-individual").removeClass('d-none');break;
    case 'role': $(".opt-show-to-role").removeClass('d-none');break;
    case 'csv': $(".opt-show-to-csv").removeClass('d-none');break;
  }
}

showhide_option(to);
$(function(){
  $(".act-check-to").on('click', function(){
    var v = $(this).val();
    showhide_option(v) 

  })
})
</script>
@endsection

@section('styles')
@parent
@endsection
