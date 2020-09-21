<?php
// In this example, the vendor folder is located in root poc
require_once __DIR__.'/../vendor/autoload.php';

//-- Configuration ----------------------
define('TMP_PATH', sys_get_temp_dir()); // You can set your tmp folder
define('TEMPLATE_PATH', realpath(__DIR__.'/../template/'));
define('TEMPLATE_CACHE_LIFETIME', false);
//---------------------------------------

// Dossier temporaire
if (!is_dir(TMP_PATH) || !is_writable(TMP_PATH)) {
    mkdir(TMP_PATH, 0775);
}

$tpl = new smarty_plus(TEMPLATE_PATH, TMP_PATH, TEMPLATE_CACHE_LIFETIME);
//$tpl->debug(true);
//$tpl->force_compile = true;
