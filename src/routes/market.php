<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'market', 'as' => 'market.', 'namespace' => 'App\Http\Controllers\Market', 'middleware' => ['web']], function () {
  Route::get('route-url', 'Services\ServiceController@routeUrl');
});

// 'prefix' => 'market', 
Route::group(['as' => 'market.', 'namespace' => 'App\Http\Controllers\Market', 'middleware' => ['web']], function () {
  Route::get('/', 'MainController@index')->name('main');

  // Auth
  Route::get('register', 'Auth\RegisterController@create')->name('register')->middleware('guest');
  Route::post('register', 'Auth\RegisterController@store')->middleware('guest');
  Route::get('register/agreement', 'Auth\RegisterController@agreement')->name('register.agreement')->middleware('guest');
  Route::post('register/agreement', 'Auth\RegisterController@agreementstore')->middleware('guest');
  Route::get('register/success', 'Auth\RegisterController@success')->name('register.success');
  Route::get('login', 'Auth\LoginController@create')->name('login')->middleware('guest');
  Route::post('login', 'Auth\LoginController@store')->middleware('guest');
  Route::get('logout', 'Auth\LoginController@destroy')->name('logout');
  Route::get('validation/email/{email}', 'CommonController@validationEmail')->name('validation.email');

  // Route::get('password-request', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
  // Route::post('password-request', 'ForgotPasswordController@sendResetLinkEmail');
  // // Route::get('/reset-password/{token}', 'ForgotPasswordController@resetPasswordForm');
  // Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
  // Route::post('password/reset', 'ResetPasswordController@reset');
  // Route::get('forgot-password', 'Auth\ForgotPasswordController@forgotPassword')->name('forgot.password');
  // Route::post('forgot-password', 'Auth\ForgotPasswordController@resetPassword');
  // Route::post('forgot-email', 'Auth\ForgotPasswordController@resetPassword')->name('forgot.email');

  Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
  Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
  Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
  Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

  Route::get('cancel-account', 'Auth\DestroyController@delete')->name('cancel.account')->middleware('auth');
  Route::delete('cancel-account', 'Auth\DestroyController@destroy')->middleware('auth');
  Route::get('cancel-account/success', 'Auth\DestroyController@success')->name('cancel.account.success');

  // 로그인창 가져오기위한 라우터
  Route::get('/auth/social/{provider}/redirect', 'Auth\Social\LoginController@redirectToProvider');

  // 로그인 인증후 데이터를 제공해주는 라우터
  Route::get('/auth/social/{provider}/callback', 'Auth\Social\LoginController@handleProviderCallback');
  Route::get('/auth/social/{provider}/login', 'Auth\Social\LoginAppController@handleProviderAppCallback');
  Route::get('/auth/social/{provider}/logout', 'Auth\Social\LoginAppController@logout');



  Route::get('category/{category}', 'MarketController@category')->name('category');
  Route::get('item/{item}', 'MarketController@view')->name('item');
  Route::get('search', 'SearchController@index')->name('search');

  // 장바구니 관련 시작
  Route::get('cart', 'CartController@index')->name('cart');
  Route::post('cart/add', 'CartController@store')->name('cart.add');
  Route::delete('cart/{cart}', 'CartController@delete')->name('cart.delete');
  Route::put('cart/update/qty', 'CartController@updateQty')->name('cart.update.qty');
  Route::get('cart/update/overview', 'CartController@updateOverview')->name('cart.update.overview');
  // 구매하기
  Route::post('order/set', 'OrderController@setOrderItems')->name('order.set'); // cart에서 order로 보내기
  Route::get('order', 'OrderController@index')->name('order');
  Route::post('order/store/delivery', 'OrderController@storeAddress')->name('order.store.address'); // 주문정보 저장
  Route::post('order/store/payment', 'OrderController@storePayment')->name('order.store.payment'); // 지불정보 저장


  // 결제 처리 관련
  Route::post('pay/lg/hashdata', 'Payment\LgController@hashdata')->name('pay.lg.hashdata'); 
  Route::get('pay/lg/hashdata', 'Payment\LgController@hashdata'); 
  // 마이페이지
  // 개인정보
  Route::get('mypage/user', 'Mypage\UserController@index')->name('mypage.user');
  Route::put('mypage/user/update/email', 'Mypage\UserController@updateEmail')->name('mypage.user.update.email');
  Route::put('mypage/user/update/password', 'Mypage\UserController@updatePassword')->name('mypage.user.update.password');
  Route::put('mypage/user/update/mobile', 'Mypage\UserController@updateMobile')->name('mypage.user.update.mobile');
  // Route::get('mypage/user/update/email', 'Mypage\UserController@updateEmail')->name('mypage.user.update.email');
  // 주문내역
  Route::get('mypage/order', 'Mypage\OrderController@index')->name('mypage.order');
  Route::get('mypage/order/view/{o_id}', 'Mypage\OrderController@view')->name('mypage.order.view');
  Route::put('mypage/order/status/{o_id}/{status}', 'Mypage\OrderController@statusUpdate')->name('mypage.order.status');
  Route::get('mypage/order/cancel-return-exchanges', 'Mypage\CancelReturnExchangeController@index')->name('mypage.order.cancel-return-exchanges');
  Route::get('mypage/order/cancel-return-exchange/{ex}', 'Mypage\CancelReturnExchangeController@view')->name('mypage.order.cancel-return-exchange.view');
  Route::get('mypage/order/refund', 'Mypage\CancelReturnExchangeController@refund')->name('mypage.order.refund');
  Route::post('mypage/order/refund', 'Mypage\CancelReturnExchangeController@refundUpdate');
  Route::get('mypage/order/cancel-return-exchange/{type}/{o_id}', 'Mypage\CancelReturnExchangeController@create')->name('mypage.order.cancel-return-exchange');
  Route::post('mypage/order/cancel-return-exchange/{type}/{o_id}', 'Mypage\CancelReturnExchangeController@store');
  // Route::get('mypage/order/return/{o_id}', 'Mypage\ReturnController@create')->name('mypage.order.return');
  // Route::post('mypage/order/return/{o_id}', 'Mypage\RetrunController@store');


  // Route::get('mypage/order/exchange/{order_id}', 'Mypage\ExchangeController@create')->name('mypage.order.exchange');
  // Route::get('mypage/order/refund/{order_id}', 'Mypage\RefundController@create')->name('mypage.order.refund');

  Route::get('mypage/addresses', 'Mypage\AddressController@index')->name('mypage.addresses'); 
  Route::get('mypage/address', 'Mypage\AddressController@create')->name('mypage.address'); 
  Route::post('mypage/address', 'Mypage\AddressController@store'); 
  Route::put('mypage/address/{address}/default', 'Mypage\AddressController@updateDefault')->name('mypage.address.default');  
  Route::delete('mypage/address/{address}/destory', 'Mypage\AddressController@destroy')->name('mypage.address.destroy'); 
  // 상품문의
  Route::get('mypage/qnas', 'Mypage\QnaController@index')->name('mypage.qnas'); // 상품문의 외에도 있다면 카테고리로 분류하여 처리하는 방식으로 진행
  
  // Route::post('mypage/qna/{item}', 'Mypage\QnaController@store')->name('mypage.qna');
  // 상품후기
  Route::get('mypage/reviews', 'Mypage\ReviewController@index')->name('mypage.reviews');
  Route::get('mypage/review/{order}', 'Mypage\ReviewController@create')->name('mypage.review');
  Route::post('mypage/review/{order}', 'Mypage\ReviewController@store');

  // 찜한 상품
  Route::get('mypage/favorite', 'Mypage\FavoriteController@_index')->name('mypage.favorite');

  // 사용후기

  // 상품찜하기
  Route::post('item/{item}/favorite', 'FavoriteController@_store')->name('item.favorite');
  Route::delete('item/{fav}/favorite', 'FavoriteController@_destroy');
  // 상품문의
  Route::post('item/{item}/qna', 'QnaController@store')->name('item.qna');
  // Route::match(['get', 'post'], '/order', 'OrderController@index')->name('order');
});
