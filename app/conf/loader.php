<?php
define('MSH_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR);

function msh_autoload($class) {

  $dir = MSH_DIR . 'vendors' . DIRECTORY_SEPARATOR;

  if ($class == 'Smarty') {
    require $dir . 'Smarty' . DIRECTORY_SEPARATOR . 'Smarty.class.php';
    return;
  }
  elseif (substr(strtolower($class), 0, 7) == 'smarty_') return;

  $parts = explode('_', $class);
  if (sizeof($parts) == 1) $dir .= $parts[0].DIRECTORY_SEPARATOR;
  $file = join(DIRECTORY_SEPARATOR, $parts) . '.php';
  if (file_exists($dir.$file)) require $dir.$file; else throw new Exception("Loader: class $class not found!");

  /*$mshLoadConfig = ''; //to hide error in next line in phpStorm
  if (isset($class::$mshLoadConfig) && $class::$mshLoadConfig) {
    $file = __DIR__.'/'.$class::$mshLoadConfig;
    if (!file_exists($file)) throw new Exception("Config for class $class not found");
    require $file;
  }*/
}

spl_autoload_register('msh_autoload');