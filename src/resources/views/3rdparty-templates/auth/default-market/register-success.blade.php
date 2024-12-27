@extends(market_theme('layouts').'.front')
@section('title', '회원가입')
@section('content')
<section>
  <div class="container body mt-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h2 class="title">회원가입 완료</h2>
        <div class="card">
          <div class="card-body">
            회원가입이 정상적으로 처리되었습니다.
          </div> <!-- .card-bod -->
          <div class="card-footer">
            <a class="btn btn-primary" href="{{ route('market.main') }}">Home</a>
          </div><!-- .card-footer -->
        </div> <!-- .card -->
      </div><!-- . class="col-lg-6" -->
    </div> <!--class="row justify-content-center" -->
  </div><!-- .container -->
</section>

@endsection

@section ('styles')
@parent
<link href="{{ asset('/assets/front/css/register.css') }}" rel="stylesheet">
@endsection

@section ('scripts')

@parent
@endsection
