@extends('market.app')
@section('body_class', '')

@section('page')

<div class="wrapper">
  <div class="container-fluid">
    @yield('content')
  </div><!--. container -->
</div>
@stop

@section('styles')
<link media="all" type="text/css" rel="stylesheet" href="{{ mix('pondol/market/assets/admin.css') }}">
@endsection


@section('scripts')
<script src="{{ mix('pondol/market/assets/admin.js') }}"></script>
<script src="/assets/pondol/market/market.js?v=7"></script>
@endsection
