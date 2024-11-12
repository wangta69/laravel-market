<nav id="sidebar">
  <div class="sidebar-header">
    <h3><a href="{{ route('market.admin.dashboard') }}">OnStory</a></h3>
    <strong>ON</strong>
  </div>

  <ul class="list-unstyled components" id="navbar-sidebar">
    <li>
      <a href="#member-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['market.admin.users*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
          <i class="fa-solid fa-user"></i>
          회원관리
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['market.admin.users*']) ? 'show' : '' }}" id="member-sub-menu">
        <li class="{{ request()->routeIs(['market.admin.users*']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.users') }}">회원</a>
        </li>
        <li class="{{ request()->routeIs(['market.admin.user.config']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.user.config') }}">회원 설정</a>
        </li>
        <!-- <li>
            <a href="{{ route('market.admin.config.delivery') }}">배송비 설정</a>
        </li>
        <li>
            <a href="{{ route('market.admin.category') }}">PG 및 결제 설정</a>
        </li>
        <li>
            <a href="{{ route('market.admin.category') }}">SMS 설정</a>
        </li>
        <li>
            <a href="{{ route('market.admin.config.banks') }}">무통장 입급 계좌</a>
        </li> -->
      </ul>
    </li>
    <li>
      <a href="#order-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['market.admin.orders*', 'market.admin.order*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
        <i class="fa-solid fa-truck"></i>
          주문/배송관리
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['market.admin.order*', 'market.admin.cancel-return-exchange*']) ? 'show' : '' }}" id="order-sub-menu">
        <li class="{{ request()->routeIs(['market.admin.order*']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.orders') }}">주문내역</a>
        </li>
        <li class="{{ request()->routeIs(['market.admin.cancel-return-exchange*']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.cancel-return-exchanges') }}">교환/반품</a>
        </li>
        
        {{-- 
        <li class="@if( request()->url() == route('market.admin.orders.status', [60]))  current-page @endif">
          <a href="{{ route('market.admin.orders.status', [60]) }}">반품요청</a>
        </li>
        <li class="@if( request()->url() == route('market.admin.orders.status', [70]))  current-page @endif">
          <a href="{{ route('market.admin.orders.status', [70]) }}">교환요청</a>
        </li>
        --}}
      </ul>
    </li>
    <li>
      <a href="#qna-review-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['market.admin.qna*', 'market.admin.review*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
        <i class="fa-solid fa-comments"></i>
          상품문의 및 리뷰
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['market.admin.qna*', 'market.admin.review*']) ? 'show' : '' }}" id="qna-review-sub-menu">
        <li class="{{ request()->routeIs(['market.admin.qna*']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.qnas') }}">상품문의</a>
        </li>
        <li class="{{ request()->routeIs(['market.admin.review*']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.reviews') }}">리뷰</a>
        </li>
      </ul>
    </li>





    <li>
      <a href="#category-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['market.admin.category*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
        <i class="fa-solid fa-list"></i>
          카테고리
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['market.admin.category*']) ? 'show' : '' }}" id="category-sub-menu">
        <li class="{{ request()->routeIs(['market.admin.category']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.category') }}">카테고리관리</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#product-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['market.admin.item*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
        <i class="fa-brands fa-product-hunt"></i>
          상품관리
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['market.admin.item*']) ? 'show' : '' }}" id="product-sub-menu">
        <li class="{{ request()->routeIs(['market.admin.items']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.items') }}">상품관리</a>
        </li>
        <li class="{{ request()->routeIs(['market.admin.item.create']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.item.create') }}">상품등록</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#mailer-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['market.admin.mailer*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
        <i class="fa fa-envelope"></i>
          메일발송
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['market.admin.mailer*']) ? 'show' : '' }}" id="mailer-sub-menu">
        <li class="{{ request()->routeIs(['market.admin.mailer']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.mailer') }}">발송리스트</a>
        </li>
        <li class="{{ request()->routeIs(['market.admin.mailer.create']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.mailer.create') }}">발송</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#banners-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['market.admin.banner*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
        <i class="fa-regular fa-images"></i>
          베너관리
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['market.admin.banner*']) ? 'show' : '' }}" id="banners-sub-menu">
        <li class="{{ request()->routeIs(['market.admin.bannerㄴ']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.banners') }}">베너관리</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#config-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['market.admin.config*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
        <i class="fa-solid fa-gear"></i>
          환경설정
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['market.admin.config*']) ? 'show' : '' }}" id="config-sub-menu">
        <li class="{{ request()->routeIs(['market.admin.config.company']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.config.company') }}">쇼핑몰 정보</a>
        </li>
        <li class="{{ request()->routeIs(['market.admin.config.template']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.config.template') }}">템플릿 설정</a>
        </li>
        <li class="{{ request()->routeIs(['market.admin.config.delivery']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.config.delivery') }}">배송비 설정</a>
        </li>
        
        <li class="{{ request()->routeIs(['market.admin.config.pg']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.config.pg') }}">PG 및 결제 설정</a>
        </li>
        <li class="{{ request()->routeIs(['market.admin.config.sms']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.config.sms') }}">SMS 설정</a>
        </li>
        <li class="{{ request()->routeIs(['market.admin.config.banks']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.config.banks') }}">무통장 입급 계좌</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#visitors-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['market.admin.visitors*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
        <i class="fa-solid fa-chart-simple"></i>
          방문자통계
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['market.admin.visitors*']) ? 'show' : '' }}" id="visitors-sub-menu">
        <li class="{{ request()->routeIs(['market.admin.visitors']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.visitors') }}">Summarize</a>
        </li>
        <li class="{{ request()->routeIs(['market.admin.visitors.log']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.visitors.log') }}">Log</a>
        </li>
      </ul>
    </li>

    <li>
      <a href="#dev-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['market.admin.dev*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
        <i class="fa-solid fa-code"></i>
          Dev
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['market.admin.dev.mail*']) ? 'show' : '' }}" id="dev-sub-menu">
        <li class="{{ request()->routeIs(['market.admin.dev.mail']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.dev.mail') }}">메일테스트</a>
        </li>
        <li class="{{ request()->routeIs(['market.admin.dev.event']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.dev.event') }}">이벤트테스트</a>
        </li>
      </ul>
    </li>
    
  </ul>
</nav>
