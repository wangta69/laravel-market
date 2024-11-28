@section('title', '베너리스트')
<x-dynamic-component 
  component="market::app-admin" 
  :path="['베너관리', '베너리스트']"> 

<div class="p-3 mb-4 bg-light rounded-3">
  <h2 class="fw-bold">베너관리</h2>

  <div class="card">
    <div class="card-body">
      <div>위치별 베너관리가 가능합니다.</div>
    </div><!-- .card-body -->
  </div><!-- .card -->
</div>



<div class="row">
  <div class="col-3">

    <div class="card mt-1">
      <div class="card-body">
            Main Top 
      </div><!-- .card-body -->
      <div class="card-footer text-end">
            <a href="{{ route('market.admin.banner', ['MainTop'])}}" class="btn btn-primary btn-sm"> 관리하기 </a>
      </div><!-- .card-footer -->
    </div><!-- .card -->

  </div>
  <div class="col-3"></div>
  <div class="col-3"></div>
  <div class="col-3"></div>
</div>

@section('styles')
@parent
@endsection
@section('scripts')
@parent
@endsection
</x-dynamic-component>
