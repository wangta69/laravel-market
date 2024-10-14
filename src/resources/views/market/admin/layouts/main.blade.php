@extends('market.app')
@section('body_class', '')

@section('page')

<div class="wrapper">
  @include('market.admin.layouts.navigation')
  <div class="container">
    @yield('content')
    @include('market.admin.layouts.main-footer')
  </div><!--. container -->
</div>

<!-- toaseer box start -->
<div class="bg-body-secondary position-relative bd-example-toasts rounded-3">
  <div class="toast-container  position-fixed bottom-0 end-0 p-3" id="toast-container">
  </div>
</div>
<!-- toaseer box end -->
<!-- toaseer toast-placement start -->
<div id="toast-placement">
<!--   <div class="toast toast-placement" role="status" aria-live="polite" aria-atomic="true" > -->
  <div class="toast toast-placement" role="alert" aria-live="assertive" aria-atomic="true" >
    <div class="toast-header">
      <strong class="me-auto"></strong>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>

    <div class="toast-body">
      
    </div>
    <div class="toast-footer text-end d-none">
      <button class="btn btn-sm act-toast-to">바로가기</button>
    </div>
  </div>
</div>
<!-- toaseer toast-placement end -->

@stop

@section('styles')
<link media="all" type="text/css" rel="stylesheet" href="{{ mix('pondol/market/assets/admin.css') }}">
@endsection


@section('scripts')
<script src="{{ mix('pondol/market/assets/admin.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
      $('#sidebar').toggleClass('active');
    });
  });
</script>
@endsection
