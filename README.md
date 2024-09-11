# Laravel Market
## How to install laravel market

1. laravel install
  
2. config/auth.php

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