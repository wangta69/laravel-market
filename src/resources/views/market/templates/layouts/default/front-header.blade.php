
<div class="container d-flex justify-content-between font-size-12" id="header-top">
  <div id='favorite'>즐겨찾기</div>
  @guest
  <menu>
    <li><a href="{{ route('login') }}" class="nav-link" href="{{ route('login') }}">로그인</a></li>
    <li><a href="{{ route('register') }}" class="nav-link">회원가입</a></li>
    <!-- <li>고객센터</li> -->
  </menu>
  @else
  <menu>
    <li> <a class="nav-link" href="{{ route('market.mypage.user') }}"><b>{{Auth::user()->name}}</b>님</a></li>
    <li><a class="nav-link" href="{{ route('logout') }}">로그아웃</a></li>
    <!-- <li>고객센터</li> -->
      
  </menu>
  @endif
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container d-flex justify-content-between">
      <a class="navbar-brand  ps-3" href="{{ route('market.main') }}"><img src="/storage/market/{{Config::get('market.template.ci')}}" ></a>
      


      <form action="{{ route('market.search') }}" onsubmit="return search_submit(this);">
        <div  class="input-group mt-2">
          <!-- <span class="input-group-text">검색어</span> -->
          <input type="search" name="q" value="{{request()->get('q')}}" required="" class="form-control search">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-search" aria-hidden="true"></i>
          </button>
        </div>
      </form>
      
      <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTopGnb" aria-controls="navbarTopGnb" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon navbar-dark"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarTopGnb">
        <ul class="navbar-nav d-flex justify-content-end container-fluid">
          @guest

          @else
          <li class="" id="my-shop-menu">
            <div class="nav-link {{ request()->routeIs(['market.mypage*']) ? 'active' : '' }}">
              <i class="fa-regular fa-user"></i>
              <small>마이숍</small>
            </div>

            <div class="my-shop-menu font-size-12">
              <div class="wrapper">
                <a class="link" href="{{ route('market.mypage.order') }}">주문내역</a> 
                <a class="link" href="{{ route('market.mypage.order.cancel-return-exchanges') }}">교환/반품</a>  
                <a class="link" href="{{ route('market.mypage.favorite') }}">관심상품</a>
              </div>
            </div>


          </li>
          
          @endif
          <!-- <li><a class="nav-link {{ request()->routeIs(['market.mypage.order*']) ? 'active' : '' }}" href="{{ route('market.mypage.order') }}">주문내역</a></li> -->
          <li><a class="nav-link {{ request()->routeIs(['market.cart*']) ? 'active' : '' }}" href="{{ route('market.cart') }}">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            <small>카트</small></a>
          </li>
        </ul>
      </div>


  </div>
</nav>
<div>
  

  <div class="bg-light"  id="category-nav">
    <x-market-category />
  </div>

</div><!-- .container -->



@section('styles')
@parent
<style>
#header-top {
  padding: 5px;
}
#header-top menu {
  position: relative;
}

#header-top menu li {
  /* height: 26px; */
  position: relative;
  /* padding-top: 10px; */
  float: left;
  list-style: none;
  padding-right: 9px;
}
}


#top-nav {
}

.navbar-brand > img{
  height: 40px;
}

.market-head-box {
  width: 100%;
  /* height: 150px; */
}

.search {
  border: 0;
  border-bottom: 1px solid #ced4da;
}

.market-head-box>ul {
  display: flex;
  justify-content: space-between;
}

#category-nav>ul {
  display: flex;
  justify-content: space-between;
}

#category-nav>ul>li {
  word-wrap: break-word;
  float: left;
  position: relative;
  width: auto;
  position: relative;
}

.my-shop-menu {
  position: absolute;
  z-index: 1;
  display: none;
}

.my-shop-menu:after {
  content: "";
  border-top: 0px solid transparent;
  border-left: 10px solid transparent;
  border-right: 10px solid transparent;
  border-bottom: 10px solid #fff;
  position: absolute;
  top: -9px;
  left: 50%;
}

.my-shop-menu .wrapper {
  /* position: relative; */
  /* display: block; */
  /* width: 50px; */
  padding: 8px;
  border-radius: 5px;
  /* margin-top: 14px; */
  background-color: #fff;
  border: 1px solid #ddd;
  box-shadow: 0 4px 5px rgba(0, 0, 0, 0.3);
}

.my-shop-menu a {
  display: block;
  padding-top: 3px;
  color: #333;
  font-size: 12px;
  white-space: nowrap;
}




</style>
@endsection

@section('scripts')
@parent
<script>
$(function(){

  $('#favorite').on('click', function(e) { 
    var bookmarkURL = window.location.href; 
    var bookmarkTitle = document.title; 
    var triggerDefault = false; 
    
    if (window.sidebar) {

      if (window.sidebar.addPanel) { // Firefox version < 23 
        window.sidebar.addPanel(bookmarkTitle, bookmarkURL, ''); 
      } else if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) { // Firefox version >= 23
        var $this = $(this); 
        $this.attr('href', bookmarkURL); 
        $this.attr('title', bookmarkTitle); 
        $this.attr('rel', 'sidebar'); 
        $this.off(e); triggerDefault = true; 
      }
    } else if(window.opera && window.print) { // Opera Hotlist 
      var $this = $(this); 
        $this.attr('href', bookmarkURL); 
        $this.attr('title', bookmarkTitle); 
        $this.attr('rel', 'sidebar'); 
        $this.off(e); triggerDefault = true; 
    } else if (window.external && ('AddFavorite' in window.external)) { // IE Favorite 
      window.external.AddFavorite(bookmarkURL, bookmarkTitle); 
    } else { // WebKit - Safari/Chrome 
        alert((navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Cmd' : 'Ctrl') + '+D 키를 눌러 즐겨찾기에 등록하실 수 있습니다.'); 
    } return triggerDefault; 
  });

  $("#my-shop-menu").on('mouseover', function(){
    $(".my-shop-menu").show();
  })
  $("#my-shop-menu").on('mouseout', function(){
    $(".my-shop-menu").hide();
  })
})
</script>
@endsection
