<!-- <nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #e3f2fd;"> -->
<div class="container"> 
  <nav class="navbar navbar-light bg-light border-bottom border-body navbar-expand-lg" data-bs-theme="light">

      <!-- <a class="navbar-brand" href="#">Navbar</a> -->
      <button class="navbar-toggler navbar-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCategory" aria-controls="navbarCategory" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon navbar-light"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCategory">
        <ul class="navbar-nav d-flex justify-content-between container-fluid">
          @foreach($category as $v)
          <li class="nav-item">
            <a class="nav-link {{ url()->current() === route('market.category', substr($v->category, 0, 3)) ? 'active' : '' }}" href="{{ route('market.category', [$v->category]) }}">{{$v->name}}</a>
          </li>
          @endforeach
          <li class="nav-item">
            <a class="nav-link" href="#">이벤트</a>
          </li>
        </ul>
      </div>

  </nav>
</div>
