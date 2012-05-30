<?php
require dirname(__DIR__).'/app/conf/loader.php';

$app = new Msh(
  array(
    'view' => new Msh_View_Smarty(),
    'mode' => 'development',
    'debug' => true,
    'languages' => array(
      //'en' => 'English'
      'ru' => 'Russian'
    )
  )
);


$app->loadConfig('db');
$app->add(new Msh_Middleware_Languages_Standart());
//$app->setLanguage('ru');

#PUBLIC
$app->mapController('/contact', 'Demo_Controller_Contact');
$app->mapController('/', 'Demo_Controller_Main');

#ADMIN
$app->mapController('/admin', 'Msh_Controller_Admin');

Msh_Session::start();
$app->run();

/*-------------------------------------------------------*/
#TODO: pridumatj gde hranitj eti funkciji

function dump($r, $return = false, $specialchars = true) {

  $isobj = (is_array($r) || is_object($r));

  if ($isobj) {

    ob_start();
    print_r($r);
    $s = ob_get_contents();
    ob_end_clean();
  }
  else {

    $s = $r;
  }

  if ($specialchars) $s = htmlspecialchars($s);

  if (!$return) {

    $s = str_replace(' ', '&nbsp;', $s);
    $s = str_replace("\n", '<br>', $s);
  }

  if ($return) return $s; else echo $s . '<br>';
  return null;
}

/**
 * main translate funcdtion
 * @param $key
 * @param null $lng
 * @return string
 */
function __($key, $lng = null) {

  $s = Msh_Translation::get($key, $lng);
  if (!$s) return '{' . $key . '}';
  return $s;
}

/**
 * needed for smarty
 * @param $key
 * @param $r
 * @return string
 */
function __c($key, $r) {
  $lng = Msh::getInstance()->getLanguage();
  if (!empty($r[$lng])) return $r[$lng];
  return '{' . $key . '}';
}
