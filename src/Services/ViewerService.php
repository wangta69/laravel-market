<?php
namespace Pondol\Market\Services;
use Pondol\Image\GetHttpImage;
class ViewerService
{

  /**
   * @param String $file  public/bbs/5/201804/37/filename.jpeg
   */
  public static function get_thumb($file, $width=null, $height=null) {
    if ($file) {
      if($width == null &&  $height == null) {
        return str_replace(["public"], ["/storage"], $file);
      } else if($width == null ) {
        $width = $height;
      } else if($height == null) {
        $height = $width;
      }
      $name = substr($file, strrpos($file, '/') + 1);
      $thum_dir = substr($file, 0, -strlen($name)).$width."_".$height;
      $thum_to_storage = storage_path() .'/app/'.$thum_dir;

      if(!file_exists($thum_to_storage."/".$name)){//thumbnail 이미지를 돌려준다.
        $file_to_storage = storage_path() .'/app/'.$file;
        $image = new GetHttpImage();

        try {
          // $image->read($file_to_storage)->set_size($width, $height)->copyimage()->save($thum_to_storage);
          $result = $image->read($file_to_storage)->set_size($width, $height)->copyimage();
          if ($result) {
              $result->save($thum_to_storage);
          }
        } catch (\Exception $e) {
        }
      }

      return str_replace(["public"], ["/storage"], $thum_dir)."/".$name;
    }else
      return '';
  }
}
