<?php
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


/**
 * $item
 * @return  [[0] => 옵션 ID, [1] => 옵션명, [2] => 옵션값, [3] => 재고여부]
 */
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
