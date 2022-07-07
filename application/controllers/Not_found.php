<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Not_found extends CI_Controller
{
  

    public function index()
    {
        $this->load->view('layouts/not_found');
    }

}