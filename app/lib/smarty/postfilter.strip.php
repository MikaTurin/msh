<?php
function smarty_postfilter_strip($s, &$smarty ) {

  $s = str_replace(array("\n", "\r", "\t"), '', $s);
  $s = preg_replace('/\s+/s', ' ', $s);
  /*$s = str_replace('> <', '><', $s);*/
  $s = str_replace('#SPACE#', ' ', $s);
  $s = str_replace('<hex|pex?php', '<?php', $s);
  $s = str_replace(');?hex|pex>', ');?>', $s);
  /*$s = preg_replace('/\{_([a-z_]+)\}/isU', '<?php echo __(\'\\1\');?>', $s);*/
  $s = trim($s);

  return $s;
}