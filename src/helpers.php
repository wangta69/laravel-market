<?php
use Pondol\Common\Facades\JsonKeyValue;

if (!function_exists('market_theme')) {
  function market_theme($theme){
    $template = JsonKeyValue::getAsJson('market.template');
    return 'market.templates.'.$theme.'.'.$template->{$theme}->theme;
  }
}

if (!function_exists('market_get_thumb')) {
  function market_get_thumb($file, $width=null, $height=null){
    return Pondol\Market\Services\ViewerService::get_thumb($file, $width, $height);
  }
}

if (!function_exists('getImageUrl')) {
  function getImageUrl($url) {
    return \Storage::url($url);
  }
}

if (!function_exists('delivery_fee_show')) {
  function delivery_fee_show() {
    $delivery = jsonval('market.delivery');
    switch($delivery["type"]) {
      case 'none':
        return '무료';
      case 'on_delivery':
        return '착불';
      case 'apply':
        return number_format($delivery["fee"]);
      case 'partial':
        return number_format($delivery["fee"]).'('. number_format($delivery["min"]). ' 이상 구매시 무료) ';
    }
  }
}

/**
 * $item
 * @return  [[0] => 옵션 ID, [1] => 옵션명, [2] => 옵션값, [3] => 재고여부]
 */
if (!function_exists('extractOptions')) {
  function extractOptions($item) {
    if($item->options) {
      $options = explode('|', $item->options);
      $displayOption = [];
      foreach($options as $option) {
        array_push($displayOption, explode(':', $option));
      }
      return  $displayOption; 
    } 
  }
}

if (!function_exists('configSet')) {
  function configSet($file, $data) {

    foreach($data as $k => $v) {
      config()->set($file.'.'.$k, $v);
    }
    
    $text = '<?php return ' . var_export(config($file), true) . ';';
    file_put_contents(config_path($file.'.php'), $text);
    // \Artisan::call('config:cache'); // 만약 production mode이고 config를 cache 하여 사용하면
  }
}
