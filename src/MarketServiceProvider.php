<?php
namespace Pondol\Market;
use Illuminate\Support\Facades\Event;
// use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

use Pondol\Market\Console\InstallCommand;
use Pondol\Market\Listeners\MarketEventSubscriber;
use Pondol\Market\View\Components\MarketCategory;
use Pondol\Market\View\Components\MarketNavyCategory;
use Pondol\Market\View\Components\Banner;
use Pondol\Market\View\Components\MailFooter;
use Pondol\Market\Services\DeliveryFee;

class MarketServiceProvider extends ServiceProvider { //  implements DeferrableProvider
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->singleton('market-delivery-fee', function () {
      return new DeliveryFee();
    });
  }

  /**
     * Bootstrap any application services.exi
     *
     * @return void
     */
    //public function boot(\Illuminate\Routing\Router $router)
  public function boot(\Illuminate\Routing\Router $router)
  {

    Event::subscribe(MarketEventSubscriber::class);
    Blade::component('market-category', MarketCategory::class);
    Blade::component('market-navy-category', MarketNavyCategory::class);
    Blade::component('market-banner', Banner::class);
    Blade::component('market-mail-footer', MailFooter::class);
   
    if (!config()->has('pondol-market')) {
      $this->publishes([
        __DIR__ . '/config/pondol-market.php' => config_path('pondol-market.php'),
      ], 'config'); 
    } 

    $this->mergeConfigFrom(
      __DIR__ . '/config/pondol-market.php',
      'pondol-market'
    );

    $this->loadMarketRoutes();

    $this->commands([
      InstallCommand::class
    ]);

    $this->loadViewsFrom(__DIR__.'/resources/views', 'market');
    $this->loadMigrationsFrom(__DIR__.'/database/migrations/');
    $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'market');

    $this->publishes([
      __DIR__.'/resources/market/images/' => public_path('pondol/market/assets/images'),
      __DIR__.'/resources/views/3rdparty-templates/auth/' => resource_path('views/auth/templates/views'),
      __DIR__.'/resources/views/3rdparty-templates/mail/' => resource_path('views/auth/templates/mail'),
      __DIR__.'/resources/market/' => resource_path('pondol/market'),
      __DIR__.'/resources/views/market' => resource_path('views/market')
    ]);

  
  }

  private function loadMarketRoutes()
  {
    $config = config('pondol-market.route_admin');

    Route::prefix($config['prefix'])
      ->as($config['as'])
      ->middleware($config['middleware'])
      ->namespace('Pondol\Market\Http\Controllers\Admin')
      ->group(__DIR__ . '/routes/admin.php');

    $config = config('pondol-market.route_web');
    Route::prefix($config['prefix'])
      ->as($config['as'])
      ->middleware($config['middleware'])
      ->namespace('Pondol\Market\Http\Controllers')
      ->group(__DIR__ . '/routes/web.php');
  }

}
