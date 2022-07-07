<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Smart extends CI_Controller
{
    var $theme = 'layouts/template_dashboard';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->model('Smart_model');
    }

    public $tahunsmtsiakad;
    public $thsmt_berjalan;

    public function index()
    {
        check_login();
        $data['sumber_data_siakad'] = 'SIAKAD IAIN Salatiga';
        $data['judul_chart_mhs_per_smt_all_fak'] = 'Jumlah Mahasiswa Aktif';
    
        $data['page'] = 'smart_dashboard/dashboard_not_login';
        $this->load->view($this->theme, $data);
    }

    // public function refresh_mhs_aktif_all_fak()
    // {
    //     $continue = $this->input->get('continue');
    //     $array_items = array('mhs_aktif_all_fak');
    //     $this->session->unset_userdata($array_items);
    //     redirect($continue);
    // }
    // public function refresh_mhs_aktif_per_fak()
    // {
    //     $continue = $this->input->get('continue');
    //     $array_items = array('mhs_aktif_per_fak', 'rentang_semester');
    //     $this->session->unset_userdata($array_items);
    //     redirect($continue);
    // }
    // public function refresh_mhs_aktif_per_prodi()
    // {
    //     $continue = $this->input->get('continue');
    //     $array_items = array('mhs_aktif_per_prodi_smt_berjalan');
    //     $this->session->unset_userdata($array_items);
    //     redirect($continue);
    // }
    // public function refresh_dosen_karyawan()
    // {
    //     $continue = $this->input->get('continue');
    //     $array_items = array('jmlh_dosen_karyawan');
    //     $this->session->unset_userdata($array_items);
    //     redirect($continue);
    // }


}
