<?php

Route::group(['prefix' => 'adm', 'as' => 'market.admin.', 'namespace' => 'App\Http\Controllers\Market\Admin', 'middleware' => 'admin'], function () {
});
Route::get('/', 'DashboardController@index')->name('dashboard');

// 주문/배송관리
Route::get('orders', 'OrderController@index')->name('orders');
Route::get('orders/status/{status}', 'OrderController@index')->name('orders.status'); // @deprecated
Route::get('order/{order}', 'OrderController@view')->name('order');
Route::put('order/update/delivery', 'OrderController@updateDelivery')->name('order.update.delivery');
Route::put('order/update/pay', 'OrderController@updatePay')->name('order.update.pay');

Route::get('cancel-return-exchanges', 'CancelReturnExchangeController@index')->name('cancel-return-exchanges');
Route::get('cancel-return-exchange/{id}', 'CancelReturnExchangeController@view')->name('cancel-return-exchange.view');
Route::put('cancel-return-exchange/{re}', 'CancelReturnExchangeController@update');
// <li><a href="./main.php?menushow=menu4&theme=order/order1">주문상품보기</a></li>
// <li><a href="./main.php?menushow=menu4&theme=order/order1&orderstatus=50">주문완료상품</a></li>
// <li><a href="./main.php?menushow=menu4&theme=order/order1&orderstatus=60">반송상품</a></li>
// <li><a href="./main.php?menushow=menu4&theme=order/order6">세금계산서/현금영수증</a></li>
// <li><a href="./main.php?menushow=menu4&theme=order/order5">주문서입력</a></li>
// <li><a href="./main.php?menushow=menu4&theme=order/order4">온라인자동견적</a></li>

// 상품전시관리
// Route::get('/display', 'DisplayController@index')->name('display');
// review 및 상품문의
Route::get('reviews', 'ReviewController@index')->name('reviews');
Route::put('review/{review}', 'ReviewController@update')->name('review');
Route::get('qnas', 'QnaController@index')->name('qnas');
Route::put('qna/{qna}', 'QnaController@update')->name('qna');

// 카테고리 관련
Route::get('category', 'CategoryController@index')->name('category');
Route::post('category', 'CategoryController@store');
Route::put('category', 'CategoryController@update');
Route::delete('category', 'CategoryController@destroy');
Route::get('category/sub', 'CategoryController@sub')->name('category.sub');// 현재 카테고리의 sub list가져오기(ajax로 사용)

// 상품관리
Route::get('items', 'ItemController@index')->name('items');
Route::get('item/create', 'ItemController@create')->name('item.create');
Route::post('item', 'ItemController@store')->name('item.store');
Route::get('item/{item}', 'ItemController@edit')->name('item');
Route::put('item/{item}', 'ItemController@update'); //->name('item.update');
Route::delete('item/{item}', 'ItemController@destroy'); //->name('item.destroy');

// 상품관리 > 태그관리
Route::post('tag', 'TagController@store')->name('tag');

// 환경설정
Route::get('config/template', 'Config\TemplateController@view')->name('config.template');
Route::put('config/template', 'Config\TemplateController@update');
Route::put('config/ci', 'Config\TemplateController@updateCI')->name('config.template.ci');
Route::put('config/favicon', 'Config\TemplateController@updateFavicon')->name('config.template.favicon');

Route::get('config/delivery', 'Config\DeliveryController@index')->name('config.delivery');
Route::post('config/delivery', 'Config\DeliveryController@update');

Route::get('config/banks', 'Config\BankController@index')->name('config.banks');
Route::get('config/bank', 'Config\BankController@create')->name('config.bank');
Route::post('config/bank', 'Config\BankController@store');
Route::delete('config/bank/{bank}', 'Config\BankController@destroy')->name('config.bank.delete');

Route::get('config/sms', 'Config\SmsController@index')->name('config.sms');
Route::put('config/sms', 'Config\SmsController@update');

Route::get('config/pg', 'Config\PgController@index')->name('config.pg');
Route::put('config/pg', 'Config\PgController@update');

Route::get('config/company', 'Config\CompanyController@index')->name('config.company');
Route::put('config/company', 'Config\CompanyController@update');

// 베너관리
Route::get('banners', 'BannerController@index')->name('banners');
Route::get('banner/{type}', 'BannerController@view')->name('banner');
Route::get('banner/{type}/create', 'BannerController@create')->name('banner.create');
Route::post('banner/{type}/create', 'BannerController@store');
Route::get('banner/{type}/edit/{item}', 'BannerController@edit')->name('banner.edit');
Route::put('banner/{type}/edit/{item}', 'BannerController@update');
Route::delete('banner/{type}', 'BannerController@destroy');

// 쿠폰
// 쿠폰 등록
Route::get('coupons', 'Coupon\CouponController@index')->name('coupons');
Route::get('coupon', 'Coupon\CouponController@create')->name('coupon.create');
Route::post('coupon', 'Coupon\CouponController@store');

// 쿠폰 발급
Route::get('coupon/issues', 'Coupon\CouponIssueController@index')->name('coupon.issues');
Route::get('coupon/{coupon}', 'Coupon\CouponIssueController@create')->name('coupon.issue');
Route::post('coupon/{coupon}', 'Coupon\CouponIssueController@store');


// 개발테스트
Route::get('dev/mail', 'Dev\MailController@view')->name('dev.mail');
Route::post('dev/mail', 'Dev\MailController@send');
Route::get('dev/mail/preview', 'Dev\MailController@preview')->name('dev.mail.preview');

Route::get('dev/event', 'Dev\EventController@view')->name('dev.event');
Route::post('dev/event', 'Dev\EventController@send');
  
/*


  상품관리</div>
 
  <ul class="leftmenulist">
    <li><a href="./main.php?menushow=menu2&theme=product/product3">상품가격일괄수정</a></li>
    <li><a href="./main.php?menushow=menu2&theme=product/product4">품절상품관리</a></li>
    <li><a href="./main.php?menushow=menu2&theme=product/product5">재고관리</a></li>
    <li><a href="./main.php?menushow=menu2&theme=product/product7">상품순서관리</a></li>
  </ul>
  </div>


  주문/배송관리</div>
 
  <ul class="leftmenulist">
    <li><a href="./main.php?menushow=menu4&theme=order/order6">세금계산서/현금영수증</a></li>
    <li><a href="./main.php?menushow=menu4&theme=order/order5">주문서입력</a></li>
    <li><a href="./main.php?menushow=menu4&theme=order/order4">온라인자동견적</a></li>
  </ul>
  </div>

  제휴업체관리</div>
 
  <ul class="leftmenulist">
    <li><a href="./main.php?menushow=menu5&theme=agent/naver">[입점몰]네이버입점몰</a></li>
    <li><a href="http://www.bluepay.co.kr/" target="_blank">[PG 서비스]블루페이</a></li>
    <li><a href="./main.php?menushow=menu5&amp;theme=agent/compare">가격비교사이트</a></li>
    <!--
    <li><a href="#">[실명인증서비스]한국실명인증서비스</a></li>
    <li><a href="#">[실명인증서비스]SIREN24</a></li>
    <li><a href="#">[SMS 서비스]SIREN24</a></li>
    -->
  </ul>
</div>

  매출/통계분석</div>
 
  <ul class="leftmenulist">
    <li><a href="./main.php?menushow=menu9&theme=mallstatistic/statistic2">제품별판매분석</a></li>
    <li><a href="./main.php?menushow=menu9&theme=mallstatistic/statistic10">일별판매분석</a></li>
    <li><a href="./main.php?menushow=menu9&theme=mallstatistic/statistic6">월별 결제분석 통계</a></li>
    <li><a href="./main.php?menushow=menu9&theme=mallstatistic/statistic4">구매지역</a></li>
    <li><a href="./main.php?menushow=menu9&theme=mallstatistic/statistic9">판매처별 미수관리 </a></li>
  </ul>
  </div>

  메일발송</div>
 
  <ul class="leftmenulist">
    <li><a href="./main.php?menushow=menu11&theme=mail/mailer1">메일 발송</a></li>
    <li><a href="./main.php?menushow=menu11&theme=mail/mailer3">발송된메일</a></li>
    <li><a href="./main.php?menushow=menu11&theme=mail/address1">주소록관리</a></li>
  </ul>
</div>


기타관리</div>
 
  <ul class="leftmenulist">
    <li><a href="./main.php?menushow=menu13&theme=util/util1">투표창관리</a></li>
    <li><a href="./main.php?menushow=menu13&theme=util/popup1">팝업창관리</a></li>
    <li><a href="./main.php?menushow=menu13&theme=util/util2">다이어리</a></li>
    <li><a href="./main.php?menushow=menu13&theme=coupon/coupon_list">쿠폰관리</a></li>
  </ul>
</div>
*/


