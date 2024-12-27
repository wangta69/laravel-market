@extends(market_theme('layouts').'.front')
@section('meta')
@include('market.meta')
@endsection

@section('title', $meta->title)
@section('content')
<div class="container body product-show">

  <div class="row justify-content-center">
    <div class="col-lg-8 mt-5">
      <h2 class="title ">개인정보 처리방침</h2>

      <div class="overflow-auto mt-5">
        {!! $item !!}
      </div>
    </div><!-- col-lg-6-->
  </div><!-- row justify-content-center -->

</div><!-- .container -->



<!-- /banner-feature -->
@endsection

@section('styles')
@parent
@endsection

@section('scripts')
@parent
@endsection
