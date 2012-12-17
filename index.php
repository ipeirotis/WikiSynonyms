<?php

error_reporting(E_ALL ^ E_NOTICE);
require 'config/config.php';
require('library/smarty/Smarty.class.php');
require 'library/helper.php';
require 'library/application.php';


$base = realpath(dirname(__FILE__));
$smarty = new Smarty();
$smarty->setTemplateDir($base . '/templates');
$smarty->setCompileDir($base . '/library/smarty/templates_c');
$smarty->setCacheDir($base . '/library/smarty/cache');
$smarty->setConfigDir($base . '/library/smarty/configs');

$content = '';
$action = isset($_REQUEST['action']) ? strtolower($_REQUEST['action']) : 'search';
$script = $base . '/scripts/' . $action . '.php';
if (file_exists($script)) {
  require $script;
}

$smarty->assign('content', $content);
$smarty->display('layout.tpl');