<?php

function activity_log($aksi, $username, $role_id)
{
    $CI = &get_instance();

    $username = $username;
    $role_id = $role_id;

    $param['log_user'] = $username;
    $param['log_role'] = $role_id;
    $param['log_aksi'] = $aksi; //target
    $param['log_ip'] = getUserIpAddr(); //target
    $param['log_namepc'] = gethostbyaddr($_SERVER['REMOTE_ADDR']); //target

    //load model log
    $CI->load->model('m_log');

    //save to database
    $CI->m_log->save_log($param);
}

function getUserIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function is_email_valid($email)
{
    if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", trim($email))) {
        return TRUE;
    }
    return FALSE;
}
