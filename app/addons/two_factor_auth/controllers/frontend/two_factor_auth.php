<?php

use Tygh\Tygh;
use Tygh\Registry;

defined('BOOTSTRAP') or die('Access denied');
//$auth = & Tygh::$app['session']['auth'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mode === 'verify') {
        fn_print_die($auth);
    }
    if ($mode === "reset") {
        fn_print_die('reset');
    }
}

if ($mode === 'check') {
//    $user_id = $auth['user_id'];
//    $secret = fn_set_secret($user_id);
}


