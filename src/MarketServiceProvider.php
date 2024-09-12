<?php
namespace Pondol\Market;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class MarketServiceProvider extends ServiceProvider implements DeferrableProvider {
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
  public function boot()
  {


    \Log::info('boot');
    \Log::info('$this->app->runningInConsole()');
    if (! $this->app->runningInConsole()) {
      return;
    }
    \Log::info('next');
    $this->commands([
      Console\InstallCommand::class,
    ]);
  }

  /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
      return [Console\InstallCommand::class];
    }
}
