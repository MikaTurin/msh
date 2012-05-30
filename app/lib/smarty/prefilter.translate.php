<?php
function smarty_prefilter_translate($s, &$smarty ) {


  preg_match_all('/\{lang:([a-z0-9_\.]+)\|?([a-z0-8-_]*)\}/is', $s, $r);
  //TODO: add  modifier functions
  $c = sizeof($r[1]);

  for ($i=0; $i<$c; $i++) {

    $q = '<hex|pex?php echo __c(\''.$r[1][$i].'\','.Msh_Translation::toPhpCode(Msh_Translation::getValsByKey($r[1][$i])).');?hex|pex>';
    $s = str_replace($r[0][$i], $q, $s);

  }

//  header('Content-type: text/plain');
//  echo $s;
//  die();
  return $s;

  //$s = preg_replace('/\{lang:([a-z0-9_]+)\|?([a-z0-8-_]*)\}/is', '<hex|pex?php echo \\2(__(\'\\1\'));?hex|pex>', $s);
}