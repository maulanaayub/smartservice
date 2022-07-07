<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Smart_mhs extends CI_Controller
{
    var $theme = 'layouts/template_dashboard';
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->model('Smart_model');
        $this->load->model('Users_model');
        check_mhs_user();
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
    
        $data['page'] = 'smart_dashboard/dashboard_mhs';
        $this->load->view($this->theme, $data);
    }

    public function profil()
    {
        check_not_login();
        if ($this->input->post() == null) {
            $this->view_profil_mhs();
        } else {
            $this->form_validation->set_rules('alamat_negara_mhs', 'Negara', 'required');
            $this->form_validation->set_rules('propinsi_cbo', 'Propinsi', 'required');
            $this->form_validation->set_rules('kabupaten_cbo', 'Kabupaten / Kota', 'required');
            $this->form_validation->set_rules('kecamatan_cbo', 'Kecamatan', 'required');
            $this->form_validation->set_rules('desa_mhs', 'Desa / Kelurahan', 'required');
            $this->form_validation->set_rules('alamat_ortu_negara', 'Negara Orang Tua / Wali', 'required');
            $this->form_validation->set_rules('propinsi_ortu_cbo', 'Propinsi Orang Tua / Wali', 'required');
            $this->form_validation->set_rules('kabupaten_ortu_cbo', 'Kabupaten Kota Orang Tua / Wali', 'required');
            $this->form_validation->set_rules('desa_kec_ortu', 'Desa dan Kecamatan Orang Tua / Wali', 'required');

            $this->form_validation->set_rules('kewarganegaraan', 'Kewarganegaraan', 'required');
            $this->form_validation->set_rules('nik_mhs', 'NIK', 'required');
            $this->form_validation->set_rules('tempat_lahir_mhs', 'Tempat Lahir', 'required');
            $this->form_validation->set_rules('tgl_lahir_mhs', 'Tanggal Lahir', 'required');
            $this->form_validation->set_rules('hp_mhs', 'No HP', 'required|numeric');
            $this->form_validation->set_rules('email_mhs', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('tinggi_mhs', 'Tinggi', 'numeric');
            $this->form_validation->set_rules('berat_mhs', 'Berat', 'numeric');

            $this->form_validation->set_rules('nama_ayah_mhs', 'Nama Ayah', 'required');
            $this->form_validation->set_rules('nama_ibu_mhs', 'Nama Ibu', 'required');
            $this->form_validation->set_rules('pekerjaan_ayah_cbo', 'Pekerjaan Ayah', 'required');
            $this->form_validation->set_rules('pekerjaan_ibu_cbo', 'Pekerjaan Ibu', 'required');
            $this->form_validation->set_rules('telp_ortu_mhs', 'Nomor Telp / HP', 'numeric');


            $this->form_validation->set_message('required', '%s wajib diisi');
            $this->form_validation->set_message('numeric', '%s harus angka');
            $this->form_validation->set_message('valid_email', '%s salah');



            $this->form_validation->set_error_delimiters('<span class="badge badge-danger mt-1">', '</span>');

            if ($this->form_validation->run() == false) {
                //var_dump($this->input->post());
                $this->view_profil_mhs();
            } else {
                //set alamat mhs
                if ($this->input->post('jalan_mhs') != '') {
                    $alamat_mhs_jl = $this->input->post('jalan_mhs') . ' ';
                } else {
                    $alamat_mhs_jl = $this->input->post('jalan_mhs');
                }
                if ($this->input->post('rt_mhs') != '') {
                    $alamat_mhs_rt = 'Rt.' . $this->input->post('rt_mhs') . ' ';
                } else {
                    $alamat_mhs_rt = $this->input->post('rt_mhs');
                }
                if ($this->input->post('rw_mhs') != '') {
                    $alamat_mhs_rw = 'Rw.' . $this->input->post('rw_mhs') . ' ';
                } else {
                    $alamat_mhs_rw = $this->input->post('rw_mhs');
                }
                if ($this->input->post('dusun_mhs') != '') {
                    $alamat_mhs_dsn = 'Dsn.' . $this->input->post('dusun_mhs') . "\r\n";
                } else {
                    $alamat_mhs_dsn = $this->input->post('dusun_mhs');
                }
                //if ($this->input->post('desa_mhs') != '') {
                $alamat_mhs_ds = $this->input->post('desa_mhs') . ' ';
                //} else {
                //    $alamat_mhs_ds = $this->input->post('desa_mhs');
                //}
                //if ($this->input->post('kecamatan_cbo') != '') {
                $alamat_mhs_kec = 'Kec.' . $this->input->post('kecamatan_cbo') . "\r\n";
                // } else {
                //     $alamat_mhs_kec = $this->input->post('kecamatan_cbo');
                // }
                //if ($this->input->post('kabupaten_cbo') != '') {
                $alamat_mhs_kab = $this->input->post('kabupaten_cbo') . "\r\n";
                // } else {
                //     $alamat_mhs_kab = $this->input->post('kabupaten_cbo');
                // }
                //if ($this->input->post('propinsi_cbo') != '') {
                $alamat_mhs_prop = $this->input->post('propinsi_cbo') . "\r\n";
                // } else {
                //     $alamat_mhs_prop = $this->input->post('propinsi_cbo');
                // }
                //if ($this->input->post('kode_pos_mhs') != '') {
                $alamat_mhs_kdpos = $this->input->post('kode_pos_mhs') . "\r\n";
                // } else {
                //     $alamat_mhs_kdpos = $this->input->post('kode_pos_mhs');
                // }
                $alamat_mhs_negara = $this->input->post('alamat_negara_mhs');


                //set alamat ortu
                //if ($this->input->post('dusun_jl_rt_rw_ortu') != '') {
                $alamat_ortu_jl = $this->input->post('dusun_jl_rt_rw_ortu') . "\r\n";
                // } else {
                //     $alamat_ortu_jl = $this->input->post('dusun_jl_rt_rw_ortu');
                // }
                //if ($this->input->post('desa_kec_ortu') != '') {
                $alamat_ortu_desa_kec = $this->input->post('desa_kec_ortu') . "\r\n";
                // } else {
                //     $alamat_ortu_desa_kec = $this->input->post('desa_kec_ortu');
                // }
                //if ($this->input->post('kabupaten_ortu_cbo') != '') {
                $alamat_ortu_kab = $this->input->post('kabupaten_ortu_cbo') . "\r\n";
                // } else {
                //     $alamat_ortu_kab = $this->input->post('kabupaten_ortu_cbo');
                // }

                //if ($this->input->post('propinsi_ortu_cbo') != '') {
                $alamat_ortu_prop = $this->input->post('propinsi_ortu_cbo') . "\r\n";
                // } else {
                //     $alamat_ortu_prop = $this->input->post('propinsi_ortu_cbo');
                // }
                $alamat_ortu_kdpos = $this->input->post('kode_pos_ortu') . "\r\n";

                $alamat_ortu_negara = $this->input->post('alamat_ortu_negara');









                $alamat_mhs_lengkap = $alamat_mhs_jl . $alamat_mhs_rt . $alamat_mhs_rw . $alamat_mhs_dsn . $alamat_mhs_ds . $alamat_mhs_kec . $alamat_mhs_kab . $alamat_mhs_prop . $alamat_mhs_kdpos . $alamat_mhs_negara;
                $alamat_ortu_lengkap = $alamat_ortu_jl . $alamat_ortu_desa_kec . $alamat_ortu_kab . $alamat_ortu_prop . $alamat_ortu_kdpos . $alamat_ortu_negara;
                $param = [
                    'ALAMATLENGKAP' => $alamat_mhs_lengkap,
                    'ALAMATORTUWALI' => $alamat_ortu_lengkap,
                    'ISWNI' => $this->input->post('kewarganegaraan'),
                    'NOKTP' => $this->input->post('nik_mhs'),
                    'TPLHRMSMHS' => $this->input->post('tempat_lahir_mhs'),
                    'TGLHRMSMHS' => $this->input->post('tgl_lahir_mhs'),
                    'TELP' => $this->input->post('hp_mhs'),
                    'TINGGIBADAN' => $this->input->post('tinggi_mhs'),
                    'BERATBADAN' => $this->input->post('berat_mhs'),
                    'GOLDARAH' => $this->input->post('golongan_darah_cbo'),
                    'EMAIL' => $this->input->post('email_mhs'),
                    'NAMAORTUWALI' => $this->input->post('nama_ayah_mhs') . '|' . $this->input->post('nama_ibu_mhs'),
                    'PEKERJAANORTUWALI' => $this->input->post('pekerjaan_ayah_cbo') . '|' . $this->input->post('pekerjaan_ibu_cbo'),
                    'PENDIDIKANORTUWALI' => $this->input->post('pendidikan_ayah_cbo') . '|' . $this->input->post('pendidikan_ibu_cbo'),
                    'PENGHASILANORTUWALI' => $this->input->post('penghasilan_ayah_cbo') . '|' . $this->input->post('penghasilan_ibu_cbo'),
                    'TELPORTUWALI' => $this->input->post('telp_ortu_mhs')

                ];

                $nim = $this->session->userdata('username');
                //$update = $this->Users_model->update_data_mahasiswa($nim, $param);
                $update = false;
                if ($update == true) {
                    $this->session->set_flashdata('pesan', 'update_bio_mhs_success');
                } else {
                    $this->session->set_flashdata('pesan', 'update_bio_mhs_failed');
                }

                redirect(base_url('smart_mhs/profil'));
            }
        }
    }

    private function view_profil_mhs()
    {
        $nim = $this->session->userdata('username');
        $src = base_url('media/images/foto_mhs_users_smart/' . $nim . '.png');
        if (@getimagesize($src)) {
            $data['foto_profil'] = base_url('media/images/foto_mhs_users_smart/' . $nim . '.png');
        } else {
            $data['foto_profil'] = base_url("assets/sb_admin_pro/dist/assets/img/illustrations/profiles/profile-1.png");
        }

        $sem_brjln_akdmk_konfig = $this->Users_model->semester_berjalan();
        $val_sem_brjln_akdmk_konfig = $sem_brjln_akdmk_konfig->semester_aktif;
        $data_mhs = $this->Users_model->get_data_mahasiswa($nim, $val_sem_brjln_akdmk_konfig);

        //var_dump($val_sem_brjln_akdmk_konfig);

        if ($val_sem_brjln_akdmk_konfig % 2 != 0) {
            $a = (($val_sem_brjln_akdmk_konfig + 10) - 1) / 10;
            $b = $a - $data_mhs->TAHUNMSMHS;
            $c = ($b * 2) - 1;
            $semester_mhs = $c;
        } else {
            $a = (($val_sem_brjln_akdmk_konfig + 10) - 2) / 10;
            $b = $a - $data_mhs->TAHUNMSMHS;
            $c = $b * 2;
            $semester_mhs = $c;
        }
        $data['smt_brjln_mhs'] = $semester_mhs;
        $data['mahasiswa'] = $data_mhs;

        if ($data_mhs->STMHSMSMHS == 'A' && $data_mhs->TGL_AKTIVASI != null) {
            $data['statusaktif'] = $data_mhs->status;
        } else if ($data_mhs->STMHSMSMHS == 'A' && $data_mhs->TGL_AKTIVASI == null) {
            $data['statusaktif'] = '<div class=text-red>Belum Registrasi Ulang</div>';
        } else {
            $data['statusaktif'] = $data_mhs->status;
        }

        //============memecah data alamat mhs========================

        $data_al_lngkp = $data_mhs->ALAMATLENGKAP;
        //$data_al_lngkp  = 'Jl.Haji ilyas Rt.24 Rw.04 Dsn.Babadan\jDuren Kec.0300\j09009\j03000\j50775\jID';
        $pisah = explode("\n", $data_al_lngkp);
        $jumlah_array_pisah = count($pisah);

        //var_dump($pisah);

        if ($jumlah_array_pisah == 5) {
            //jalan & rt & rw & dsn
            $data['mahasiswa_jl'] = '';
            $data['mahasiswa_rw'] = '';
            $data['mahasiswa_rt'] = '';
            $data['mahasiswa_dusun'] = '';

            //desa & kecamatan
            $pisahkan_desa_kecamatan = explode("Kec.", $pisah[0]);
            $jumlah_array_pisahkan_desa_kecamatan = count($pisahkan_desa_kecamatan);
            $data['mahasiswa_desa'] = rtrim($pisahkan_desa_kecamatan[0]);
            if ($jumlah_array_pisahkan_desa_kecamatan >= 2) {
                $data['mahasiswa_kecamatan'] = $pisahkan_desa_kecamatan[1];
            } else {
                $data['mahasiswa_kecamatan'] = '';
            }
            //kabupaten atau kota
            $data['mahasiswa_kab'] = $pisah[1];
            //propinsi
            $data['mahasiswa_propinsi'] = $pisah[2];
            //kode pos
            $data['mahasiswa_kode_pos'] = $pisah[3];
            //negara
            $data['mahasiswa_negara'] = $pisah[4];
        } else if ($jumlah_array_pisah == 6) {
            //jalan & rt & rw & dsn
            ##karena untuk mendapatkan jalan,rt,rw dan dsn tidak dapat dipecah dengan fungsi explode biasa disebabkan
            ##delimiter nya berbeda-beda maka teknik pemisahan datanya dimulai dari data paling belakang berturut turut yaitu
            ##proses 1 mencari data dsn jika array hasil explode berjumlah dua maka data dsn ditemukan pada array ke 1
            $pisahkan_dusun = explode("Dsn.", $pisah[0]);


            if (count($pisahkan_dusun) == 2) { //jika data dusun ada maka pasti hasil count array adalah 2
                $data['mahasiswa_dusun'] = $pisahkan_dusun[1];
            } else { //jika count data dusun 1 maka 
                $data['mahasiswa_dusun'] = '';
            }
            ##proses 2 mencari data rw berdasarkan data pemecahan dusun jika array hasil explode berjumlah dua maka data rw ditemukan pada array ke 1
            $pisahkan_rw = explode("Rw.", $pisahkan_dusun[0]);

            if (count($pisahkan_rw) == 2) { //jika data rw ada maka pasti hasil count array adalah 2
                $data['mahasiswa_rw'] = rtrim($pisahkan_rw[1]);
            } else { //jika count data rw 1 maka 
                $data['mahasiswa_rw'] = '';
            }
            ##proses 3 mencari data rt berdasarkan data pemecahan rw jika array hasil explode berjumlah dua maka data rt ditemukan pada array ke 1
            $pisahkan_rt = explode("Rt.", $pisahkan_rw[0]);

            if (count($pisahkan_rt) == 2) { //jika data rt ada maka pasti hasil count array adalah 2
                $data['mahasiswa_rt'] = rtrim($pisahkan_rt[1]);
            } else { //jika count data rt 1 maka 
                $data['mahasiswa_rt'] = '';
            }
            ##proses 4 mencari data jalan berdasarkan data pemecahan rt array dengan value array ke 0 
            $data['mahasiswa_jl'] = rtrim($pisahkan_rt[0]);

            //desa & kecamatan
            $pisahkan_desa_kecamatan = explode("Kec.", $pisah[1]);
            $jumlah_array_pisahkan_desa_kecamatan = count($pisahkan_desa_kecamatan);
            $data['mahasiswa_desa'] = rtrim($pisahkan_desa_kecamatan[0]);
            if ($jumlah_array_pisahkan_desa_kecamatan >= 2) {
                $data['mahasiswa_kecamatan'] = $pisahkan_desa_kecamatan[1];
            } else {
                $data['mahasiswa_kecamatan'] = '';
            }
            //kabupaten atau kota
            $data['mahasiswa_kab'] = $pisah[2];
            //propinsi
            $data['mahasiswa_propinsi'] = $pisah[3];
            //kode pos
            $data['mahasiswa_kode_pos'] = $pisah[4];
            //negara
            $data['mahasiswa_negara'] = $pisah[5];
        } else {
            $data['mahasiswa_jl'] = '';
            $data['mahasiswa_rt'] = '';
            $data['mahasiswa_rw'] = '';
            $data['mahasiswa_dusun'] = '';
            $data['mahasiswa_desa'] = '';
            $data['mahasiswa_kecamatan'] = '';
            $data['mahasiswa_kab'] = '';
            $data['mahasiswa_kode_pos'] = '';
            $data['mahasiswa_negara'] = '';
            $data['mahasiswa_propinsi'] = '';
        }

        //memecah nama ortu
        $data_ortu_lngkp = $data_mhs->NAMAORTUWALI;
        $pisah_ortu = explode("|", $data_ortu_lngkp);
        $jumlah_array_pisah_ortu = count($pisah_ortu);

        if ($jumlah_array_pisah_ortu == 2) {
            $data['mahasiswa_ayah'] = $pisah_ortu[0];
            $data['mahasiswa_ibu'] = $pisah_ortu[1];
        } else if ($jumlah_array_pisah_ortu == 1) {
            $data['mahasiswa_ayah'] = $pisah_ortu[0];
            $data['mahasiswa_ibu'] = "";
        } else {
            $data['mahasiswa_ayah'] = "";
            $data['mahasiswa_ibu'] = "";
        }

        //memecah pekerjaan ortu
        $data_pk_ortu_lngkp = $data_mhs->PEKERJAANORTUWALI;
        $pisah_pk_ortu = explode("|", $data_pk_ortu_lngkp);
        $jumlah_array_pisah_pk_ortu = count($pisah_pk_ortu);

        if ($jumlah_array_pisah_pk_ortu == 2) {
            $data['mahasiswa_pekerjaan_ayah'] = $pisah_pk_ortu[0];
            $data['mahasiswa_pekerjaan_ibu'] = $pisah_pk_ortu[1];
        } else if ($jumlah_array_pisah_pk_ortu == 1) {
            $data['mahasiswa_pekerjaan_ayah'] = $pisah_pk_ortu[0];
            $data['mahasiswa_pekerjaan_ibu'] = "";
        } else {
            $data['mahasiswa_pekerjaan_ayah'] = "";
            $data['mahasiswa_pekerjaan_ibu'] = "";
        }
        //memecah pendidikan ortu
        $data_pd_ortu_lngkp = $data_mhs->PENDIDIKANORTUWALI;
        $pisah_pd_ortu = explode("|", $data_pd_ortu_lngkp);
        $jumlah_array_pisah_pd_ortu = count($pisah_pd_ortu);

        if ($jumlah_array_pisah_pd_ortu == 2) {
            $data['mahasiswa_pendidikan_ayah'] = $pisah_pd_ortu[0];
            $data['mahasiswa_pendidikan_ibu'] = $pisah_pd_ortu[1];
        } else if ($jumlah_array_pisah_pd_ortu == 1) {
            $data['mahasiswa_pendidikan_ayah'] = $pisah_pd_ortu[0];
            $data['mahasiswa_pendidikan_ibu'] = "";
        } else {
            $data['mahasiswa_pendidikan_ayah'] = "";
            $data['mahasiswa_pendidikan_ibu'] = "";
        }
        //memecah penghasilan ortu
        $data_ph_ortu_lngkp = $data_mhs->PENGHASILANORTUWALI;
        $pisah_ph_ortu = explode("|", $data_ph_ortu_lngkp);
        $jumlah_array_pisah_ph_ortu = count($pisah_ph_ortu);

        if ($jumlah_array_pisah_ph_ortu == 2) {
            $data['mahasiswa_penghasilan_ayah'] = $pisah_ph_ortu[0];
            $data['mahasiswa_penghasilan_ibu'] = $pisah_ph_ortu[1];
        } else if ($jumlah_array_pisah_ph_ortu == 1) {
            $data['mahasiswa_penghasilan_ayah'] = $pisah_ph_ortu[0];
            $data['mahasiswa_penghasilan_ibu'] = "";
        } else {
            $data['mahasiswa_penghasilan_ayah'] = "";
            $data['mahasiswa_penghasilan_ibu'] = "";
        }

        //============memecah data alamat ortu wali========================

        $data_al_lngkp_ortu = $data_mhs->ALAMATORTUWALI;
        $pisah_ortu = explode("\r\n", $data_al_lngkp_ortu);
        $jumlah_array_pisah_ortu = count($pisah_ortu);



        //var_dump($pisah_ortu);

        if ($jumlah_array_pisah_ortu == 5) {
            //echo '1';
            //jalan & rt & rw & dsn
            $data['mahasiswa_ortu_jl_rt_rw_dusun'] = '';
            //desa & kecamatan
            $data['mahasiswa_ortu_desa_kecamatan'] = $pisah_ortu[0];
            //kabupaten atau kota
            $data['mahasiswa_ortu_kab'] = $pisah_ortu[1];
            //propinsi
            $data['mahasiswa_ortu_propinsi'] = $pisah_ortu[2];
            //kode pos
            $data['mahasiswa_ortu_kode_pos'] = $pisah_ortu[3];
            //negara
            $data['mahasiswa_ortu_negara'] = $pisah_ortu[4];
        } else if ($jumlah_array_pisah_ortu == 6) {
            //echo '2';
            //jalan & rt & rw & dsn
            $data['mahasiswa_ortu_jl_rt_rw_dusun'] = $pisah_ortu[0];
            //desa & kecamatan
            $data['mahasiswa_ortu_desa_kecamatan'] = $pisah_ortu[1];
            //kabupaten atau kota
            $data['mahasiswa_ortu_kab'] = $pisah_ortu[2];
            //propinsi
            $data['mahasiswa_ortu_propinsi'] = $pisah_ortu[3];
            //kode pos
            $data['mahasiswa_ortu_kode_pos'] = $pisah_ortu[4];
            //negara
            $data['mahasiswa_ortu_negara'] = $pisah_ortu[5];
        } else {
            //echo '3';
            $data['mahasiswa_ortu_jl_rt_rw_dusun'] = '';
            $data['mahasiswa_ortu_desa_kecamatan'] = '';
            $data['mahasiswa_ortu_kab'] = '';
            $data['mahasiswa_ortu_kode_pos'] = '';
            $data['mahasiswa_ortu_negara'] = '';
            $data['mahasiswa_ortu_propinsi'] = '';
        }


        $data['dropdown_ph_pk_pd_orang_tua'] = $this->Users_model->get_ph_pk_pd_ortu_mhs();
        $data['dropdown_negara'] = $this->Users_model->get_country_mhs(TRUE);

        $data['page'] = 'smart_profile_akun/profil_mhs';
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

            $image_name = 'media/images/foto_mhs_users_smart/' . $namafile . '.png';

            file_put_contents($image_name, $data);

            echo base_url() . $image_name;
        }
    }

    public function propinsi_c()
    {
        $negara_cbo = $this->input->post('negara_cbo');

        if ($negara_cbo != null) {
            $negara = $negara_cbo;

            $get_propinsi = $this->Users_model->get_propinsi_mhs($negara);
            $data = "<option value=''>Pilih Propinsi</option>";
            $selected =  $this->input->post('value_propinsi');

            foreach ($get_propinsi as $row) {

                if ($row['id_wil'] == $selected) {
                    $data .= "<option value='$row[id_wil]' selected>$row[nm_wil]</option>";
                } else {
                    $data .= "<option value='$row[id_wil]'>$row[nm_wil]</option>";
                }
            }
            echo $data;
        } else {
            $data = "<option value=''>Pilih Propinsi</option>";
            echo $data;
        }
    }

    function kabupaten_c()
    {
        $negara_cbo = $this->input->post('negara_cbo');
        $propinsi_cbo = $this->input->post('propinsi_cbo');
        $value_propinsi = $this->input->post('value_propinsi');
        $selected =  $this->input->post('value_kabupaten');
        $cbox_ortu =  $this->input->post('cbox_ortu');

        if ($negara_cbo != null && ($propinsi_cbo != null or $value_propinsi != null)) {
            if ($propinsi_cbo != null) {
                $propinsi = $propinsi_cbo;
            } else {
                $propinsi = $value_propinsi;
            }

            $kabupaten = $this->Users_model->get_kab_mhs($propinsi, $negara_cbo);
            $data = "<option value=''>Pilih Kabupaten / Kota</option>";

            foreach ($kabupaten as $row) {
                if ($cbox_ortu == true) { //jika untuk select cbox ortu maka value nya adalah nama wilayah
                    if (stripos($row['nm_wil'], $selected) == true) { //karena yang tersimpan di database bukanlah kode kabupaten melainkan nama kab/kota yang ditulis oleh user melalui aplikasi siakad maka digunakan fungsi striops untuk mencari data yang mirip dengan data kabupaten yang diinputkan oleh user
                        $data .= "<option value='$row[nm_wil]' selected>$row[nm_wil]</option>";
                    } else if ($row['nm_wil'] == $selected) {
                        $data .= "<option value='$row[nm_wil]' selected>$row[nm_wil]</option>";
                    } else {
                        $data .= "<option value='$row[nm_wil]'>$row[nm_wil]</option>";
                    }
                } else {
                    if ($row['id_wil'] == $selected) {
                        $data .= "<option value='$row[id_wil]' selected>$row[nm_wil]</option>";
                    } else {
                        $data .= "<option value='$row[id_wil]'>$row[nm_wil]</option>";
                    }
                }
            }
            echo $data;
        } else {
            $data = "<option value=''>Pilih Kabupaten / Kota</option>";
            echo $data;
        }
    }

    function kecamatan_c()
    {
        $negara_cbo = $this->input->post('negara_cbo');
        $kabupaten_cbo = $this->input->post('kabupaten_cbo');
        $value_kabupaten = $this->input->post('value_kabupaten');
        $selected =  $this->input->post('value_kecamatan');

        if ($negara_cbo != null && ($kabupaten_cbo != null or $value_kabupaten != null)) {

            if ($kabupaten_cbo != null) {
                $kabupaten = $kabupaten_cbo;
            } else {
                $kabupaten = $value_kabupaten;
            }


            $kecamatan = $this->Users_model->get_kec_mhs($kabupaten, $negara_cbo);
            $data = "<option value=''>Pilih Kecamatan / Kota</option>";

            foreach ($kecamatan as $row) {

                if ($row['id_wil'] == $selected) {
                    $data .= "<option value='$row[id_wil]' selected>$row[nm_wil]</option>";
                } else {
                    $data .= "<option value='$row[id_wil]'>$row[nm_wil]</option>";
                }
            }
            echo $data;
        } else {
            $data = "<option value=''>Pilih Kecmatan</option>";
            echo $data;
        }
    }

    public function ganti_password_mhs()
    {
        //google cpatcha
        $data['captcha'] = $this->recaptcha->getWidget();
        $data['script_captcha']   = $this->recaptcha->getScriptTag();

        if ($this->input->post() != null) {
            $this->form_validation->set_rules('password_lama_mhs', 'Password Lama', 'required|callback_password_check');
            $this->form_validation->set_rules('password_baru_mhs', 'Password Baru', 'required|min_length[8]');
            $this->form_validation->set_rules('konfirmasi_password_baru_mhs', 'Konfirmasi Password Baru', 'required|matches[password_baru_mhs]');
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required');

            $this->form_validation->set_message('required', '%s wajib diisi');
            $this->form_validation->set_message('matches', 'konfirmasi password tidak sama');
            $this->form_validation->set_message('min_length', '%s minimal 8 karakter');

            $this->form_validation->set_error_delimiters('<span class="badge badge-danger mt-1">', '</span>');

           

            $recaptcha = $this->input->post('g-recaptcha-response');
            $response = $this->recaptcha->verifyResponse($recaptcha);


            if ($this->form_validation->run() == true && $response['success'] == true) {
                $password =  $this->input->post('password_baru_mhs');

                $nim = $this->session->userdata('username');
                $update = $this->Users_model->update_password_mahasiswa($nim, $password);
                if ($update == true) {
                    $this->session->set_flashdata('pesan', 'update_pass_mhs_success');
                } else {
                    $this->session->set_flashdata('pesan', 'update_pass_mhs_failed');
                }

                redirect(base_url('smart_mhs/ganti_password_mhs'));
            }
        }
        $data['page'] = 'smart_profile_akun/ganti_password_mhs';
        $this->load->view($this->theme, $data);
    }

    function password_check()
    {
        $username = $this->session->userdata('username');
        $password = $this->input->post('password_lama_mhs');
        $user = $this->Users_model->check_user_mhs($username, $password);
        if ($user == null) {
            $this->form_validation->set_message('password_check', '%s tidak sesuai');
            return false;
        } else {
            return true;
        }
    }
}
