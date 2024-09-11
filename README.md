# Laravel Market
## How to install laravel market

### 라라벨 인스톨 및 기본 처리
> 이 부분이 준비 되었으면 바로 다음 단계로 이동
1. laravel install
```
composer create-project laravel/laravel example-app
```
```
cd example-app
```
.env db 정보 세팅



### 라라벨 마켙 install
```
composer require wangta69/laravel_market
```
1. config/auth.php

```
..........
'providers' => [
  'users' => [
    ..........
    // 'model' => App\Models\User::class,
    'model' => App\Models\Market\Auth\User\User::class,
  ],
..........
]
```

3. npm 관련

```
npm install jquery@3
npm install jquery-ui@1
npm install @popperjs/core@2
npm install bootstrap@5
npm install @fortawesome/fontawesome-free@6
npm install font-awesome@4

npm run dev
```