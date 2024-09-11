<?php

return [
  'roles'=>['default_role'=>'user'],
  'delivery' => [
    'fee' => 0,
    'type' => 'none',
    'min' => 0
  ],
  'delivery_status' => [
    0 => '주문',
    10 => '결제완료',// 상품준비
    // 20 => '상품준비',
    30 => '배송중',
    40 => '배송완료',
    50 => '주문취소요청',
    59 => '주문취소완료',
    100 => '거래완료',
  ],
  'exchange_status' => [ // 30, 60, 80 일경우 모든 주문이 완료
    0 => '접수신청', // 결제대기
    10 => '거절',// 상품준비
    20 => '교환진행중',
    90 => '교환완료'
  ],
  'return_status' => [ // 30, 60, 80 일경우 모든 주문이 완료
    0 => '접수신청', // 결제대기
    10 => '거절',// 상품준비
    20 => '반품진행중',
    90 => '반품완료'
  ],
  'pay_status' => [
    '0'=>'지불대기',
    '10'=>'지불완료',
    '20'=>'결제취소'
  ],
  'payment' => [
    'pg' => 'kcp',
    'mid' => 'T0000',
    'sitekey' => '3grptw1.zW0GSo4PQdaGvsF__',
    'submit_url' => 'https://testpay.kcp.co.kr/plugin/payplus_web.jsp',
    'service'=>false,
    'naver'=>false,
    'kakao'=>false
  ],
  'template' => [
    'layout' => 'default',
    'main' => 'default',
    'shop' => ['theme'=>'default', 'lists'=> 20],
    'cart' => ['theme'=>'default'],
    'order' => 'default',
    'userpage' => 'default',
    'search' => ['theme'=>'default', 'lists'=> 20],
    'auth' => 'default',
    'component' => 'default',
    'ci' => 'logo.png',
  ],
  'banks' => [
    '039'=>['name'=>'경남은행', 'siwft'=>'KYNAKR22XXX'],
    '034'=>['name'=>'광주은행', 'siwft'=>'KWABKRSE'],
    '004'=>['name'=>'국민은행', 'siwft'=>'CZNBKRSE'],
    '003'=>['name'=>'기업은행', 'siwft'=>'IBKOKRSE'],
    '011'=>['name'=>'농협은행', 'siwft'=>'NACFKRSEXXX'],
    '031'=>['name'=>'대구은행', 'siwft'=>'DAEBKR22'],
    '032'=>['name'=>'부산은행', 'siwft'=>'PUSBKR2P'],
    '002'=>['name'=>'산업은행', 'siwft'=>'KODBKRSE'],
    '050'=>['name'=>'상호저축은행', 'siwft'=>''],
    '045'=>['name'=>'새마을금고', 'siwft'=>''],
    '007'=>['name'=>'수협은행', 'siwft'=>'NFFCKRSE'],
    '027'=>['name'=>'씨티은행', 'siwft'=>'CITIKRSX'],
    '088'=>['name'=>'신한은행', 'siwft'=>'SHBKKRSE'],
    '048'=>['name'=>'신협은행', 'siwft'=>''],
    '005'=>['name'=>'외환은행', 'siwft'=>'KEOXKRSE'],
    '020'=>['name'=>'우리은행', 'siwft'=>'HVBKKRSEXXX'],
    '071'=>['name'=>'우체국은행', 'siwft'=>'SHBKKRSEPO'],
    '037'=>['name'=>'전북은행', 'siwft'=>'JEONKRSE'],
    '035'=>['name'=>'제주은행', 'siwft'=>'JJBKKR22'],
    '090'=>['name'=>'카카오뱅크', 'siwft'=>'CITIKRSXKAK'],
    '089'=>['name'=>'케이뱅크', 'siwft'=>''],
    '092'=>['name'=>'토스뱅크', 'siwft'=>''],
    '081'=>['name'=>'하나은행', 'siwft'=>'HNBNKRSE'],
    '023'=>['name'=>'SC제일은행', 'siwft'=>'SCBLKRSE']
    ]
];