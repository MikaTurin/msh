<?php
function smarty_function_trans_options($params, &$smarty) {

/*  $lang = Front::getInstance()->getLang();
  Sql::query("SELECT id FROM translations WHERE lng='{$lang}' AND val='' ORDER BY id");
  $c = Sql::numRows();
  $s = '';
  for ($i=0; $i<$c; $i++) {
    $r = Sql::fetchArray();
    $id = $r[0];
    $s .= '<option>'.$id.'</option>';
  }
  return $s;*/


  $r = __(null, true);
  ksort($r);
  $s = '';
  foreach ($r as $k => $v) {

    if (substr($k, 0, 8) == 'country_') continue;
    $s .= '{id:"'.$k.'",txt:"'.str_replace('"', '\\"', $v).'"},';
  }
  $s = substr($s, 0, -1);
  return $s;
}
