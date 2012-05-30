<?php
function smarty_modifier_phone_format($s) {

  $p = substr($s, 0, 3);
  $r = array('370', '371', '372');
  if (!in_array($p, $r)) return $s;

  return $p.' '.substr($s, 3);
}