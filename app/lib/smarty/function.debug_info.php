<?php
function smarty_function_debug_info($params, &$smarty) {

  if (!isset($_SESSION['debug'])) return '';
  return Front::getInstance()->showDebugInfo();
}