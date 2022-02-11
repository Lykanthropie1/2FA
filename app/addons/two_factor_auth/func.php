<?php

/**
 * @param $user_id
 * @return string
 */
function fn_set_secret($user_id)
{
    $secret = fn_random_secret(5);
    $timestamp = fn_parse_date(TIME);
    $data = array(
        'two_factor_code' => $secret,
        'two_factor_expires_at' => $timestamp
    );
    db_query("UPDATE ?:users SET ?u WHERE user_id = ?i", $data, $user_id);

    return $secret;
}

/**
 * @param $length
 * @return string
 */
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

/**
 * @param $to
 * @param $secret
 * @param $lang_code
 * @return mixed
 */
function fn_send_secret($to, $secret, $lang_code = CART_LANGUAGE)
{
    $body = 'Your verification code: ' . $secret;
    $subj = 'Your verification code';
    $_from = array(
        'email' => !empty($from['from_email']) ? $from['from_email'] : 'default_company_newsletter_email',
        'name' => !empty($from['from_name']) ? $from['from_name'] : (empty($from['from_email']) ? 'default_company_name' : '')
    );

    /** @var \Tygh\Mailer\Mailer $mailer */
    $mailer = Tygh::$app['mailer'];

    return $mailer->send(array(
        'to' => $to,
        'from' => $_from,
        'data' => array(
            'body' => $body,
            'subject' => $subj
        ),
        'template_code' => 'newsletters_newsletter',
        'tpl' => 'addons/newsletters/newsletter.tpl', // this parameter is obsolete and is used for back compatibility
    ), 'C', $lang_code, fn_get_newsletters_mailer_settings());
}

/**
 * @param $secret
 * @param $user_id
 * @return bool
 */
function fn_verify_secret($secret, $user_id)
{
    if (!empty($secret)) {
        $db_secret = db_get_field('SELECT two_factor_code FROM ?:users WHERE user_id = ?i', $user_id);
        if ($secret === $db_secret) {
            return true;
        }
    }
    return false;
}
