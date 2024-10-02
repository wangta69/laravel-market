<?php
namespace Pondol\Market;

// use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Pondol\Market\Console\InstallCommand;
use Illuminate\Support\Facades\Route;
class MarketServiceProvider extends ServiceProvider { //  implements DeferrableProvider
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    if ($this->app->runningInConsole()) {
      $this->commands([
        InstallCommand::class,
        // Console\InstallCommand::class,
      ]);
    }

    if(file_exists( app_path('/Listeners/OrderShippedEventSubscriber.php')  )) {
      Event::subscribe(\App\Listeners\OrderShippedEventSubscriber::class);
    }

    // if(file_exists( app_path('/Listeners/SendRegisteredNotification.php')  )) {
    //   Event::subscribe(\App\Listeners\SendRegisteredNotification::class);
    // }
  }

  /**
     * Bootstrap any application services.exi
     *
     * @return void
     */
    //public function boot(\Illuminate\Routing\Router $router)
  public function boot(\Illuminate\Routing\Router $router)
  {

    if(file_exists( base_path('/routes/market-admin.php')  )) {
      Route::middleware(['web'])->group(function () {
        $this->loadRoutesFrom(base_path('/routes/market-admin.php'));
      });
      Route::middleware(['web'])->group(function () {
        $this->loadRoutesFrom(base_path('/routes/market.php'));
      });
    }

    $this->publishes([
      // Events and Listeners;
      __DIR__.'/Events/' => app_path('Events'),
      __DIR__.'/Listeners/' => app_path('Listeners')
    ]);




    // $router->aliasMiddleware('role', \App\Http\Middleware\CheckRole::class);
    // app('router')->aliasMiddleware('role', \App\Http\Middleware\CheckRole::class);
		// $router->pushMiddlewareToGroup('admin', 'role:administrator');

  //   $this->routes(function () {
  //     Route::middleware('web')
  //         ->namespace($this->namespace)
  //         ->group(base_path('routes/market.php'));
  //     Route::middleware('web')
  //         ->namespace($this->namespace)
  //         ->group(base_path('routes/market-admin.php'));
  // });


    // \Log::info('boot');
    // \Log::info('$this->app->runningInConsole()');
    // // if (! $this->app->runningInConsole()) {
    // //   return;
    // // }
    // \Log::info('next');


    // $this->loadMigrationsFrom(__DIR__.'./database/migrations/');
    // //$this->artisan('migrate');
    // \Artisan::call('migrate');
  }

  /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    // public function provides()
    // {
    //   return [Console\InstallCommand::class];
    // }
}
