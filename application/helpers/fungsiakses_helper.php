<?php


function check_login()
{
    $ci = &get_instance();
    $ci->load->model('Users_model');
    $user_session = $ci->session->userdata('user_is_login');
    $user_tipe_akun = $ci->session->userdata('tipe_akun');

    $get_client_id = $ci->input->get('client_id');
    $get_client_secret =  $ci->input->get('client_secret');
    $get_continue = $ci->input->get('continue');

    $get_encrypt_client_id = rawurldecode($get_client_id);
    $get_encrypt_client_secret = rawurldecode($get_client_secret);

    $client_id = $ci->encryption->decrypt($get_encrypt_client_id);
    $client_secret = $ci->encryption->decrypt($get_encrypt_client_secret);


    //$username = $ci->session->userdata('username');


    if (($get_client_id == null && $get_client_secret == null)) {
        if ($user_session && $user_tipe_akun == 'mhs') {
            redirect('smart_mhs/dashboard');
        } else if ($user_session && $user_tipe_akun == 'sispt') {
            redirect('smart_sispt/dashboard');
        }
    } else {
        //jika hasil decode true
        if ($client_id && $client_secret) {
            $cek_client = $ci->db->get_where('oauth_clients', ['client_id' => $client_id, 'client_secret' => $client_secret])->row_array();
            //jika client app ada
            if ($cek_client != null) {
                //jika ada session
                if ($user_session) {
                    //6666untuk logout
                    $link_logout_tersimpan  = $ci->session->userdata('daftar_link_logout');
                    if ($link_logout_tersimpan != null) {
                        if (array_search($cek_client['logout_uri'], $link_logout_tersimpan) !== false) {
                            //jangan lakukan apapun
                        } else {
                            //jika belum ada tambahkan ke session
                            $link_logout_tersimpan[]  = $cek_client['logout_uri'];
                            $ci->session->set_userdata('daftar_link_logout', $link_logout_tersimpan);
                        }
                    } else {
                        $link_logout_tersimpan[]  = $cek_client['logout_uri'];
                        $ci->session->set_userdata('daftar_link_logout', $link_logout_tersimpan);
                    }

                    redirect('smart_auth/login_to_client?client_id=' . rawurlencode($get_encrypt_client_id) . '&client_secret=' . rawurlencode($get_encrypt_client_secret) . '&continue=' . rawurlencode($get_continue));
                }
                //jika client app tidak ada
            } else {
                if ($user_session && $user_tipe_akun == 'mhs') {
                    redirect('smart_mhs/dashboard');
                } else if ($user_session && $user_tipe_akun == 'sispt') {
                    redirect('smart_sispt/dashboard');
                }
            }
            //jika hasil decode false
        } else {
            if ($user_session && $user_tipe_akun == 'mhs') {
                redirect('smart_mhs/dashboard');
            } else if ($user_session && $user_tipe_akun == 'sispt') {
                redirect('smart_sispt/dashboard');
            }
        }
    }
}

function check_not_login($require_continue = null)
{
    $ci = &get_instance();
    $user_session = $ci->session->userdata('user_is_login');


    if (!$user_session) {
        $ci->session->set_flashdata('message', ' <div class="alert alert-danger" role="alert">silahkan login terlebih dahulu</div>');
        if ($require_continue == 1) {
            $continue_link = '';
            redirect('smart_auth');
        } else {
            $continue_link = current_url();
            redirect('smart_auth?continue=' . rawurlencode($continue_link));
        }
    }
}

function check_message_from_client()
{
    $ci = &get_instance();
    $message = $ci->input->get('message');

    if ($message == 'sess_false') {
        $ci->session->set_flashdata('message', ' <div class="alert alert-danger" role="alert">silahkan login terlebih dahulu</div>');
    }
}

function check_sispt_user()
{
    $ci = &get_instance();


    $tipe_akun = $ci->session->userdata('tipe_akun');
    $session_status = $ci->session->userdata('user_is_login');
    if ($session_status) {
        if ($tipe_akun != 'sispt') {
            redirect('smart_auth/forbidden');
        }
    }
}

function check_mhs_user()
{
    $ci = &get_instance();


    $tipe_akun = $ci->session->userdata('tipe_akun');
    $session_status = $ci->session->userdata('user_is_login');
    if ($session_status) {
        if ($tipe_akun != 'mhs') {
            redirect('smart_auth/forbidden');
        }
    }
}
