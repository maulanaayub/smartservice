<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Smart_sispt extends CI_Controller
{
    var $theme = 'layouts/template_dashboard';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->model('Smart_model');
        $this->load->model('Users_model');
        check_sispt_user();
    }
    public function dashboard()
    {
        check_not_login();

        $tahunsmtsiakad = $this->Smart_model->cek_thsmt_siakad();
        $thsmt_berjalan = substr($tahunsmtsiakad['conf_keyval'], 0, -1); //menghilangkan string terakhir dan dapat tahunya
        $data['thsmt'] = $thsmt_berjalan;
        $data['sumber_data_siakad'] = 'SIAKAD IAIN Salatiga';
        $data['sumber_data_simpis'] = 'SIMPIS IAIN Salatiga';
   
        $data['judul_chart_mhs_per_smt_all_fak'] = 'Jumlah Mahasiswa Aktif';
        $data['judul_chart_mhs_per_fak'] = 'Jumlah Mahasiswa Aktif Per Fakultas';
        $data['judul_chart_mhs_per_prodi'] = 'Jumlah Mahasiswa Aktif Per Program Studi (Semester Berjalan)';
        $data['judul_chart_dosen_karyawan'] = 'Jumlah Dosen dan Karyawan';
    
        $data['page'] = 'smart_dashboard/dashboard_sispt';
        $this->load->view($this->theme, $data);
    }

    public function profil_old()
    {
        check_not_login();
        $src = base_url('media/images/foto_sispt_users_smart/'. $this->session->userdata('username') .'.png'); 
        if (@getimagesize($src)) {
            $data['foto_profil']= base_url('media/images/foto_sispt_users_smart/'. $this->session->userdata('username') .'.png'); 
        } else {
            $data['foto_profil']= base_url("assets/sb_admin_pro/dist/assets/img/illustrations/profiles/profile-1.png");
        }

        $data['page'] = 'smart_profile_akun/profil_sispt';
        $this->load->view($this->theme, $data);
    }

    public function profil(){
        check_not_login();
        $session_user_id = $this->session->userdata('username');
        $get_dosen = $this->Smart_model->get_data_pribadi_dosen($session_user_id);
        $get_karyawan = $this->Smart_model->get_data_pribadi_karyawan($session_user_id);

        $get_status_aktif = $this->Smart_model->gd_dosen($session_user_id, 15);
        $get_status_pend = $this->Smart_model->gd_dosen($session_user_id, 01);
        $get_status_akm = $this->Smart_model->gd_dosen($session_user_id, 02);
        $get_status_jk = $this->Smart_model->gd_dosen($session_user_id, 8);
        $get_status_ikk = $this->Smart_model->gd_dosen($session_user_id, 03);

        $src = base_url('media/images/foto_sispt_users_smart/' . $this->session->userdata('username') . '.png');
        if (@getimagesize($src)) {
            $data['foto_profil'] = base_url('media/images/foto_sispt_users_smart/' . $this->session->userdata('username') . '.png');
        } else {
            $data['foto_profil'] = base_url("assets/sb_admin_pro/dist/assets/img/illustrations/profiles/profile-1.png");
        }

        if ($get_dosen) {
            $data['get_dosen'] = $get_dosen;
            $data['status_aktif'] = $get_status_aktif['NMKODTBKOD'];
            $data['pendidikan_tertinggi'] = $get_status_pend['NMKODTBKOD'];
            $data['jabatan_akademik'] = $get_status_akm['NMKODTBKOD'];
            $data['jenis_kelamin'] = $get_status_jk['NMKODTBKOD'];
            $data['ikatan_kerja'] = $get_status_ikk['NMKODTBKOD'];

            $data['page'] = 'smart_profile_akun/profil_sispt';
        } else {
            $data['dp_karyawan'] = $get_karyawan;
            $data['page'] = 'smart_profile_akun/profil_sispt_karyawan';
        }


        $this->load->view($this->theme, $data);
    }

    public function ganti_password_sispt()
    {
        //google cpatcha
        $data['captcha'] = $this->recaptcha->getWidget();
        $data['script_captcha']   = $this->recaptcha->getScriptTag();

        if ($this->input->post() != null) {
            $this->form_validation->set_rules('password_lama_sispt', 'Password Lama', 'required|callback_password_check');
            $this->form_validation->set_rules('password_baru_sispt', 'Password Baru', 'required|min_length[8]');
            $this->form_validation->set_rules('konfirmasi_password_baru_sispt', 'Konfirmasi Password Baru', 'required|matches[password_baru_sispt]');
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required');

            $this->form_validation->set_message('required', '%s wajib diisi');
            $this->form_validation->set_message('matches', 'konfirmasi password tidak sama');
            $this->form_validation->set_message('min_length', '%s minimal 8 karakter');

            $this->form_validation->set_error_delimiters('<span class="badge badge-danger mt-1">', '</span>');

           

            $recaptcha = $this->input->post('g-recaptcha-response');
            $response = $this->recaptcha->verifyResponse($recaptcha);


            if ($this->form_validation->run() == true && $response['success'] == true) {
                $password =  $this->input->post('password_baru_sispt');

                $user = $this->session->userdata('username');
                $update = $this->Users_model->update_password_sispt($user, $password);
                if ($update == true) {
                    $this->session->set_flashdata('pesan', 'update_pass_sispt_success');
                } else {
                    $this->session->set_flashdata('pesan', 'update_pass_sispt_failed');
                }

                redirect(base_url('smart_sispt/ganti_password_sispt'));
            }
        }
        $data['page'] = 'smart_profile_akun/ganti_password_sispt';
        $this->load->view($this->theme, $data);
    }

    public function upload()
    {
        if (isset($_POST['image'])) {
            $data = $this->input->post('image');
            $namafile = $this->session->userdata('username');
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);

            $data = base64_decode($image_array_2[1]);

            $image_name = 'media/images/foto_sispt_users_smart/' . $namafile . '.png';

            file_put_contents($image_name, $data);

            echo base_url() . $image_name;
        }
    }

    function password_check()
    {
        $username = $this->session->userdata('username');
        $password = $this->input->post('password_lama_sispt');
        $user = $this->Users_model->check_user_sispt($username, $password);
        if ($user == null) {
            $this->form_validation->set_message('password_check', '%s tidak sesuai');
            return false;
        } else {
            return true;
        }
    }

}