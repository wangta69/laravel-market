<?php
namespace Pondol\Market;
use Illuminate\Support\Facades\Event;
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

    if(file_exists( app_path('/Listeners/MarketEventSubscriber.php')  )) {
      Event::subscribe(\App\Listeners\MarketEventSubscriber::class);
    }

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
      __DIR__.'/Listeners/' => app_path('Listeners'),
      __DIR__.'/resources/market/images/' => public_path('pondol/market/assets/images'),
      __DIR__.'/resources/views/market/3rdparty-templates/auth/' => resource_path('views/auth/templates/views'),
      __DIR__.'/resources/views/market/3rdparty-templates/mail/' => resource_path('views/auth/templates/mail'),
    ]);

  }


}
