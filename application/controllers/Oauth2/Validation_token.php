<?php

/**
 * @package     Authorize.php
 * @author      Aditya Nursyahbani
 * @link        http://www.aditya-nursyahbani.net/2016/10/tutorial-oauth2-dengan-codeigniter.html
 * @copyright   Copyright(c) 2016
 * @version     1.0.0
 **/


defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . 'libraries/REST_Controller.php');

class Validation_token extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database('oauth');
        $this->load->model('Server_model');
    }

    function index_get()
    {
        if (!$this->get('access_token')) {
            $this->response(NULL, 400);
        }

        date_default_timezone_set('Asia/Jakarta');
        $get_time_expired = $this->Server_model->check_token_time($this->get('access_token'));
        $get_time_now = date('Y-m-d H:i:s');

        $d1 = new DateTime('2008-08-03 14:52:10');
        var_dump($get_time_expired['expires']);
        var_dump($get_time_now);

        if ($get_time_expired < $get_time_now) {
            echo 'Token Sudah Habis';
        } else {
            echo 'Token Ada';
        }
    }
}
