<?php

use Tygh\Tygh;
use Tygh\Registry;

defined('BOOTSTRAP') or die('Access denied');

$redirect_url = 'auth.verification_form';
$auth = Tygh::$app['session']['auth'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($mode === 'login') {
        list($status, $user_data, $user_login, $password, $salt) = fn_auth_routines($_REQUEST, $auth);

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
            $auth['user_data'] = $user_data;
            $email = $user_data['email'];
            $secret = fn_set_secret($user_data['user_id']);
            if (!empty($secret)) {
                fn_send_secret($email, $secret);
            }
            if (!empty($_REQUEST['return_url'])) {
                $_REQUEST['redirect_url'] = $redirect_url;

                if (!empty($_REQUEST['quick_login'])) {
                    Tygh::$app['ajax']->assign('force_redirection', fn_url($redirect_url));
                    exit;
                }

                return array(CONTROLLER_STATUS_REDIRECT, $redirect_url);
            }
        }
    }

    if ($mode === 'verify') {
        if (fn_verify_timestamp($auth['user_data']['user_id'])) {
            if (fn_verify_secret($_REQUEST['user_secret'], $auth['user_data']['user_id'])) {
                Tygh::$app['session']->regenerateID();
                fn_login_user($auth['user_data']['user_id'], true);
                unset($auth['user_data']);
                fn_set_notification('N', __('notice'), __('successful_login'));
                return array(CONTROLLER_STATUS_OK);
            } else {
                fn_set_notification('E', __('error'), __('error_incorrect_secret'));
                return array(CONTROLLER_STATUS_REDIRECT, $redirect_url);
            }
        } else {
            fn_set_notification('E', __('error'), __('error_time_is_up'));
            return array(CONTROLLER_STATUS_REDIRECT, $redirect_url);
        }
    }

    if (!isset($auth['user_data']['count'])) {
        $auth['user_data']['count'] = 0;
    }

    if ($mode === 'change_secret') {
        $auth['user_data']['count']++;
        if ($auth['user_data']['count'] < 4) {
            $email = $auth['user_data']['email'];
            $secret = fn_set_secret($auth['user_data']['user_id']);
            if (!empty($secret)) {
                fn_send_secret($email, $secret);
            }
            fn_set_notification('N', __('notice'), __('code_refreshed'));
            return array(CONTROLLER_STATUS_REDIRECT, $redirect_url);
        } else {
            unset($auth['user_data']['count']);
            fn_set_notification('N', __('notice'), __('re_login'));
            return array(CONTROLLER_STATUS_REDIRECT, 'auth.login_form');
        }
    }
}