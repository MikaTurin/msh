<?php

function smarty_function_region($params, &$smarty) {

  if (!isset($params['key'])) return;
  $id = $params['key'];

  //$lng = Front::getInstance()->getLang();
  $val = '';
  if (isset($params['value'])) $val = $params['value'];


  if (Admin::online()) {
    $val = '<div id="'.$id.'" class="mercury-region efld" data-type="editable">'.$val.'</div>';
  }
  return $val;
}
