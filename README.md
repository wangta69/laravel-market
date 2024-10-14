# Laravel Market
## How to install laravel market

### 라라벨 인스톨 및 기본 처리
> 이 부분이 준비 되었으면 바로 다음 단계로 이동
1. .env 기본 정보 세팅
1.1 DB 정보 세팅
```
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
1.2 메일정보세팅
```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

2. laravel install
```
composer create-project laravel/laravel example-app
```
```
cd example-app
```




### 라라벨 마켙 install
```
composer require wangta69/laravel_market
php artisan pondol:install-market
```
```
Name for administrator?: // 관리자 이름
Email for administrator?: // 관리자 이메일
Password for administrator?: // 관리자 패스워드
```


### 기타 설정
#### Queue Worker 실행하기
> 메일등을 보내기 위한 비동기식 실행
```
nohup php artisan queue:listen >> storage/logs/laravel.log &
```
#### Job Schedule
> cron에 jobschedule 걸기
```
* * * * * cd /path-to-laravel-framework && php artisan schedule:run >> /dev/null 2>&1
```