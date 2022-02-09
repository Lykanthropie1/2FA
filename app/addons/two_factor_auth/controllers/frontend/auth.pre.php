<?php

use Tygh\Tygh;
use Tygh\Registry;

defined('BOOTSTRAP') or die('Access denied');

$redirect_url = 'two_factor_auth.check';
$auth = & Tygh::$app['session']['auth'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mode === 'login') {

        list($status, $user_data, $user_login, $password, $salt) = fn_auth_routines($_REQUEST, $auth);
        $auth['user_id'] = $user_data['user_id'];

        if (
            !empty($user_data)
            && !empty($password)
            && fn_user_password_verify(
                (int)$user_data['user_id'],
                $password,
                (string)$user_data['password'],
                (string)$salt
            )
        ) {
            if (!empty($_REQUEST['return_url'])) {
                $_REQUEST['redirect_url'] = $redirect_url;

                if (!empty($_REQUEST['quick_login'])) {
                    Tygh::$app['ajax']->assign('force_redirection', fn_url($redirect_url));
                }
                return array(CONTROLLER_STATUS_REDIRECT, $redirect_url);
            }
        }
    }
    return [CONTROLLER_STATUS_OK];
}

