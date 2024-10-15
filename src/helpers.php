<?php
function market_get_thumb($file, $width=null, $height=null){
  return App\Services\Market\ViewerService::get_thumb($file, $width, $height);
}

function astro($str, $len, $position='end') {
  $ast = '';
  for ($i = 0; $i < $len; $i++) {
    $ast .= '*';
  }
  return mb_substr($str, '0', -$len) . $ast;
}

function getImageUrl($url) {
  return \Storage::url($url);
}


/**
 * 전화번호에 하이펀 추가
 */
function addHypenToMobile($tel) {
  if ($tel) {
    $tel = preg_replace("/[^0-9]*/s", "", $tel); // 숫자이외 제거

    if (substr($tel, 0, 2) == '02' ) {
      return preg_replace("/([0-9]{2})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", $tel);
    } else if(substr($tel, 0, 2) == '8' && substr($tel, 0, 2) == '15' || substr($tel, 0, 2) =='16' || substr($tel, 0, 2) == '18') {
      return preg_replace("/([0-9]{4})([0-9]{4})$/","\\1-\\2", $tel);
    } else {
      return preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", $tel);
      //핸드폰번호만 이용한다면 이것만 있어도 됨
    }
  } else {
    return $tel;
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
    // print_r($text);
    file_put_contents(config_path($file.'.php'), $text);
    // \Artisan::call('config:cache'); // 만약 production mode이고 config를 cache 하여 사용하면
  }
}
