<nav id="sidebar">
  <div class="sidebar-header">
    <h3><a href="{{ route('market.admin.dashboard') }}">OnStory</a></h3>
    <strong>ON</strong>
  </div>

  <ul class="list-unstyled components" id="navbar-sidebar">
    <li>
      <a href="#member-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['auth.admin.users*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
          <i class="fa-solid fa-user"></i>
          회원관리
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['auth.admin.user*', 'auth.admin.config*']) ? 'show' : '' }}" id="member-sub-menu">
        <li class="{{ request()->routeIs(['auth.admin.users*']) ? 'current-page' : '' }}">
          <a href="{{ route('auth.admin.users') }}">회원</a>
        </li>
        <li class="{{ request()->routeIs(['auth.admin.user.create*']) ? 'current-page' : '' }}">
          <a href="{{ route('auth.admin.user.create') }}">회원등록</a>
        </li>
        <hr/>
        <li class="{{ request()->routeIs(['auth.admin.config']) ? 'current-page' : '' }}">
          <a href="{{ route('auth.admin.config') }}">일반환경설정</a>
        </li>
        <li class="{{ request()->routeIs(['auth.admin.config.agreement.termsofuse']) ? 'current-page' : '' }}">
          <a href="{{ route('auth.admin.config.agreement.termsofuse') }}">이용약관</a>
        </li>
        <li class="{{ request()->routeIs(['auth.admin.config.agreement.privacypolicy']) ? 'current-page' : '' }}">
          <a href="{{ route('auth.admin.config.agreement.privacypolicy') }}">개인정보 수집 및 허용</a>
        </li>
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
      <a href="#coupon-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['market.admin.coupon*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
        <i class="fa-brands fa-product-hunt"></i>
          쿠폰관리
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['market.admin.coupon*']) ? 'show' : '' }}" id="coupon-sub-menu">
        <li class="{{ request()->routeIs(['market.admin.coupon.create']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.coupon.create') }}">쿠폰등록</a>
        </li>  
        <li class="{{ request()->routeIs(['market.admin.coupons']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.coupons') }}">쿠폰발급</a>
        </li>
        <li class="{{ request()->routeIs(['market.admin.coupon.issues']) ? 'current-page' : '' }}">
          <a href="{{ route('market.admin.coupon.issues') }}">쿠폰발급내역</a>
        </li> 
        
        
      </ul>
    </li>
    <li>
      <a href="#mailer-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['mailer.admin*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
          <i class="fa fa-envelope"></i>
          메일
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['mailer.admin*']) ? 'show' : '' }}" id="mailer-sub-menu">
        <li class="{{ request()->routeIs(['mailer.admin.index*']) ? 'current-page' : '' }}">
          <a href="{{ route('mailer.admin.index') }}">발송리스트</a>
        </li>
        <li class="{{ request()->routeIs(['mailer.admin.create*']) ? 'current-page' : '' }}">
          <a href="{{ route('mailer.admin.create') }}">메일 발송</a>
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
        <li class="{{ request()->routeIs(['market.admin.banner*']) ? 'current-page' : '' }}">
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
      <a href="#visitor-sub-menu" data-bs-toggle="collapse" 
        aria-expanded="{{ request()->routeIs(['admin.visitors*']) ? 'true' : 'false' }}"
        class="dropdown-toggle">
          <i class="fa-solid fa-user"></i>
           방문자통계
      </a>
      <ul class="collapse list-unstyled {{ request()->routeIs(['admin.visitors*']) ? 'show' : '' }}" id="visitor-sub-menu">
       <li class="{{ request()->routeIs(['admin.visitors.dashboard']) ? 'current-page' : '' }}">
          <a href="{{ route('admin.visitors.dashboard') }}">dashboard</a>
        </li>  
        <li class="{{ request()->routeIs(['admin.visitors.log']) ? 'current-page' : '' }}">
          <a href="{{ route('admin.visitors.log') }}">log</a>
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
      <ul class="collapse list-unstyled {{ request()->routeIs(['market.admin.dev*']) ? 'show' : '' }}" id="dev-sub-menu">
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
