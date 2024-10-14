@extends('market.admin.layouts.main')
@section('title', 'Template 설정')
@section('content')
@include('market.admin.layouts.main-top', ['path'=>['환경설정', '템플릿 설정']])
<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">Template 설정</h2>

  <div class="card">
    <div class="card-body">
      <div>숍의 Template의 변경할 수 있습니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>

<div class="card card-body">
  <form method="POST" action="{{ route('market.admin.config.template.ci') }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="input-group">
      <div class="input-group-text" id="btnGroupAddon">CI</div>
      <img src="/storage/market/{{Config::get('market.template.ci')}}" class="ci-image input-group-text">
      <input type='file' name='file' class="form-control">
      
      <button type="submit" class="btn btn-primary">Logo 변경 </button>
    </div>
  </form>
</div><!-- .card -->

<div class="card card-body mt-1">
  <form method="POST" action="{{ route('market.admin.config.template.favicon') }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="input-group">
      <div class="input-group-text" id="btnGroupAddon">Favicon</div>
      <img src="/storage/market/{{Config::get('market.template.favicon')}}" class="ci-image input-group-text">
      <input type='file' name='file' class="form-control">
      
      <button type="submit" class="btn btn-primary">Favicon 변경 </button>
    </div>
  </form>
</div><!-- .card -->

<div class="card mt-1">
  <form name="template_form">
    <div class="card-body">

      <div class="input-group">
        <label class="col-form-label col-2">Layout</label>
        <select class="form-select" name="layout">
          @foreach($layouts as $v)
          <option value="{{$v}}" @if($v == $template["layout"]['theme']) selected @endif>{{$v}}</option>
          @endforeach
        </select>
      </div>

      <div class="input-group mt-1">
        <label class="col-form-label col-2">Main</label>
        <select class="form-select" name="main">
          @foreach($main as $v)
          <option value="{{$v}}" @if($v == $template["main"]['theme']) selected @endif>{{$v}}</option>
          @endforeach
        </select>
      </div>

      <div class="input-group mt-1">
        <label class="col-form-label col-2">Shop</label>
        <select class="form-select" name="shop">
          @foreach($shop as $v)
          <option value="{{$v}}" @if($v == $template["shop"]['theme']) selected @endif>{{$v}}</option>
          @endforeach
        </select>
        <label class="col-form-label col-2 text-center">페이지당 상품수</label>
        <input type="text" class="form-control" name="shop_lists" value="{{$template["shop"]['lists']}}">
      </div>

      <div class="input-group mt-1">
        <label class="col-form-label col-2">Cart</label>
        <select class="form-select" name="cart">
          @foreach($cart as $v)
          <option value="{{$v}}" @if($v == $template["cart"]['theme']) selected @endif>{{$v}}</option>
          @endforeach
        </select>
      </div>

      <div class="input-group mt-1">
        <label class="col-form-label col-2">Order</label>
        <select class="form-select" name="order">
          @foreach($order as $v)
          <option value="{{$v}}" @if($v == $template["order"]['theme']) selected @endif>{{$v}}</option>
          @endforeach
        </select>
      </div>

      <div class="input-group mt-1">
        <label class="col-form-label col-2">UserPage</label>
        <select class="form-select" name="userpage">
          @foreach($userpage as $v)
          <option value="{{$v}}" @if($v == $template["userpage"]['theme']) selected @endif>{{$v}}</option>
          @endforeach
        </select>
      </div>

      <div class="input-group mt-1">
        <label class="col-form-label col-2">Search</label>
        <select class="form-select" name="search">
          @foreach($auth as $v)
          <option value="{{$v}}" @if($v == $template["search"]['theme']) selected @endif>{{$v}}</option>
          @endforeach
        </select>
        <label class="col-form-label col-2 text-center">페이지당 상품수</label>
        <input type="text" class="form-control" name="search_lists" value="{{$template["search"]['lists']}}">
      </div>

      <div class="input-group mt-1">
        <label class="col-form-label col-2">Auth</label>
        <select class="form-select" name="auth">
          @foreach($auth as $v)
          <option value="{{$v}}" @if($v == $template["auth"]['theme']) selected @endif>{{$v}}</option>
          @endforeach
        </select>
      </div>

      <div class="input-group mt-1">
        <label class="col-form-label col-2">Component</label>
        <select class="form-select" name="component">
          @foreach($components as $v)
          <option value="{{$v}}" @if($v == $template["component"]['theme']) selected @endif>{{$v}}</option>
          @endforeach
        </select>
      </div>
      <div class="input-group mt-1">
        <label class="col-form-label col-2">Mail</label>
        <select class="form-select" name="mail">
          @foreach($mail as $v)
          <option value="{{$v}}" @if($v == $template["mail"]['theme']) selected @endif>{{$v}}</option>
          @endforeach
        </select>
      </div>
      <div class="input-group mt-1">
        <label class="col-form-label col-2">Pages</label>
        <select class="form-select" name="pages">
          @foreach($pages as $v)
          <option value="{{$v}}" @if($v == $template["pages"]['theme']) selected @endif>{{$v}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="card-footer text-end">
      <button type="button"class="btn btn-primary act-submit">적용</button>
    </div>
  </form>
</div>

@endsection

@section('styles')
@parent
<style>
.ci-image {
  width: 38px;
  height: 38px;
}
</style>
@endsection

@section('scripts')
@parent
<script>
$(function(){
	$(".act-submit").on('click', function(){

    // var layout = $("select[name=layout] > option:selected").val();
    ROUTE.ajaxroute('put', 
    {route: 'market.admin.config.template', data: $('form[name=template_form]').serializeObject()}, 
    function(resp) {
      if(resp.error) {
        showToaster({title: '알림', message: resp.error});
      } else {
        showToaster({title: '알림', message: '처리되었습니다.', alert: false});
      }
    })
	})
})
</script>
@endsection