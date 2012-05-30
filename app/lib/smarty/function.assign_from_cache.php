<?php

function smarty_function_assign_from_cache($params, &$smarty) {

  if (isset($params['var']) && isset($params['key']))
    $smarty->assign($params['var'], Cache::get($params['key']));   
}
