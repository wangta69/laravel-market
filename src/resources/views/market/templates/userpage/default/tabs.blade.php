<ul  class="nav flex-column mt-5">
  <li class="nav-link">구매내역</li>
  <li class="nav-item">
    <a href="{{ route('market.mypage.order') }}" class="link {{ request()->routeIs(['market.mypage.order*']) ? 'active' : '' }}">
      <i class="fa fa-shopping-cart"></i>
      <span >주문조회</span>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{ route('market.mypage.order.cancel-return-exchanges') }}" class="link {{ request()->routeIs(['market.mypage.order*']) ? 'active' : '' }}">
      <i class="fa fa-shopping-cart"></i>
      <span>교환/반품</span>
    </a>
  </li>
  
  
  <!-- <li class="nav-item">
    <a class="link"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span >장바구니</span></a>
  </li> -->
  <!-- <li class="nav-item">
    <a class="link"><i class="fa fa-archive" aria-hidden="true"></i><span >오늘본상품 </span></a>
  </li> -->
  <li class="mt-3 nav-link">활동내역</li>
  <li class="nav-item">
    <a href="{{ route('market.mypage.favorite') }}" class="link {{ request()->routeIs(['market.mypage.favorite*']) ? 'active' : '' }}">
      <i class="fa fa-heart" aria-hidden="true"></i>
      <span >관심상품</span>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{ route('market.mypage.reviews') }}" class="link {{ request()->routeIs(['market.mypage.review*']) ? 'active' : '' }}">
    <i class="fa-solid fa-star"></i>
      <span >상품후기</span>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ route('market.mypage.qnas') }}" class="link {{ request()->routeIs(['market.mypage.qna*']) ? 'active' : '' }}">
    <i class="fa-regular fa-circle-question"></i>
      <span >상품문의</span>
    </a>
  </li>
  <li class="mt-3 nav-link">개인정보</li>
  <li class="nav-item">
    <a href="{{ route('market.mypage.user') }}" class="link {{ request()->routeIs(['market.mypage.user*']) ? 'active' : '' }}">
      <i class="fa fa-user" aria-hidden="true"></i>
      <span >개인정보</span>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{ route('market.mypage.addresses') }}" class="link {{ request()->routeIs(['market.mypage.addresses*']) ? 'active' : '' }}">
    <i class="fa-solid fa-address-book"></i>
      <span >배송지관리</span>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{ route('logout') }}" class="link">
      <i class="fa-solid fa-right-from-bracket"></i>
      <span >로그아웃</span>
    </a>
  </li>
  <li class="nav-item">
    <a href="{{ route('cancel.account') }}" class="link">
    <i class="fa-solid fa-user-xmark"></i>
      <span >회원탈퇴</span>
    </a>
  </li>

</ul>