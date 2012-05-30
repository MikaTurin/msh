<?php

function smarty_function_assign_from_registry($params, &$smarty) {

  if (isset($params['var']) && isset($params['key']))
    $smarty->assign($params['var'], Registry::get($params['key']));   
}