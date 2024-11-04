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

class MarketServiceProvider extends ServiceProvider { //  implements DeferrableProvider
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
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

    $this->publishes([
      __DIR__ . '/config/pondol-market.php' => config_path('pondol-market.php'),
    ], 'config');
    $this->mergeConfigFrom(
      __DIR__ . '/config/pondol-market.php',
      'pondol-market'
    );

    $this->loadMarketRoutes();

    $this->commands([
      InstallCommand::class
    ]);


    $this->loadViewsFrom(__DIR__.'/resources/views', 'market');

        // migration
    // (new Filesystem)->copyDirectory(__DIR__.'/../database/migrations', database_path('migrations'));
    $this->loadMigrationsFrom(__DIR__.'/database/migrations/');
        //resources
        // (new Filesystem)->copyDirectory(__DIR__.'/../resources/market', resource_path('pondol/market'));
    
        // language
   // new Filesystem)->copyDirectory(__DIR__.'/../resources/lang', resource_path('lang'));
    $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'market');
         // resource > view...
    // (new Filesystem)->ensureDirectoryExists(resource_path('views/market'));
    // (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
    // (new Filesystem)->ensureDirectoryExists(resource_path('views/components'));

    // (new Filesystem)->copyDirectory(__DIR__.'/../resources/views/market', resource_path('views/market'));


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
