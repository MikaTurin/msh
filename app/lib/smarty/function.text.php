<?php

function smarty_function_text($params, &$smarty) {

  if (!isset($params['key'])) return;
  $id = 'text_'.$params['key'];

  $lng = Msh::getInstance()->getLanguage();
  $key = $id.'_'.$lng;
  //$s = Cache::get($key);
  $s = false;

  if ($s === false) {
    Sql::query("SELECT val FROM `translations` WHERE `id`='{$id}' AND `lng`='{$lng}'");

    if (Sql::numRows()) {
      $r = Sql::fetchArray();
      $s = $r[0];
      //Cache::set($key, $s, 0);
    }
  }
  if (isset($params['var'])) {
    $smarty->assign($params['var'], $s);
    return true;
  }

  if (!empty($_SESSION['isadmin'])) {
    $s = '<div id="'.$id.'" class="mercury-region efld" data-type="editable">'.$s.'</div>';
  }
  return $s;
}
