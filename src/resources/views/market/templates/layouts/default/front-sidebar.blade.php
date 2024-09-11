<div id="layout-sidenav-nav">
  <nav class="sidenav accordion sidenav-dark" id="sidenavAccordion">
    <div class="sidenav-menu">
      <div class="nav">
        <div class="sidenav-menu-heading">상품</div>
        <a class="nav-link" href="#">
            <i class="fas fa-tachometer-alt"></i>
            상품
        </a>
        <x-market-category/>

        <a class="nav-link" href="{{ route('market.cart') }}">
            <div class="nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
            장바구니
        </a>
        <hr>
        <h3>마이페이지</h3>
        <a class="nav-link" href="{{ route('market.login') }}">
            <div class="nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
            로그인
        </a>
        <a class="nav-link" href="{{ route('market.mypage.order') }}">
            <div class="nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
            주문내역
        </a>
      </div>

    </div>
  </nav>
</div>
