<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Smart_auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->model('Smart_model');
        $this->load->model('Users_model');
    }

    public function index()
    {

        //phpinfo();
        $get_client_id = $this->input->get('client_id');
        $get_client_secret =  $this->input->get('client_secret');

        $get_encrypt_client_id = rawurldecode($get_client_id);
        $get_encrypt_client_secret = rawurldecode($get_client_secret);
        $client_id = $this->encryption->decrypt($get_encrypt_client_id);
        $client_secret = $this->encryption->decrypt($get_encrypt_client_secret);

        $get_continue = rawurldecode($this->input->get('continue'));

        //google cpatcha
        $data['captcha'] = $this->recaptcha->getWidget();
        $data['script_captcha']   = $this->recaptcha->getScriptTag();


        if (($get_client_id == null && $get_client_secret == null)) {
            if ($this->input->post() == null) {
                check_login();
                check_message_from_client();

                $data['title'] = 'SMART CAMPUS';
                $this->load->view('smart_login/portal_login', $data);
            } else {
                $this->form_validation->set_rules('username', 'Username', 'required|trim');
                $this->form_validation->set_rules('password', 'Password', 'required');
                $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required');

                $this->form_validation->set_message('required', '%s wajib diisi');
                $this->form_validation->set_error_delimiters('<span class="badge badge-danger">', '</span>');

                $recaptcha = $this->input->post('g-recaptcha-response');
                $response = $this->recaptcha->verifyResponse($recaptcha);

                if ($this->form_validation->run() == false || !isset($response['success']) || $response['success'] <> true) {
                    $data['title'] = 'SMART CAMPUS';
                    $this->load->view('smart_login/portal_login', $data);
                } else {
                    $this->_login($get_encrypt_client_id, $get_encrypt_client_secret, $get_continue);
                }
            }
        } else {
            if ($client_secret && $client_id) {
                $cek_client = $this->db->get_where('oauth_clients', ['client_id' => $client_id, 'client_secret' => $client_secret])->row_array();
                if ($cek_client != null) {
                    if ($this->input->post() == null) {
                        check_login();
                        check_message_from_client();

                        $data['title'] = 'SMART CAMPUS';
                        $this->load->view('smart_login/portal_login', $data);
                    } else {
                        $this->form_validation->set_rules('username', 'Username', 'required|trim');
                        $this->form_validation->set_rules('password', 'Password', 'required');
                        $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required');

                        $this->form_validation->set_message('required', '%s wajib diisi');
                        $this->form_validation->set_error_delimiters('<span class="badge badge-danger">', '</span>');

                        $recaptcha = $this->input->post('g-recaptcha-response');
                        $response = $this->recaptcha->verifyResponse($recaptcha);

                        if ($this->form_validation->run() == false || !isset($response['success']) || $response['success'] <> true) {
                            $data['title'] = 'SMART CAMPUS';
                            $this->load->view('smart_login/portal_login', $data);
                        } else {
                            $this->_login($get_encrypt_client_id, $get_encrypt_client_secret, $get_continue);
                        }
                    }
                } else {

                    $this->session->set_flashdata('message', '
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            Aplikasi tidak terdaftar!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>');
                    redirect('smart_auth');
                }
            } else {
                $this->session->set_flashdata('message', '
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            Aplikasi tidak terdaftar!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>');
                redirect('smart_auth');
            }
        }
    }

    private function _login($get_encrypt_client_id, $get_encrypt_client_secret, $get_continue)
    {
        $client_id =  $this->encryption->decrypt($get_encrypt_client_id);
        $client_secret =  $this->encryption->decrypt($get_encrypt_client_secret);
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($client_id == null && $client_secret == null) {
            $user = $this->Users_model->check_user_mhs($username, $password);
            if ($user != null) {
                $session_data['user_is_login'] = TRUE;
                $session_data['username'] = $user->NIMHSMSMHS;
                $session_data['nama_lengkap'] = $user->NMMHSMSMHS;
                $session_data['tipe_akun'] = 'mhs';
                $this->session->set_userdata($session_data);
                //var_dump($session_data,$user);

                if ($get_continue != null) {
                    redirect($get_continue);
                } else {
                    redirect('smart_mhs/dashboard');
                }
            } else {
                $user = $this->Users_model->check_user_sispt($username, $password);
                if ($user != null) {
                    $session_data['user_is_login'] = TRUE;
                    $session_data['username'] = $user->user_id;
                    $session_data['nama_lengkap'] = $user->user_name;
                    $session_data['tipe_akun'] = 'sispt';
                    $this->session->set_userdata($session_data);

                    if ($get_continue != null) {
                        redirect($get_continue);
                    } else {
                        redirect('smart_sispt/dashboard');
                    }
                } else {
                    $this->session->set_flashdata('message', '
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        Username atau password salah
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');

                    if ($get_continue == null) {
                        redirect('smart_auth');
                    } else {
                        redirect('smart_auth?continue=' . rawurlencode($get_continue));
                    }
                }
            }
        } else {
            $cek_client = $this->db->get_where('oauth_clients', ['client_id' => $client_id, 'client_secret' => $client_secret])->row_array();
            $user = $this->Users_model->check_user_mhs($username, $password);
            if ($user != null) {

                $session_data['user_is_login'] = TRUE;
                $session_data['username'] = $user->NIMHSMSMHS;
                $session_data['nama_lengkap'] = $user->NMMHSMSMHS;
                $session_data['tipe_akun'] = 'mhs';
                $this->session->set_userdata($session_data);

                //untuk logout
                $link_logout_tersimpan = $this->session->userdata('daftar_link_logout');
                if ($link_logout_tersimpan != null) {
                    if (array_search($cek_client['logout_uri'], $link_logout_tersimpan) !== false) {
                        //jangan lakukan apapun
                    } else {
                        //jika belum ada tambahkan ke session
                        $link_logout_tersimpan[]  = $cek_client['logout_uri'];
                        $this->session->set_userdata('daftar_link_logout', $link_logout_tersimpan);
                    }
                } else {
                    $link_logout_tersimpan[]  = $cek_client['logout_uri'];
                    $this->session->set_userdata('daftar_link_logout', $link_logout_tersimpan);
                }

                redirect('smart_auth/login_to_client?client_id=' . rawurlencode($get_encrypt_client_id) . '&client_secret=' . rawurlencode($get_encrypt_client_secret) . '&continue=' . rawurlencode($get_continue));
            } else {
                $user = $this->Users_model->check_user_sispt($username, $password);
                if ($user != null) {

                    $session_data['user_is_login'] = TRUE;
                    $session_data['username'] = $user->user_id;
                    $session_data['nama_lengkap'] = $user->user_name;
                    $session_data['tipe_akun'] = 'sispt';
                    $this->session->set_userdata($session_data);

                    //untuk logout
                    $link_logout_tersimpan = $this->session->userdata('daftar_link_logout');
                    if ($link_logout_tersimpan != null) {
                        if (array_search($cek_client['logout_uri'], $link_logout_tersimpan) !== false) {
                        } else {

                            $link_logout_tersimpan[]  = $cek_client['logout_uri'];
                            $this->session->set_userdata('daftar_link_logout', $link_logout_tersimpan);
                        }
                    } else {
                        $link_logout_tersimpan[]  = $cek_client['logout_uri'];
                        $this->session->set_userdata('daftar_link_logout', $link_logout_tersimpan);
                    }

                    redirect('smart_auth/login_to_client?client_id=' . rawurlencode($get_encrypt_client_id) . '&client_secret=' . rawurlencode($get_encrypt_client_secret) . '&continue=' . rawurlencode($get_continue));
                } else {
                    $this->session->set_flashdata('message', '
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            Username atau password salah
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>');
                    if ($get_continue == null) {
                        redirect('smart_auth?client_id=' . rawurlencode($get_encrypt_client_id) . '&client_secret=' . rawurlencode($get_encrypt_client_secret));
                    } else {
                        redirect('smart_auth?client_id=' . rawurlencode($get_encrypt_client_id) . '&client_secret=' . rawurlencode($get_encrypt_client_secret) . '&continue=' . rawurlencode($get_continue));
                    }
                }
            }
        }
    }

    public function login_to_client()
    {

        check_not_login(1);

        $get_client_id = $this->input->get('client_id');
        $get_client_secret =  $this->input->get('client_secret');

        $get_encrypt_client_id = rawurldecode($get_client_id);
        $get_encrypt_client_secret = rawurldecode($get_client_secret);
        $client_id = $this->encryption->decrypt($get_encrypt_client_id);
        $client_secret = $this->encryption->decrypt($get_encrypt_client_secret);
        $get_continue = rawurldecode($this->input->get('continue'));



        if ($client_id && $client_secret) {
            $cek_client = $this->db->get_where('oauth_clients', ['client_id' => $client_id, 'client_secret' => $client_secret])->row_array();
            // var_dump($cek_client);
            if ($cek_client != null) {
                //redirect($login_uri . '?username=' . rawurlencode($username) . '&pass=' . rawurlencode($encrypt_password) . '&code=' . rawurlencode($encrypt_username) . '&continue=' . rawurlencode($get_continue));
                $user = $this->session->userdata('username');
                date_default_timezone_set('Asia/Jakarta');
                $time =  date('Y-m-d h:i:s', time());
                //$time = "2021-08-10 12:00:00";
                $user_and_time = $this->encryption->encrypt($user . '@@@' . $time);

                $data['user_and_time'] = $user_and_time;
                $data['form_action_url'] =  $cek_client['login_uri'];
                $data['continue'] = $get_continue;
                $data['AppName'] = $cek_client['AppName'];

                $this->load->view('smart_login/login_to_client', $data);
            } else {
                redirect('smart_auth/error_login?msg=error_client_id_false');
            }
        } else {
            redirect('smart_auth/error_login?msg=error_client_id_wrong');
        }



        //var_dump($client_id, $client_secret);
        //$this->load->view('smart_forgot/portal_forgot_pass');
    }





    // public function service()
    // {
    //     check_not_login();
    //     $message_not_granted = $this->input->get('not_granted');
    //     $data['list_kateg'] = $this->Smart_model->get_kateg($this->session->userdata('username'));
    //     $data['list_app'] = $this->Smart_model->get_list_app($this->session->userdata('username'));

    //     if ($message_not_granted != null) {
    //         $data['forbidden_message'] = 'Anda tidak mempunyai akses ke aplikasi ' . $message_not_granted;
    //     } else {
    //         $data['forbidden_message'] = null;
    //     }

    //     $this->load->view('layouts/app2', $data);
    //     $this->load->view('smart_dashboard/smart_service', $data);
    //     $this->load->view('layouts/dash_footer', $data);
    // }

    // public function info()
    // {
    //     check_not_login();
    //     $message_not_granted = $this->input->get('not_granted');
    //     $data['list_kateg'] = $this->Smart_model->get_kateg($this->session->userdata('username'));
    //     $data['list_app'] = $this->Smart_model->list2($this->session->userdata('username'));

    //     $data['data'] = $this->Smart_model->get_data_stok();

    //     if ($message_not_granted != null) {
    //         $data['forbidden_message'] = 'Anda tidak mempunyai akses ke aplikasi ' . $message_not_granted;
    //     } else {
    //         $data['forbidden_message'] = null;
    //     }

    //     $this->load->view('layouts/app2', $data);
    //     $this->load->view('smart_dashboard/info_service', $data);
    //     $this->load->view('layouts/dash_footer', $data);
    // }


    public function logout()
    {
        //var_dump($this->session->userdata('daftar_link_logout'));

        if ($this->session->userdata('daftar_link_logout') != null) {
            $all_link_logout = $this->session->userdata('daftar_link_logout');
            //var_dump($all_link_logout);
            // $all_link_logout = array(
            //     "http://localhost/edom/Auth/logout",
            //     "http://localhost/siska/Auth/logout",
            //      "http://localhost/ots/Auth/logout",
            //      "http://localhost/si-mona/Auth/logout",
            //      "http://localhost/edom/Auth/logout",
            //     "http://localhost/siska/Auth/logout",
            //      "http://localhost/ots/Auth/logout",
            //      "http://localhost/si-mona/Auth/logout",
            //      "http://localhost/edom/Auth/logout",
            //     "http://localhost/siska/Auth/logout",
            //      "http://localhost/ots/Auth/logout",
            //      "http://localhost/si-mona/Auth/logout",
            //      "http://localhost/edom/Auth/logout",
            //     "http://localhost/siska/Auth/logout",
            //      "http://localhost/ots/Auth/logout",
            //      "http://localhost/si-mona/Auth/logout",
            //      "http://localhost/edom/Auth/logout",
            //     "http://localhost/siska/Auth/logout",



            //);

            $i = 0; //untuk check array ke 0
            $j = 0; //untuk mendefinisikan $str
            foreach ($all_link_logout as $link) {

                if ($i != 0) { //array ke 0 tidak dimasukan karena langsung akan dipanggil oleh redirect pada method ini
                    $new_arr[] = rawurlencode($link);
                    $j++;
                }
                $i++;
            }

            if ($j > 0) {
                $str = implode('88', $new_arr);
            } else {
                $str = null;
            }


            //var_dump($all_link_logout, $str);

            if (count($all_link_logout) >= 1) {
                $this->session->sess_destroy();
                if ($str != null) {
                    // echo'a';
                    redirect($all_link_logout[0] . '?daftar_link_logout=' . $str); //redirect pertama adalah ke situs pada array 0 , redirect selanjutnya akan dieksekusi app client
                } else {
                    // echo'b';
                    redirect($all_link_logout[0]);
                }
            } else {
                //echo 'c';
                $this->session->sess_destroy();
                redirect(base_url());
            }
        } else {
            // echo'd';
            $this->session->sess_destroy();
            redirect(base_url() . '?portal=success');
        }





        // $this->session->sess_destroy();

        // $get_client_id = $this->input->get('client_id');
        // $get_client_secret =  $this->input->get('client_secret');

        // $cid = str_replace(' ', '+', $get_client_id);
        // $cis = str_replace(' ', '+', $get_client_secret);

        // $data['get_link_logout_client'] = $this->Smart_model->getlinklogout();

        // if ($cid != null && $cis != null) {
        //     $data['set_redirect'] = base_url('smart_auth?client_id=' . $cid . '&client_secret=' . $cis);
        // } else {
        //     $data['set_redirect'] = base_url('smart');
        // }

        // $this->load->view('smart_logout/all_logout', $data);
    }
    public function forbidden()
    {
        $cid = $this->input->get('not_granted');
        $appname = $this->Smart_model->get_forbidden_name($cid);

        if ($appname != null) {
            $data['message'] = 'Anda tidak mempunyai akses ke aplikasi <b>' . $appname->AppName . '</b>';
        } else {
            $data['message'] = 'Anda tidak mempunyai akses ke halaman ini';
        }

        $this->load->view('layouts/forbidden', $data);
    }

    public function error_login()
    {
        $cid = $this->input->get('client_id');
        $appname = $this->Smart_model->get_forbidden_name($cid);
        // var_dump($appname);
        if ($appname != null) {
            $data['message'] = 'Error Tidak dapat masuk ke aplikasi <b>' . $appname->AppName . '</b>';
        } else {
            $data['message'] = 'Error Tidak dapat masuk';
        }

        $this->load->view('layouts/error_login', $data);
    }

    public function forgot_password()
    {
        //google cpatcha
        $data['captcha'] = $this->recaptcha->getWidget();
        $data['script_captcha']   = $this->recaptcha->getScriptTag();
        if ($this->input->post() == null) {
            $data['title'] = 'Forgot Password';
            $this->load->view('smart_forgot/portal_forgot_pass', $data);
        } else {
            $data['title'] = 'Forgot Password';
            $this->load->view('smart_forgot/portal_forgot_pass', $data);
        }
    }
}
