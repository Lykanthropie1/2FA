<?php

use Tygh\Languages\Languages;
use Tygh\Registry;


//Functions for twoFactorAuth

function fn_set_secret($user_id)
{
    $secret = fn_random_secret(5);

    return $secret;
}

function fn_random_secret($length)
{
    $arr = array(
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
    );

    $res = '';
    for ($i = 0; $i < $length; $i++) {
        $res .= $arr[rand(0, count($arr) - 1)];
    }
    return $res;
}
