<?php
namespace App\Services\Market;

use App\Models\Market\MarketConfig;
use Config;

class ConfigService
{

  public function get($key = null) {
    if ($key) {
      return config('market.'.$key);
    } else {
      return config('market');
    }
    
  }

  public function set($key, $data) {
    if(is_array($data)) {
      foreach($data as $k => $v) {
        config()->set('market.'.$key.'.'.$k, $v);
      }
    } else {
      config()->set('market.'.$key, $data);
    }
    

    $text = '<?php return ' . var_export(config('market'), true) . ';';

    // print_r($text);
    file_put_contents(config_path('market.php'), $text);

    // \Artisan::call('config:cache'); // 만약 production mode이고 config를 cache 하여 사용하면
  }
}