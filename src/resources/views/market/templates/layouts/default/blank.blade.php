@extends('layouts.app')

@section('body_class', '')

@section('page')


    @yield('content')

@stop

@section('styles')
@parent
<link media="all" type="text/css" rel="stylesheet" href="{{ mix('pondol/market-assets/assets/css/front/default.css') }}">
@endsection

@section('scripts')
@parent
<script src="{{ mix('pondol/market-assets/assets/js/front/default.js') }}"></script>
@endsection