<?php

namespace Pondol\Market\Console;

use Illuminate\Support\Facades\Schema;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Hash;
use Pondol\Auth\Models\User\User;
use Pondol\Auth\Models\Role\Role;

trait InstallsBladeStack
{
  /**
   * Install the Blade Breeze stack.
   *
   * @return void
   */
  protected function installBladeStack($type)
  {
    // NPM Packages...
    $this->updateNodePackages(function ($packages) {
      return [
        '@tailwindcss/forms' => '^0.4.0',
        'alpinejs' => '^3.4.2',
        'autoprefixer' => '^10.4.2',
        "axios" => "^0.21",
        "chart.js" => "^4.4.6",
        "laravel-mix" => "^6.0.6",
        "lodash" => "^4.17.19",
        'postcss' => '^8.4.6',
        "resolve-url-loader" => "^5.0.0",
        "sass" => "^1.77.8",
        "sass-loader" => "^12.6.0",
        'tailwindcss' => '^3.0.18',
      ] + $packages;
    });

    $this->updateNodePackages(function ($packages) {
      return [
        "@fortawesome/fontawesome-free" => "^6.6.0",
        "@popperjs/core" => "^2.11.8",
        "bootstrap" => "^5.3.3",
        "font-awesome" => "^4.7.0",
        "jquery" => "^3.7.1",
        "jquery-ui" => "^1.14.0"
      ] + $packages;
    }, false);

    $this->updateWebpackMix();

    // 기존 web.php 백업시킨다.
    // copy(base_path('routes/web.php'), base_path('routes/web.back.php'));
    // copy(__DIR__.'/../routes/web-blank.php', base_path('routes/web.php'));

    $this->replaceInFile('/home', '/', app_path('Providers/RouteServiceProvider.php'));

    $this->call('pondol:install-editor');
    $this->call('pondol:install-auth', ['type'=> 'simple']);
    $this->call('pondol:install-mailer', ['type'=> 'only']);
    // laravel board
    \Artisan::call('vendor:publish',  [
      '--force'=> true,
      '--provider' => 'Pondol\Bbs\BbsServiceProvider'
    ]);

    if(!Schema::hasTable('jobs')) {
      \Artisan::call('queue:table'); // job table  생성 (11 은 php artisan make:queue-table) 명령을 사용하는데 호환성 테스트 필요
    }

    // Market Install
    \Artisan::call('vendor:publish',  [
      '--force'=> true,
      '--provider' => 'Pondol\Market\MarketServiceProvider'
    ]);

    // meta install
    \Artisan::call('vendor:publish',  [
      '--force'=> true,
      '--provider' => 'Pondol\Meta\MetaServiceProvider'
    ]);

    // auth 관련 변경
    configSet('pondol-auth', ['activate' => 'auto', 'template.user'=>'default-market', 'template.mail'=>'default-market']); // 

    \Artisan::call('migrate');

    // 연관 패키지의 config  변경
    $this->chageOtherConfig();

    $this->comment('Please execute the "npm install" && "npm run dev" commands to build your assets.');
  }
}
