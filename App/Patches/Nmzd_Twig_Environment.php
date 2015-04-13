<?php

namespace App\Patches;

use \Twig_Environment;

class Nmzd_Twig_Environment extends Twig_Environment {

  /**
  * This exists so template cache files use the same
  * group between apache and cli
  */
  protected function writeCacheFile($file, $content){
      if (!is_dir(dirname($file))) {
          $old = umask(0000);
          mkdir(dirname($file),0777,true);
          chmod(dirname($file), 0777);
          umask($old);
      }
      parent::writeCacheFile($file, $content);
      chmod($file,0777);
  }
}