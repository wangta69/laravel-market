<?php
namespace Pondol\Market\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
  use InstallsBladeStack;

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'pondol:install-market {type=full}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Install the Market controllers and resources';


  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    $type = $this->argument('type');
    return $this->installBladeStack($type);
  }


  protected static function updateNodePackages(callable $callback, $dev = true)
  {
    if (! file_exists(base_path('package.json'))) {
      return;
    }

    $configurationKey = $dev ? 'devDependencies' : 'dependencies';

    $packages = json_decode(file_get_contents(base_path('package.json')), true);

    $packages[$configurationKey] = $callback(
      array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
      $configurationKey
    );

    ksort($packages[$configurationKey]);

    file_put_contents(
      base_path('package.json'),
      json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
    );
  }

  protected function updateWebpackMix(){
    
    $data = "
mix.sass('resources/pondol/market/front.scss', 'public/pondol/market/assets/front.css', {
  sassOptions: {
    quietDeps: true,
  },
});

mix.scripts([
  'node_modules/jquery/dist/jquery.js',
  'node_modules/@popperjs/core/dist/umd/popper.js',
  'node_modules/bootstrap/dist/js/bootstrap.js',
  // 'node_modules/venobox/dist/venobox.min.js',
  'resources/pondol/market/front.js',
  'resources/pondol/market/common.js',
  'resources/pondol/route.js',
], 'public/pondol/market/assets/front.js').version();
  
  
  
mix.sass('resources/pondol/market/admin.scss', 'public/pondol/market/assets/admin.css', {
  sassOptions: {
      quietDeps: true,
    },
  }
);
  
 
mix.scripts([
  'node_modules/jquery/dist/jquery.js',
  'node_modules/jquery-ui/dist/jquery-ui.js',
  'node_modules/@popperjs/core/dist/umd/popper.js',
  'node_modules/bootstrap/dist/js/bootstrap.js',
  'node_modules/chart.js/dist/chart.umd.js',
  'resources/pondol/market/common.js',
  'resources/pondol/route.js',
  'resources/pondol/market/admin.js',
  'resources/pondol/market/date-select.js',
], 'public/pondol/market/assets/admin.js').version();
";

    $webpackmix = file_get_contents(base_path('webpack.mix.js'));
    if (!strpos($webpackmix, 'public/pondol/market/assets/front.css')) {
      $this->info(" webpack.mix.js update ");
      \File::append(base_path('webpack.mix.js'), $data);
    }

  }

  protected function replaceInFile($search, $replace, $path)
  {
    file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
  }

  protected function chageOtherConfig() {
    $configs = [
      'pondol-auth'=>[
        'component.admin.layout'=>['pondol-auth::admin', 'market::app-admin'], 
        'route_auth_admin.prefix'=>['auth/admin', 'admin/auth']
      ],
      'pondol-mailer'=>[
        'component.admin.layout'=>['pondol-mailer::admin', 'market::app-admin'], 
        'prefix'=>['mailer', 'admin/mailer']
      ],
      'pondol-visitor'=>[
        'component.admin.layout'=>['visitors::admin', 'market::app-admin'], 
        'route_admin.prefix'=>['visitors/admin', 'admin/visitors']
      ]
    ];

    foreach($configs as $key => $val) {
      foreach($val as $k => $v) {
        if (config($key.'.'.$k) == $v[0]) {
          $this->comment( $key);
          $this->comment( $k);
          $this->comment( $v[0]);
          $this->comment( $v[1]);
          set_config($key, [$k => $v[1]]);
        }
      }
    }
  }


  
/*
  protected static function flushNodeModules()
  {
    tap(new Filesystem, function ($files) {
      $files->deleteDirectory(base_path('node_modules'));

      $files->delete(base_path('yarn.lock'));
      $files->delete(base_path('package-lock.json'));
    });
  }

*/

/*
  protected function phpBinary()
  {
    return (new PhpExecutableFinder())->find(false) ?: 'php';
  }
  */


  /*
  protected function installTests()
  {
    (new Filesystem)->ensureDirectoryExists(base_path('tests/Feature/Auth'));

    $stubStack = $this->argument('stack') === 'api' ? 'api' : 'default';

    if ($this->option('pest')) {
      $this->requireComposerPackages('pestphp/pest:^1.16', 'pestphp/pest-plugin-laravel:^1.1');

      (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/'.$stubStack.'/pest-tests/Feature', base_path('tests/Feature/Auth'));
      (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/'.$stubStack.'/pest-tests/Unit', base_path('tests/Unit'));
      (new Filesystem)->copy(__DIR__.'/../../stubs/'.$stubStack.'/pest-tests/Pest.php', base_path('tests/Pest.php'));
    } else {
      (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/'.$stubStack.'/tests/Feature', base_path('tests/Feature/Auth'));
    }
  }


  protected function installMiddlewareAfter($after, $name, $group = 'web')
  {
    $httpKernel = file_get_contents(app_path('Http/Kernel.php'));

    $middlewareGroups = Str::before(Str::after($httpKernel, '$middlewareGroups = ['), '];');
    $middlewareGroup = Str::before(Str::after($middlewareGroups, "'$group' => ["), '],');

    if (! Str::contains($middlewareGroup, $name)) {
      $modifiedMiddlewareGroup = str_replace(
        $after.',',
        $after.','.PHP_EOL.'            '.$name.',',
        $middlewareGroup,
      );

      file_put_contents(app_path('Http/Kernel.php'), str_replace(
        $middlewareGroups,
        str_replace($middlewareGroup, $modifiedMiddlewareGroup, $middlewareGroups),
        $httpKernel
      ));
    }
  }


  protected function requireComposerPackages($packages)
  {
    $composer = $this->option('composer');

    if ($composer !== 'global') {
      $command = ['php', $composer, 'require'];
    }

    $command = array_merge(
      $command ?? ['composer', 'require'],
      is_array($packages) ? $packages : func_get_args()
    );

    (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
      ->setTimeout(null)
      ->run(function ($type, $output) {
        $this->output->write($output);
      });
  }

*/
}
