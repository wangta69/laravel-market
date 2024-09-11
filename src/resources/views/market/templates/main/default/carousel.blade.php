<div id="carousel-main" class="carousel slide" data-bs-ride="carousel">
  
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="/storage/market/items/8/NLOStZoKkEMTiJQWVW6TcYqAgK5NNr4ZR1UuwLDA.jpg" class="d-block img-fluid" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>First slide label</h5>
        <p>Some representative placeholder content for the first slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="/storage/market/items/7/cbpJON6VGMltD7UD7II5WaKBZgBfxQ7fXIamSRyG.jpg" class="d-block img-fluid" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Second slide label</h5>
        <p>Some representative placeholder content for the second slide.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="/storage/market/items/9/RafT3e3IbUy1E2mmouw4FMs4mAiLsVyd5qP2Wx0s.png" class="d-block img-fluid" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Third slide label</h5>
        <p>Some representative placeholder content for the third slide.</p>
      </div>
    </div>
  </div>
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselMain" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselMain" data-bs-slide="next">
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
  // const carousel = new bootstrap.Carousel('#carouselMain')

var myCarouselElement = document.querySelector('#carousel-main')
var carousel = new bootstrap.Carousel(myCarouselElement, {
  interval: 2000,
  touch: true
})

console.log('carousel >>', carousel)
</script>
@endsection