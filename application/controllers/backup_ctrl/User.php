<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        // ambil sesi untuk cetak email
        $data['title'] = 'Manajement User';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $this->load->model('User_model', 'user');
        $data['all_users'] = $this->user->get_users();
        $data['role'] = $this->user->get_role();

        $this->load->view('layouts/app', $data);
        $this->load->view('user/index');
        $this->load->view('layouts/dash_footer');
    }

    public function validation_add_users()
    {

        $this->_validate2();
        $data = array(
            'name' => $this->input->post('nama_lengkap'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'image' => $this->input->post('filefoto'),
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'role_id' => $this->input->post('role'),
            'is_active' => $this->input->post('is_active'),
            'date_created'  => time()
        );
        $this->db->insert('user', [
            'name' => $this->input->post('nama_lengkap'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'image' => $this->input->post('filefoto'),
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'role_id' => $this->input->post('role'),
            'is_active' => $this->input->post('is_active'),
            'date_created'  => time()
        ]);
        echo $this->session->set_flashdata('msg', 'success');
        echo json_encode(array("status" => TRUE));
    }

    private function _validate2()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama_lengkap') == '') {
            $data['inputerror'][] = 'nama_lengkap';
            $data['error_string'][] = 'nama_lengkap input masih kosong!';
            $data['status'] = FALSE;
        }

        if ($this->input->post('username') == '') {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'kolom username masih kosong!';
            $data['status'] = FALSE;
        }
        if ($this->input->post('email') == '') {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'kolom email masih kosong!';
            $data['status'] = FALSE;
        }
        if ($this->input->post('password') == '') {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'kolom password masih kosong!';
            $data['status'] = FALSE;
        }
        if ($this->input->post('role') == '') {
            $data['inputerror'][] = 'role';
            $data['error_string'][] = 'kolom role masih kosong!';
            $data['status'] = FALSE;
        }
        if ($this->input->post('image') == '') {
            $data['inputerror'][] = 'image';
            $data['error_string'][] = 'kolom image masih kosong!';
            $data['status'] = FALSE;
        }
        if ($this->input->post('is_active') == '') {
            $data['inputerror'][] = 'is_active';
            $data['error_string'][] = 'kolom status masih kosong!';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
