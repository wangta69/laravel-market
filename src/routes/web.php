<?php

// 'prefix' => 'market', 
Route::group(['as' => 'market.', 'namespace' => 'App\Http\Controllers\Market', 'middleware' => ['web']], function () {
});

Route::get('market', 'MainController@index')->name('main');

Route::get('category/{category}', 'MarketController@category')->name('category');
Route::get('item/{item}', 'MarketController@view')->name('item');
Route::get('search', 'SearchController@index')->name('search');

// 장바구니 관련 시작
Route::get('cart', 'CartController@index')->name('cart');
Route::post('cart/add', 'CartController@store')->name('cart.add');
Route::delete('cart/{cart}', 'CartController@destroy')->name('cart.delete'); // 개별아이템 삭제
Route::put('cart/delete-checked', 'CartController@destroyChecked')->name('cart.delete.checked'); // 선택된 아이템 삭제
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
Route::get('mypage/favorite', 'Mypage\FavoriteController@index')->name('mypage.favorite');

## 쿠폰
Route::get('mypage/coupons', 'Mypage\CouponController@index')->name('mypage.coupons');

// 상품찜하기
Route::post('item/{item}/favorite', 'FavoriteController@store')->name('item.favorite');
Route::delete('item/{fav}/favorite', 'FavoriteController@destroy');
// 상품문의
Route::post('item/{item}/qna', 'QnaController@store')->name('item.qna');


// 일반 페이지
Route::get('pages/{page}', 'PagesController@show')->name('pages');
// Route::match(['get', 'post'], '/order', 'OrderController@index')->name('order');
