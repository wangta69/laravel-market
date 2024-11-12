<div id="carousel-main" class="carousel slide" data-bs-ride="carousel">
  
  <div class="carousel-inner">
    @foreach($items as $k=> $v)
    <div class="carousel-item @if($k == 0) active @endif">
      <img src="{{getImageUrl($v->image)}}" class="d-block img-fluid" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>{{$v->title}}</h5>
        <p>{{$v->description}}</p>
      </div>
    </div>
    @endforeach
  </div>
  <div class="carousel-indicators">
    @foreach($items as $k=> $v)
    <button type="button" data-bs-target="#carousel-main" data-bs-slide-to="{{$k}}" aria-label="Slide {{$k + 1}}" @if($k == 0) class="active" aria-current="true"@endif></button>
    @endforeach
    <!-- <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="2" aria-label="Slide 3"></button> -->
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carousel-main" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carousel-main" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
@section('styles')
@parent
<style>
#carousel-main {
  height: 300px;
}

#carousel-main > .carousel-inner {
  background-color: #ccc;
}
#carousel-main img {
  height: 300px;
  max-width: 100%;
  margin: auto;
}


</style>
@endsection
@section('scripts')
@parent
<script>
var myCarouselElement = document.querySelector('#carousel-main')
var carousel = new bootstrap.Carousel(myCarouselElement, {
  interval: 2000,
  touch: true
})
</script>
@endsection