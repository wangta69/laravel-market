<?php

namespace Pondol\Market\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Hash;
use App\Models\Market\Auth\User\User;
use App\Models\Market\Auth\Role\Role;

trait InstallsBladeStack
{
  /**
   * Install the Blade Breeze stack.
   *
   * @return void
   */
  protected function installBladeStack()
  {
    // NPM Packages...
    $this->updateNodePackages(function ($packages) {
        return [
            '@tailwindcss/forms' => '^0.4.0',
            'alpinejs' => '^3.4.2',
            'autoprefixer' => '^10.4.2',
            "axios" => "^0.21",
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

    // Controllers...
    (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers/Market'));
    (new Filesystem)->copyDirectory(__DIR__.'/../app/Http/Controllers/Market', app_path('Http/Controllers/Market'));
    
    // Models...
    (new Filesystem)->ensureDirectoryExists(app_path('Models/Market'));
    (new Filesystem)->copyDirectory(__DIR__.'/../app/Models/Market', app_path('Models/Market'));

    // // Requests...
    // (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests/Auth'));
    // (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/App/Http/Requests/Auth', app_path('Http/Requests/Auth'));

    // View 
    (new Filesystem)->copyDirectory(__DIR__.'/../app/View/Components', app_path('View/Components'));

    // resource > view...
    (new Filesystem)->ensureDirectoryExists(resource_path('views/market'));
    // (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
    // (new Filesystem)->ensureDirectoryExists(resource_path('views/components'));

    (new Filesystem)->copyDirectory(__DIR__.'/../resources/views/market', resource_path('views/market'));
    // (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/resources/views/layouts', resource_path('views/layouts'));
    // (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/resources/views/components', resource_path('views/components'));

    // copy(__DIR__.'/../../stubs/default/resources/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));
    // Middle ware
    copy(__DIR__.'/../app/Http/Middleware/CheckRole.php', app_path('Http/Middleware/CheckRole.php'));
    // // Components...
    // (new Filesystem)->ensureDirectoryExists(app_path('View/Components'));
    // (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/App/View/Components', app_path('View/Components'));

    // // Tests...
    // $this->installTests();

    // Routes...
    copy(__DIR__.'/../routes/market-admin.php', base_path('routes/market-admin.php'));
    copy(__DIR__.'/../routes/market.php', base_path('routes/market.php'));
    // 기존 web.php 백업시킨다.
    copy(base_path('routes/web.php'), base_path('routes/web.back.php'));
    copy(__DIR__.'/../routes/web.php', base_path('routes/web.php'));
    // config
    copy(__DIR__.'/../config/market.default.php', base_path('config/market.php'));

    // migration
    (new Filesystem)->copyDirectory(__DIR__.'/../database/migrations', database_path('migrations'));

    //resources
    (new Filesystem)->copyDirectory(__DIR__.'/../resources/market', resource_path('market'));

    // language
    (new Filesystem)->copyDirectory(__DIR__.'/../resources/lang', resource_path('lang'));

    // Home route
    // $this->replaceInFile('/home', '/dashboard', resource_path('views/welcome.blade.php'));
    // $this->replaceInFile('Home', 'Dashboard', resource_path('views/welcome.blade.php'));
    $this->replaceInFile('/home', '/', app_path('Providers/RouteServiceProvider.php'));
    // confing > auth 
    $this->replaceInFile("'model' => App\Models\User::class,", "'model' => App\Models\Market\Auth\User\User::class,", config_path('auth.php'));
    // // Tailwind / Webpack...
    // copy(__DIR__.'/../../stubs/default/tailwind.config.js', base_path('tailwind.config.js'));
    // copy(__DIR__.'/../../stubs/default/webpack.mix.js', base_path('webpack.mix.js'));
    // copy(__DIR__.'/../../stubs/default/resources/css/app.css', resource_path('css/app.css'));
    // copy(__DIR__.'/../../stubs/default/resources/js/app.js', resource_path('js/app.js'));
    // soft link
    \Artisan::call('storage:link');

    \Artisan::call('vendor:publish',  [
      '--force'=> true,
      '--provider' => 'Pondol\Market\MarketServiceProvider'
    ]);

    // editor
    \Artisan::call('vendor:publish',  [
      '--force'=> true,
      '--provider' => 'Pondol\Editor\EditorServiceProvider'
    ]);
    $this->info('The laravel editor installed successfully.'); 
    // laravel board
    \Artisan::call('vendor:publish',  [
      '--force'=> true,
      '--provider' => 'Pondol\Bbs\BbsServiceProvider'
    ]);

    \Artisan::call('queue:table'); // job table  생성 (11 은 php artisan make:queue-table) 명령을 사용하는데 호환성 테스트 필요
    \Artisan::call('migrate');
    \Artisan::call('pondol:install-auth');

    // $user_name = $this->ask('Name for administrator?'); 
    // $user_email = $this->ask('Email for administrator?'); 
    // $user_password = $this->ask('Password for administrator?'); 
    
    // $count = User::where('email', $user_email)->count();
    // if(!$count) {
    //   $user = User::create([
    //     'name' => $user_name,
    //     'email' => $user_email,
    //     'password' => Hash::make($user_password),
    //   ]);

    //   $user->active = 1;
    //   $user->save();
    //   $user->roles()->attach(Role::firstOrCreate(['name' => 'administrator']));
    // }



      // $this->info('Breeze scaffolding installed successfully.');
      // $this->comment('Please execute the "php artisan migrate" commands to build market database.');
    $this->comment('Please execute the "npm install" && "npm run dev" commands to build your assets.');
  }
}
