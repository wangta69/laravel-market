<?php return array (
  'roles' => 
  array (
    'default_role' => 'user',
  ),
  'delivery' => 
  array (
    'fee' => '3000',
    'type' => 'apply',
    'min' => '10000',
  ),
  'delivery_status' => 
  array ( // 30, 60, 80 일경우 모든 주문이 완료
    0 => '주문', // 결제대기
    10 => '결제완료',// 상품준비
    20 => '상품준비',
    30 => '배송중',
    40 => '배송완료',
    50 => '주문취소요청',
    59 => '주문취소완료',
    100 => '거래완료',
  ),
  'exchange_status' => 
  array ( // 30, 60, 80 일경우 모든 주문이 완료
    0 => '접수신청', // 결제대기
    10 => '거절',// 상품준비
    20 => '교환진행중',
    90 => '교환완료'
  ),
  'return_status' => 
  array ( // 30, 60, 80 일경우 모든 주문이 완료
    0 => '접수신청', // 결제대기
    10 => '거절',// 상품준비
    20 => '반품진행중',
    90 => '반품완료'
  ),
  'pay_status' => 
  array (
    0 => '지불대기',
    10 => '지불완료',
    20 => '결제취소',
  ),
  'payment' => 
  array (
    'pg' => 'lg',
    'mid' => 'T0000',
    'sitekey' => '3grptw1.zW0GSo4PQdaGvsF__',
    'submit_url' => 'https://testpay.kcp.co.kr/plugin/payplus_web.jsp',
    'service'=>false,
    'naver' => false,
    'kakao' => true,
  ),
  'template' => 
  array (
    'layout' => 
    array (
      'theme' => 'default',
    ),
    'main' => 
    array (
      'theme' => 'default',
    ),
    'shop' => 
    array (
      'theme' => 'default',
      'lists' => '20',
    ),
    'cart' => 
    array (
      'theme' => 'default',
    ),
    'order' => 
    array (
      'theme' => 'default',
    ),
    'userpage' => 
    array (
      'theme' => 'default',
    ),
    'search' => 
    array (
      'theme' => 'default',
      'lists' => '20',
    ),
    'auth' => 
    array (
      'theme' => 'default',
    ),
    'component' => 
    array (
      'theme' => 'default',
    ),
    'ci' => 'logo.png',
  ),
  'banks' => 
  array (
    '039' => 
    array (
      'name' => '경남은행',
      'siwft' => 'KYNAKR22XXX',
    ),
    '034' => 
    array (
      'name' => '광주은행',
      'siwft' => 'KWABKRSE',
    ),
    '004' => 
    array (
      'name' => '국민은행',
      'siwft' => 'CZNBKRSE',
    ),
    '003' => 
    array (
      'name' => '기업은행',
      'siwft' => 'IBKOKRSE',
    ),
    '011' => 
    array (
      'name' => '농협은행',
      'siwft' => 'NACFKRSEXXX',
    ),
    '031' => 
    array (
      'name' => '대구은행',
      'siwft' => 'DAEBKR22',
    ),
    '032' => 
    array (
      'name' => '부산은행',
      'siwft' => 'PUSBKR2P',
    ),
    '002' => 
    array (
      'name' => '산업은행',
      'siwft' => 'KODBKRSE',
    ),
    '050' => 
    array (
      'name' => '상호저축은행',
      'siwft' => '',
    ),
    '045' => 
    array (
      'name' => '새마을금고',
      'siwft' => '',
    ),
    '007' => 
    array (
      'name' => '수협은행',
      'siwft' => 'NFFCKRSE',
    ),
    '027' => 
    array (
      'name' => '씨티은행',
      'siwft' => 'CITIKRSX',
    ),
    '088' => 
    array (
      'name' => '신한은행',
      'siwft' => 'SHBKKRSE',
    ),
    '048' => 
    array (
      'name' => '신협은행',
      'siwft' => '',
    ),
    '005' => 
    array (
      'name' => '외환은행',
      'siwft' => 'KEOXKRSE',
    ),
    '020' => 
    array (
      'name' => '우리은행',
      'siwft' => 'HVBKKRSEXXX',
    ),
    '071' => 
    array (
      'name' => '우체국은행',
      'siwft' => 'SHBKKRSEPO',
    ),
    '037' => 
    array (
      'name' => '전북은행',
      'siwft' => 'JEONKRSE',
    ),
    '035' => 
    array (
      'name' => '제주은행',
      'siwft' => 'JJBKKR22',
    ),
    '090' => 
    array (
      'name' => '카카오뱅크',
      'siwft' => 'CITIKRSXKAK',
    ),
    '089' => 
    array (
      'name' => '케이뱅크',
      'siwft' => '',
    ),
    '092' => 
    array (
      'name' => '토스뱅크',
      'siwft' => '',
    ),
    '081' => 
    array (
      'name' => '하나은행',
      'siwft' => 'HNBNKRSE',
    ),
    '023' => 
    array (
      'name' => 'SC제일은행',
      'siwft' => 'SCBLKRSE',
    ),
  ),
  'default' => 
  array (
    'roles' => 
    array (
      'default_role' => 'user',
    ),
    'delivery' => 
    array (
      'fee' => 0,
      'type' => 'none',
      'min' => 0,
    ),
    'delivery_status' => 
    array (
      0 => '배송대기',
      10 => '배송중',
      20 => '배송완료',
      30 => '주문취소',
      40 => '반품',
    ),
    'pay_status' => 
    array (
      0 => '지불대기',
      10 => '지불완료',
      20 => '결제취소',
    ),
    'payment' => 
    array (
      'pg' => 'kcp',
      'mid' => 'T0000',
      'sitekey' => '3grptw1.zW0GSo4PQdaGvsF__',
      'submit_url' => 'https://testpay.kcp.co.kr/plugin/payplus_web.jsp',
      'naver' => false,
      'kakao' => false,
    ),
    'template' => 
    array (
      'layout' => 'default',
      'main' => 'default',
      'shop' => 
      array (
        'theme' => 'default',
        'lists' => 20,
      ),
      'cart' => 
      array (
        'theme' => 'default',
      ),
      'order' => 'default',
      'userpage' => 'default',
      'search' => 
      array (
        'theme' => 'default',
        'lists' => 20,
      ),
      'auth' => 'default',
      'component' => 'default',
      'ci' => 'logo.png',
    ),
    'banks' => 
    array (
      '039' => 
      array (
        'name' => '경남은행',
        'siwft' => 'KYNAKR22XXX',
      ),
      '034' => 
      array (
        'name' => '광주은행',
        'siwft' => 'KWABKRSE',
      ),
      '004' => 
      array (
        'name' => '국민은행',
        'siwft' => 'CZNBKRSE',
      ),
      '003' => 
      array (
        'name' => '기업은행',
        'siwft' => 'IBKOKRSE',
      ),
      '011' => 
      array (
        'name' => '농협은행',
        'siwft' => 'NACFKRSEXXX',
      ),
      '031' => 
      array (
        'name' => '대구은행',
        'siwft' => 'DAEBKR22',
      ),
      '032' => 
      array (
        'name' => '부산은행',
        'siwft' => 'PUSBKR2P',
      ),
      '002' => 
      array (
        'name' => '산업은행',
        'siwft' => 'KODBKRSE',
      ),
      '050' => 
      array (
        'name' => '상호저축은행',
        'siwft' => '',
      ),
      '045' => 
      array (
        'name' => '새마을금고',
        'siwft' => '',
      ),
      '007' => 
      array (
        'name' => '수협은행',
        'siwft' => 'NFFCKRSE',
      ),
      '027' => 
      array (
        'name' => '씨티은행',
        'siwft' => 'CITIKRSX',
      ),
      '088' => 
      array (
        'name' => '신한은행',
        'siwft' => 'SHBKKRSE',
      ),
      '048' => 
      array (
        'name' => '신협은행',
        'siwft' => '',
      ),
      '005' => 
      array (
        'name' => '외환은행',
        'siwft' => 'KEOXKRSE',
      ),
      '020' => 
      array (
        'name' => '우리은행',
        'siwft' => 'HVBKKRSEXXX',
      ),
      '071' => 
      array (
        'name' => '우체국은행',
        'siwft' => 'SHBKKRSEPO',
      ),
      '037' => 
      array (
        'name' => '전북은행',
        'siwft' => 'JEONKRSE',
      ),
      '035' => 
      array (
        'name' => '제주은행',
        'siwft' => 'JJBKKR22',
      ),
      '090' => 
      array (
        'name' => '카카오뱅크',
        'siwft' => 'CITIKRSXKAK',
      ),
      '089' => 
      array (
        'name' => '케이뱅크',
        'siwft' => '',
      ),
      '092' => 
      array (
        'name' => '토스뱅크',
        'siwft' => '',
      ),
      '081' => 
      array (
        'name' => '하나은행',
        'siwft' => 'HNBNKRSE',
      ),
      '023' => 
      array (
        'name' => 'SC제일은행',
        'siwft' => 'SCBLKRSE',
      ),
    ),
  ),
  'sms' => 
  array (
    'vendor' => 'smsto',
    'key' => 'ADFAFAF',
    'id' => 'ASDFADFADF',
    'sender' => 'ADFADFA',
    'manager_rec_order' => true,
  ),
  'user' => 
  array (
    'active' => 'auto',
  ),
);