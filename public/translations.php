<?php
require_once __DIR__.'/init.inc.php';

// Fonction factice de traduction
function getTrad($id_trad)
{
    static $list_trad = [
        336 => 'Dénomination commerciale',
        343 => 'Descriptif du dispositif',
    ];

    $trad = ((isset($list_trad[$id_trad])) ? $list_trad[$id_trad] : 'Untranslated!');

    return $trad;
}
$tpl->module_traduction('getTrad', ['Non', 'Oui']);

// Variables
$tpl->debug(rand(0, 1));
define('DEFINE_VAR', 'DEFINE_VAR');
$content = [
    'meta_title' => 'Introduction à Smarty+',
    'text1' => 'Lorem ipsu',
    'text2' => 'Dolor plus',
    'champ_1' => 0,
    'champ_2' => 1,
    'champ_3' => rand(0, 1),
];

// Assign
$tpl->assign($content);
$tpl->assign('text3', 'Hello World');
$tpl->assign_trad('text4', 336);

$tpl->display('smarty_plus.tpl');
