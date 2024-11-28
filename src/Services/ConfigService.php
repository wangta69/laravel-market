<?php
namespace Pondol\Market\Services;

use Pondol\Market\Models\MarketConfig;
use Config;

class ConfigService
{

  public function get($key = null) {
    if ($key) {
      return config('pondol-market.'.$key);
    } else {
      return config('pondol-market');
    }
    
  }

  public function set($key, $data) {
    if(is_array($data)) {
      foreach($data as $k => $v) {
        config()->set('pondol-market.'.$key.'.'.$k, $v);
      }
    } else {
      config()->set('pondol-market.'.$key, $data);
    }
    

    $text = '<?php return ' . var_export(config('pondol-market'), true) . ';';

    file_put_contents(config_path('pondol-market.php'), $text);

    // \Artisan::call('config:cache'); // 만약 production mode이고 config를 cache 하여 사용하면
  }
}