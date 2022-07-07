<?php

/**
 * @package     Api.php
 * @author      Aditya Nursyahbani
 * @link        http://www.aditya-nursyahbani.net/2016/10/tutorial-oauth2-dengan-codeigniter.html
 * @copyright   Copyright(c) 2016
 * @version     1.0.0
 **/

defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class Api2 extends REST_Controller
{

    function __construct()
    {
        @session_start();
        parent::__construct();
        $this->load->library("Server", "server");
        $this->server->require_scope("user");

        $this->load->database('oauth');
        $this->load->model('Users_model');
    }

    function User_get()
    {
       
        $username = $this->input->get('id');
        //$pass_encrypt = rawurldecode($this->input->get('password'));
       // $password =  $this->encryption->decrypt($pass_encrypt);

      
       

        if ($username==null) {
            $this->response(["message" => 'forbidden'], 403);
        }else{
            $userdata = $this->Users_model->get_user_data_mhs($username);
            if ($userdata) {
                $roledata = $this->Users_model->get_role_data_mhs($this->get('id'));
                $this->response([
                    "message" => "Ok",
                    "tipe_akun" =>"mhs",
                    "data_user" => $userdata,
                    "role_user" => $roledata
                ], 200); // 200 being the HTTP response code
            } else {
                $userdata = $this->Users_model->get_user_data_sispt($username);
                if ($userdata) {
                    $roledata = $this->Users_model->get_role_data_sispt($this->get('id'));
                    $this->response([
                        "message" => "Ok",
                        "tipe_akun" =>"sispt",
                        "data_user" => $userdata,
                        "role_user" => $roledata
                    ], 200); // 200 being the HTTP response code
                }else{
                    $this->response(["message" => "Not Found"], 404);
                }
            }
        }
        
    }

    function Users_post()
    {
        $userdata = $this->Users_model->get_all();

        if ($userdata) {
            $this->response($userdata, 200); // 200 being the HTTP response code
        } else {
            $this->response(NULL, 404);
        }
    }
}
