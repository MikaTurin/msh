<?php
function smarty_modifier_duration($i) {

  $m = $i % 3600;
  $s = $m % 60;
  $h = floor($i / 3600);
  $m = floor($m / 60);
  $ss = '';
  if ($h) $ss .= $h.'&nbsp;'.__('d_hour');
  if ($m) $ss .= ' '.$m.'&nbsp;'.__('d_min');
  $ss .= ' '.$s.'&nbsp;'.__('d_sec');

  return trim($ss);
}