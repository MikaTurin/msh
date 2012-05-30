<?php
function smarty_modifier_preview($s) {

  $s = preg_replace('/\[.*\]/isU', '', $s);
  $s = str_replace(array("'",'"',"\n","\r"), array("\\'","\\'",' ',''), $s);

  $s = strip_tags($s);

  $smiles_array = Registry::get('forum_emotions');
  $smiles_keys = array_keys($smiles_array);
  $smiles = str_replace(array('(', ')'), array('\(', '\)'), array_map(function ($smile) { return "/$smile/"; }, $smiles_keys));
  $s = preg_replace($smiles, '', $s);

	if (mb_strlen($s, 'UTF-8') > 200) {
    $s = mb_substr($s, 0, 200, 'UTF-8').' ...&raquo;&raquo;';
	}
	return $s;
}