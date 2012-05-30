<?php
/**
 * @var $smarty Smarty
 */

$smarty->setTemplateDir(MSH_DIR.'templates/');
$smarty->setCompileDir(MSH_DIR.'cache/smarty/');
$smarty->addPluginsDir(MSH_DIR.'lib/smarty/');

$smarty->loadFilter('pre', 'translate');
$smarty->loadFilter('post', 'strip');

//self::$smarty->caching = 0;
$smarty->compile_check = true;
$smarty->force_compile = true;

$lng = Msh::getInstance()->getLanguage();
$smarty->assign('LANGUAGE', $lng);
$smarty->assign('LURL', Msh::getInstance()->config('LURL'));
$smarty->error_reporting = E_ALL ^ E_NOTICE;

if (isset($_SESSION['isadmin'])) $smarty->assign('isadmin', $_SESSION['isadmin']);