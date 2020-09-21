<?php
require_once __DIR__.'/init.inc.php';

$tpl->debugging = true;
$tpl->cache_lifetime = 120;

$tpl->assign('Name', 'Fred Irving Johnathan Bradley Peppergill', true);
$tpl->assign('FirstName', ['John', 'Mary', 'James', 'Henry']);
$tpl->assign('LastName', ['Doe', 'Smith', 'Johnson', 'Case']);
$tpl->assign('Class', [['A', 'B', 'C', 'D'], ['E', 'F', 'G', 'H'],
    ['I', 'J', 'K', 'L'], ['M', 'N', 'O', 'P'], ]);

$tpl->assign('contacts', [['phone' => '1', 'fax' => '2', 'cell' => '3'],
    ['phone' => '555-4444', 'fax' => '555-3333', 'cell' => '760-1234'], ]);

$tpl->assign('option_values', ['NY', 'NE', 'KS', 'IA', 'OK', 'TX']);
$tpl->assign('option_output', ['New York', 'Nebraska', 'Kansas', 'Iowa', 'Oklahoma', 'Texas']);
$tpl->assign('option_selected', 'NE');

$tpl->display('index.tpl');
