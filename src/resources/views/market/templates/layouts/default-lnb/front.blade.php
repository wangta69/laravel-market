@extends('market.app')

@section('body_class', '')

@section('page')

  @include('market.templates.layouts.'.config('pondol-market.template.layout.theme').'.front-header')
  <div id="layout-sidenav">
  @include('market.templates.layouts.'.config('pondol-market.template.layout.theme').'.front-sidebar')
      <div id="layout-sidenav-content">
          <main>
              <div class="container-fluid">
                  <div class="container-fluid">
                      <div class="gcse-search"></div>
                  </div>
                      @yield('content')
              </div>
          </main>
          @include('market.templates.layouts.'.config('pondol-market.template.layout.theme').'.front-footer')
      </div>
  </div>
  
@stop

@section('styles')
<link media="all" type="text/css" rel="stylesheet" href="{{ mix('pondol/market-assets/assets/css/front/default.css') }}">

@endsection

@section('scripts')
@parent
<script src="{{ mix('pondol/market-assets/assets/js/front/default.js') }}"></script>
<script>
$(function(){
  new VenoBox();
})
</script>
@endsection
