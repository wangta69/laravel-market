<?php

return [
  'guest_enable_order' => false, // 비회원 주문
  'route_web' => [
    'prefix' => '',
    'as' => 'market.',
    'middleware' => ['web']
  ],
  'route_admin' => [
    'prefix' => 'admin',
    // 'prefix' => 'market/admin',
    'as' => 'market.admin.',
    'middleware' => ['web', 'admin']
  ],
];