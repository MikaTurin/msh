<?php

function smarty_function_assign_from_model($params, &$smarty) {

  if (isset($params['var']) && isset($params['model']) && isset($params['func']))

    $smarty->assign(
      $params['var'],
      call_user_func(
        ucfirst(strtolower($params['model'])).'_Model::'.$params['func']
      )
    );


}
