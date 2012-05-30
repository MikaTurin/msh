<?php
function smarty_function_trans($params, &$smarty) {

  if (!isset($params['key'])) return '';
  if (isset($params['var'])) {
    $smarty->assign($params['var'], __($params['key']));
    return '';
  }
  return __($params['key']);
}