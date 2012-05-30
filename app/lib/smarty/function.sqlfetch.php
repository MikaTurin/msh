<?php
function smarty_function_sqlfetch($params, $template) {

  if (!isset($params['handle']) || !is_resource($params['handle'])) return null;
  return Sql::fetchAssoc($params['handle']);
}