@php
$path = isset($path) ? $path : [];
@endphp
<x-market::app>
  <div class="wrapper">
   <x-market::partials.navigation-admin />
    <div class="container">
      @if(count($path))
      <x-pondol-common::partials.main-top-navigation :path="$path"/>
      @endif
      {{ $slot }}
      <x-pondol-common::partials.footer />
    </div><!--. container -->
  </div>
  <x-pondol-common::partials.toaster />
@section('styles')
@parent
<style>
  #footer {border-top: 1px solid #ced4da;}
</style>
@endsection

@section('scripts')
@parent
<script src="/pondol/common-admin.js"></script>
<script src="/pondol/search-zip.js"></script>
<script src="/pondol/delivery/delivery.js"></script>
@endsection
</x-market::app>




