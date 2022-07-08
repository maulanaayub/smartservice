<?php

/**
 * @package     Api.php
 * @author      Aditya Nursyahbani
 * @link        http://www.aditya-nursyahbani.net/2016/10/tutorial-oauth2-dengan-codeigniter.html
 * @copyright   Copyright(c) 2016
 * @version     1.0.0
 **/

defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller_Smartmobile.php');
include_once __DIR__ . "/BniEnc.php";


class Smartmhs extends REST_Controller_Smartmobile
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('Smart_mobile_mhs_model/Api_model');
    }


    public function jadwalmhs_post()
    {
        $nim = $this->post('unim');
        $sem = $this->post('selected_semester');

        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('selected_semester', 'Semester', 'required|numeric|integer|greater_than_equal_to[1]');
        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_message('numeric', '%s harus angka');
        $this->form_validation->set_message('integer', '%s harus bilangan bulat');
        $this->form_validation->set_message('greater_than_equal_to', '%s harus diatas 1');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {
            $data_mhs = $this->Api_model->cek_nim_siakad($nim);

            if ($data_mhs != null) {
                $thsmt = $this->th_smt_mhs_by_smt($data_mhs['SMAWLMSMHS'], $sem);

                $list_mk = $this->Api_model->jadwal_kuliah_mhs_api_mobile($nim, $thsmt);

                if ($list_mk != null) {
                    $jadwalpecah = array();

                    foreach ($list_mk as $value) {
                        if (!array_keys(array_column($jadwalpecah, 'hari'), $value['hari'])) {
                            $item_makul = null;
                            foreach ($list_mk as $value2) {
                                if ($value["hari"] == $value2["hari"]) {
                                    $item_makul[] = ["makul" => $value2['makul'], "sks" => $value2['sks'], "ruang" => $value2['ruang'], "waktu" => $value2['jam'], "dosen" => $this->nama_dosen_dg_gelar($value2['dosen'], $value2['gelar']), "ruang" => $value2['ruang']];
                                }
                            }
                            $jadwalpecah[] = array("hari" => $value["hari"], "item_makul" => $item_makul);
                        }
                    }

                    $success = true;
                    $message = 'Jadwal ditemukan';
                    $data = $jadwalpecah;
                } else {
                    $success = false;
                    $message = 'Jadwal tidak ditemukan';
                    $data = null;
                }
            } else {
                $success = false;
                $message = 'Nim mahasiswa tidak ditemukan';
                $data = null;
            }
        } else {
            $success = false;

            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $sem_err = form_error('semester') ? form_error('semester') : null;
            $message = $unim_err . $sem_err;
            //$message = form_error('unim');
            $data = null;
        }

        sleep(0.5);
        $this->response([
            'success' => $success,
            'message' => $message,
            'semester' => $sem,
            'data' => $data,
        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    // function jadwalmhs_post()
    // {
    //     $semester = $this->post('selected_semester');
    //     $nim = $this->post('unim');

    //     // $jadwal_smt_3 = array(
    //     //     [
    //     //         "hari" => "senin",
    //     //         "item_makul" => array(
    //     //             ["makul" => "etodologi penelitian", "sks" => 3, "kelas" => "Kelas A.7", "waktu" => "08:00 - 10:00"],
    //     //             ["makul" => "Bahasa Arab", "sks" => 4, "kelas" => "Kelas A.7", "waktu" => "10:00 - 12:00"]
    //     //         )
    //     //     ],
    //     //     [
    //     //         'hari' => 'Selasa',
    //     //         'item_makul' => array(
    //     //             ["makul" => "Pendidikan Anak", "sks" => 3, "kelas" => "Kelas A.7", "waktu" => "07:00 - 09:00"],
    //     //             ["makul" => "Statistika", "sks" => 2, "kelas" => "Kelas A.7", "waktu" => "09:00 - 10:00"],
    //     //             ["makul" => "Bahasa Indonesia", "sks" => 4, "kelas" => "Kelas A.7", "waktu" => "10:00 - 12:00"],
    //     //             ["makul" => "Bahasa Inggris", "sks" => 4, "kelas" => "Kelas A.7", "waktu" => "14:00 : 16:00"],
    //     //         )
    //     //     ],
    //     //     [
    //     //         'hari' => 'Rabu',
    //     //         'item_makul' => array(
    //     //             ["makul" => "Multimedia Lanjutan", "sks" => 2, "kelas" => "Kelas A.7", "waktu" => "07:00 - 09:00"],
    //     //             ["makul" => "KKN", "sks" => 2, "kelas" => "Kelas A.7", "waktu" => "09:00 - 10:00"]
    //     //         )
    //     //     ]

    //     // );

    //     // $jadwal_smt_2 = array(
    //     //     [
    //     //         "hari" => "senin",
    //     //         "item_makul" => array(
    //     //             ["makul" => "Pemprograman Web", "sks" => 3, "kelas" => "Kelas A.7", "waktu" => "09:00 - 11:00"],
    //     //             ["makul" => "Pemprograman Mobile", "sks" => 2, "kelas" => "Kelas A.7", "waktu" => "11:00 - 12:00"],
    //     //             ["makul" => "Database", "sks" => 3, "kelas" => "Kelas A.7", "waktu" => "13:00 - 15:00"],
    //     //         )
    //     //     ],
    //     //     [
    //     //         'hari' => 'Selasa',
    //     //         'item_makul' => array(
    //     //             ["makul" => "Kalkulus", "sks" => 2, "kelas" => "Kelas A.7",  "waktu" => "09:00 - 11:00"],
    //     //             ["makul" => "Pendidikan Kewarganegaraan", "sks" => 4, "kelas" => "Kelas A.7",  "waktu" => "11:00 - 13:00"],
    //     //             ["makul" => "Pendidikan Kesopanan", "sks" => 2, "kelas" => "Kelas A.7", "waktu" => "13:00 - 14:00"],
    //     //         )
    //     //     ],
    //     //     [
    //     //         'hari' => 'Jumat',
    //     //         'item_makul' => array(
    //     //             ["makul" => "PPL", "sks" => 1, "kelas" => "Kelas A.7", "waktu" => "14:00 - 16:00"]
    //     //         )
    //     //     ]

    //     // );


    //     // $jadwal_smt_1 = [
    //     //     [
    //     //         'hari' => 'Senin',
    //     //         'item_makul' => [
    //     //             ["makul" => "Data Mining", "sks" => 4, "kelas" => "Kelas A.7", "waktu" => '07:00 - 09:00'],
    //     //             ["makul" => "Bahasa Inggris I", "sks" => 2, "kelas" => "Kelas A.7", "waktu" => '09:00 - 10:00'],
    //     //             ["makul" => "Bahasa Indonesia II", "sks" => 3, "kelas" => "Kelas A.7", "waktu" => "10:00 - 12:00"],
    //     //             ["makul" => "Matematika Diskrit", "sks" => 2, "kelas" => "Kelas A.7", "waktu" => "13:00 - 15:00"],
    //     //         ]

    //     //     ],
    //     //     [
    //     //         'hari' => 'kamis',
    //     //         'item_makul' => [
    //     //             ["makul" => "Database Lanjutan", "sks" => 2, "kelas" => "Kelas A.7", "waktu" => "07:00 - 08:00"],
    //     //             ["makul" => "Pendidikan Kesopanan", "sks" => 1, "kelas" => "Kelas A.7", "waktu" => "09:00 - 10:00"],
    //     //             ["makul" => "KKL", "sks" => 1, "kelas" => "Kelas A.7", "waktu" => "11:00 - 12:00"]
    //     //         ]
    //     //     ]

    //     // ];

    //     // $message = 'Jadwal ditemukan';
    //     // if ($semester == 3) {
    //     //     $data_jadwal = $jadwal_smt_3;
    //     // } else if ($semester == 2) {
    //     //     $data_jadwal = $jadwal_smt_2;
    //     // } else if ($semester == 1) {
    //     //     $data_jadwal = $jadwal_smt_1;
    //     // } else {
    //     //     $data_jadwal = null;
    //     //     $message = 'Jadwal tidak ditemukan';
    //     // }


    //     if ($semester == 1) {
    //         $jadwal = array(
    //             ["makul" => "Database Lanjutan", "sks" => 2, "kelas" => "Kelas A.7", "waktu" => "07:00 - 08:00", "hari" => 'senin', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Pendidikan Kesopanan", "sks" => 1, "kelas" => "Kelas A.7", "waktu" => "09:00 - 10:00", "hari" => 'senin', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "KKL", "sks" => 1, "kelas" => "Kelas A.7", "waktu" => "11:00 - 12:00", "hari" => 'selasa', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Data Mining", "sks" => 4, "kelas" => "Kelas A.7", "waktu" => '13:00 - 15:00', "hari" => 'selasa', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Bahasa Inggris I", "sks" => 2, "kelas" => "Kelas A.7", "waktu" => '09:00 - 10:00', "hari" => 'rabu', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Bahasa Indonesia II", "sks" => 3, "kelas" => "Kelas A.7", "waktu" => "10:00 - 12:00", "hari" => 'kamis', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Matematika Diskrit", "sks" => 2, "kelas" => "Kelas A.7", "waktu" => "13:00 - 15:00", "hari" => 'senin', "dosen" => "Maulana Ayub Dwi Saputra"]
    //         );
    //     } else if ($semester == 2) {
    //         $jadwal = array(
    //             ["makul" => "Pemprograman Web", "sks" => 3, "kelas" => "Kelas A.7", "waktu" => "07:00 - 08:00", "hari" => 'senin', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Pemprograman Mobile", "sks" => 2, "kelas" => "Kelas A.7",  "waktu" => "10:00 - 12:00", "hari" => 'senin', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Database", "sks" => 3, "kelas" => "Kelas A.7", "waktu" => "07:00 - 08:00", "hari" => 'selasa', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Kalkulus", "sks" => 2, "kelas" => "Kelas A.7",  "waktu" => "09:00 - 11:00", "hari" => 'selasa', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Pendidikan Kewarganegaraan", "sks" => 4, "kelas" => "Kelas A.7", "waktu" => "07:00 - 08:00", "hari" => 'rabu', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Pendidikan Kesopanan", "sks" => 2, "kelas" => "Kelas A.7",  "waktu" => "07:00 - 08:00", "hari" => 'kamis', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "PPL", "sks" => 1, "kelas" => "Kelas A.7",  "waktu" => "09:00 - 10:00", "hari" => 'kamis', "dosen" => "Maulana Ayub Dwi Saputra"]
    //         );
    //     } else if ($semester == 3) {
    //         $jadwal = array(
    //             ["makul" => "Metodologi penelitian", "sks" => 3, "kelas" => "Kelas A.7", "waktu" => "07:00 - 08:00", "hari" => 'senin', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Bahasa Arab", "sks" => 4, "kelas" => "Kelas A.7", "waktu" => "12:00 - 16:00", "hari" => 'senin', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Bahasa Jawa", "sks" => 4, "kelas" => "Kelas A.7", "waktu" => "12:00 - 16:00", "hari" => 'minggu', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Pendidikan Anak", "sks" => 3, "kelas" => "Kelas A.7", "waktu" => "07:00 - 08:00", "hari" => 'selasa', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Statistika", "sks" => 2, "kelas" => "Kelas A.7", "waktu" => "12:00 - 14:00", "hari" => 'selasa', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Bahasa Indonesia", "sks" => 4, "kelas" => "Kelas A.7", "waktu" => "07:00 - 08:00", "hari" => 'kamis', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Bahasa Inggris", "sks" => 4, "kelas" => "Kelas A.7", "waktu" => "08:00 - 09:00", "hari" => 'kamis', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "Multimedia Lanjutan", "sks" => 2, "kelas" => "Kelas A.7", "waktu" => "07:00 - 08:00", "hari" => 'jumat', "dosen" => "Maulana Ayub Dwi Saputra"],
    //             ["makul" => "KKN", "sks" => 2, "kelas" => "Kelas A.7", "waktu" => "16:00 - 17:00", "hari" => 'jumat', "dosen" => "Maulana Ayub Dwi Saputra"],
    //         );
    //     } else {
    //         $jadwal = null;
    //     }

    //     if ($jadwal == null) {
    //         $message = 'Jadwal tidak ditemukan';
    //         $data_jadwal = null;
    //     } else {


    //         $jadwalpecah = array();

    //         foreach ($jadwal as $value) {
    //             if (!array_keys(array_column($jadwalpecah, 'hari'), $value['hari'])) {
    //                 $item_makul = null;
    //                 foreach ($jadwal as $value2) {
    //                     if ($value["hari"] == $value2["hari"]) {
    //                         $item_makul[] = ["makul" => $value2['makul'], "sks" => $value2['sks'], "kelas" => $value2['kelas'], "waktu" => $value2['waktu'], "dosen" => $value2['dosen']];
    //                     }
    //                 }
    //                 $jadwalpecah[] = array("hari" => $value["hari"], "item_makul" => $item_makul);
    //             }
    //         }



    //         $message = 'Jadwal ditemukan';
    //         $data_jadwal = $jadwalpecah;
    //     }

    //     sleep(1);

    //     $this->response([
    //         'success' => true,
    //         'message' => $message,
    //         'semester' => $semester,
    //         'data' => $data_jadwal,
    //     ], REST_Controller_Smartmobile::HTTP_OK);
    // }

    public function list_penawaran_mk_get()
    {
        $nim = $this->get('unim');
        //$kode_makul = $this->post('kode_makul');
        $kode_pst = $this->get('kode_pst');
        $kode_jen = $this->get('kode_jen');

        $querylink = array("unim" => $nim, "kode_pst" => $kode_pst, "kode_jen" => $kode_jen);
        $this->form_validation->set_data($querylink);

        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('kode_pst', 'Kode Program Studi', 'required');
        $this->form_validation->set_rules('kode_jen', 'Kode Jenjang', 'required');
        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_error_delimiters('', '');


        if ($this->form_validation->run() == true) {
            $conf_key = 'cminatkrs_' . $kode_jen . '~' . $kode_pst;
            $get_tgl_input_mk = $this->Api_model->cek_tgl_input_mk($conf_key);


            if ($get_tgl_input_mk != null) {
                $tgl_periode_input_mk = $get_tgl_input_mk['conf_keyval'];

                $pecah_tgl_periode_input_mk = explode('~', '2022-01-26 08:30:00~2022-06-30 23:59:00'); //explode('~',$tgl_periode_input_mk);

                if (count($pecah_tgl_periode_input_mk) == 2) {
                    $waktu_sekarang = time();
                    $waktu_mulai = strtotime($pecah_tgl_periode_input_mk[0]);
                    $waktu_selesai = strtotime($pecah_tgl_periode_input_mk[1]);

                    //$tgl_mulai = date("m-d-Y H:i:s", $waktu_mulai);

                    if ($waktu_sekarang > $waktu_mulai && $waktu_sekarang < $waktu_selesai) {

                        $data_mhs = $this->Api_model->cek_nim_siakad($nim);

                        //var_dump($data_mhs);

                        if ($data_mhs != null) {


                            $tahunsmtakademik = $this->Api_model->cek_thsmt_akademik()->semester_aktif;
                            $cek_status_aktif_mhs = $this->Api_model->cek_status_aktif_mhs($tahunsmtakademik, $nim);

                            if ($cek_status_aktif_mhs) {
                                $tahunsmtinputmk = $this->Api_model->cek_thsmt_inputmk();
                                $thsmt = $tahunsmtinputmk['conf_keyval'];
                                $sem_mhs_now = $this->smt_mhs_by_th_smt($data_mhs['TAHUNMSMHS'], $thsmt);
                                $get_list_mk = $this->Api_model->get_list_mk_input_mk($thsmt, $kode_jen, $kode_pst, $nim, $sem_mhs_now);

                                //var_dump($get_list_mk);

                                if ($get_list_mk != null) {
                                    $semester_pecah = array();

                                    //var_dump($get_list_mk);

                                    foreach ($get_list_mk as $value) {
                                        if (!array_keys(array_column($semester_pecah, 'semester'), $value['SEMESTBKMK'])) {
                                            $item_makul = null;
                                            foreach ($get_list_mk as $value2) {
                                                if ($value["SEMESTBKMK"] == $value2["SEMESTBKMK"]) {


                                                    if ($value2["kdkmksyarat"] != null) {
                                                        $variabel = $value2['KDJENTBKMK'] . $value2['KDPSTTBKMK'] . $value2['KDKMKTBKMK'];
                                                        $get_nilai_mk_syarat = $this->Api_model->get_nilai_mk_syarat($variabel, $nim, $kode_jen, $kode_pst, $thsmt);

                                                        // var_dump($get_nilai_mk_syarat);
                                                        //$item_makul[] = $get_nilai_mk_syarat;

                                                        //tms1 = sudah ambil mk prasyarat tapi nilai belum dikeluarkan
                                                        //tms2 = belum ambil mk prasyarat
                                                        //tms3 = nilai mk prasyarat kurang

                                                        $message = null;
                                                        $status = "ms";
                                                        $com = null;
                                                        $syarat_arr = null;
                                                        $i = 1;
                                                        foreach ($get_nilai_mk_syarat as $kuy) {
                                                            if ($kuy['syarat'] == "tms1") {
                                                                $status = "tms";
                                                                $com .= "<li> Nilai mata kuliah " . $kuy['nama_makul_syarat'] . " belum diinput kedalam sistem</li>";
                                                                $syarat_arr[] = ["kdmk_syarat" => $kuy['kdkmksyarat'], "nama_makul_syarat" => $kuy['nama_makul_syarat'], "nilai_syarat_min" => $kuy["nilai_syarat_min"], "nilai_mk" => $kuy["nilai_mk"]];
                                                                $i++;
                                                            } else if ($kuy['syarat'] == "tms2") {
                                                                $status = "tms";
                                                                $com .= "<li> Anda belum mengambil mata kuliah " . $kuy['nama_makul_syarat'] . " sebagai mata kuliah prasyarat</li>";
                                                                $syarat_arr[] = ["kdmk_syarat" => $kuy['kdkmksyarat'], "nama_makul_syarat" => $kuy['nama_makul_syarat'], "nilai_syarat_min" => $kuy["nilai_syarat_min"], "nilai_mk" => $kuy["nilai_mk"]];
                                                                $i++;
                                                            } else if ($kuy['syarat'] == "tms3") {
                                                                $status = "tms";
                                                                $com .= "<li> Nilai mata kuliah " . $kuy['nama_makul_syarat'] . "=" . $kuy['nilai_mk'] . " berada dibawah ketentuan yaitu " . $kuy['nilai_syarat_min'] . "</li>";
                                                                $syarat_arr[] = ["kdmk_syarat" => $kuy['kdkmksyarat'], "nama_makul_syarat" => $kuy['nama_makul_syarat'], "nilai_syarat_min" => $kuy["nilai_syarat_min"], "nilai_mk" => $kuy["nilai_mk"]];
                                                                $i++;
                                                            } else {
                                                                $syarat_arr[] = ["kdmk_syarat" => $kuy['kdkmksyarat'], "nama_makul_syarat" => $kuy['nama_makul_syarat'], "nilai_syarat_min" => $kuy["nilai_syarat_min"], "nilai_mk" => $kuy["nilai_mk"]];
                                                            }
                                                        }

                                                        if ($status == "ms") {
                                                            $message = "memenuhi syarat";
                                                        } else {
                                                            $message = "<ol>$com</ol>";
                                                        }



                                                        $item_makul[] = ["thsms_mk" => $value2['THSMSTBKMK'], "kdjen_mk" => $value2['KDJENTBKMK'], "kdpst_mk" => $value2['KDPSTTBKMK'], "kdmk_mk" => $value2['KDKMKTBKMK'], "nama_mk" => $value2['NAKMKTBKMK'], "sks_mk" => $value2['SKSMKTBKMK'], "sudah_input_pmk" => $value2['ket_sudah_input'], "tgl_input_pmk" => $value2['tglinput'], "pernah_ambil_mk" => $value2["pernah_ambil_khs"], "detail_syarat" => $syarat_arr, "keterangan" => $status, "desc" => "$message"];
                                                    } else {
                                                        $item_makul[] = ["thsms_mk" => $value2['THSMSTBKMK'], "kdjen_mk" => $value2['KDJENTBKMK'], "kdpst_mk" => $value2['KDPSTTBKMK'], "kdmk_mk" => $value2['KDKMKTBKMK'], "nama_mk" => $value2['NAKMKTBKMK'], "sks_mk" => $value2['SKSMKTBKMK'], "sudah_input_pmk" => $value2['ket_sudah_input'], "tgl_input_pmk" => $value2['tglinput'], "pernah_ambil_mk" => $value2["pernah_ambil_khs"], "detail_syarat" => null, "keterangan" => "ms", "desc" => "memenuhi syarat"];
                                                    }
                                                }
                                            }
                                            $semester_pecah[] = array("semester" => $value["SEMESTBKMK"], "item_makul" => $item_makul);
                                        }
                                    }

                                    $success = true;
                                    $message = 'List mata kuliah ditemukan';
                                    $data = $semester_pecah;


                                    $get_jatah_sks = $this->Api_model->get_prodi_jatah_sks($kode_jen, $kode_pst);

                                    if ($get_jatah_sks != null) {
                                        $array_jatah_sks = $get_jatah_sks;
                                    } else {
                                        $array_jatah_sks = array(
                                            ["rentang1" => '3.50', "rentang2" => '4.00', "jatahsks" => '24'],
                                            ["rentang1" => '3.00', "rentang2" => '3.49', "jatahsks" => '22'],
                                            ["rentang1" => '2.50', "rentang2" => '2.99', "jatahsks" => '21'],
                                            ["rentang1" => '2.00', "rentang2" => '2.49', "jatahsks" => '18'],
                                            ["rentang1" => '1.50', "rentang2" => '1.99', "jatahsks" => '16'],
                                            ["rentang1" => '1.00', "rentang2" => '1.49', "jatahsks" => '14'],
                                            ["rentang1" => '0', "rentang2" => '0.99', "jatahsks" => '12'],
                                        );
                                    }


                                    $thsmt_aktif_terakir = $this->Api_model->cek_last_registrasi($nim, $thsmt);
                                    $ips_mhs = $this->Api_model->get_ips_mhs($nim, $thsmt_aktif_terakir['thsms_aktif_terakhir'], $kode_jen, $kode_pst);


                                    if ($sem_mhs_now == 1) {
                                        $jatah_sks = "24";
                                    } else {
                                        $jatah_sks = "12";
                                    }



                                    $smt_aktif_sblmya = $thsmt_aktif_terakir['thsms_aktif_terakhir'];

                                    foreach ($array_jatah_sks as $val) {
                                        if ($ips_mhs >= $val['rentang1'] && $ips_mhs <= $val['rentang2']) {
                                            $jatah_sks = $val['jatahsks'];
                                            break;
                                        }
                                    }


                                    //$jatah_sks = $jatah_sks;
                                    $tgl_pertama_inputmk = tgl_indo_timestamp($waktu_mulai);
                                    $tgl_akhir_inputmk = tgl_indo_timestamp($waktu_selesai);
                                } else {
                                    $success = false;
                                    $message = 'List mata kuliah tidak ditemukan';
                                    $data = null;
                                    $jatah_sks = 0;
                                    $tgl_pertama_inputmk = tgl_indo_timestamp($waktu_mulai);
                                    $tgl_akhir_inputmk = tgl_indo_timestamp($waktu_selesai);
                                }
                            } else {
                                $success = false;
                                $message = "Input Penawaran Mata Kuliah hanya bisa dilakukan oleh mahasiswa aktif";
                                $data = null;

                                $jatah_sks = null;
                                $ips_mhs = 0;
                                $smt_aktif_sblmya = null;
                                $thsmt = null;

                                $tgl_pertama_inputmk = tgl_indo_timestamp($waktu_mulai);
                                $tgl_akhir_inputmk = tgl_indo_timestamp($waktu_selesai);
                            }
                        } else {
                            $success = false;
                            $message = "Nim tidak ditemukan";
                            $data = null;

                            $jatah_sks = null;
                            $ips_mhs = 0;
                            $smt_aktif_sblmya = null;
                            $thsmt = null;

                            $tgl_pertama_inputmk = tgl_indo_timestamp($waktu_mulai);
                            $tgl_akhir_inputmk = tgl_indo_timestamp($waktu_selesai);
                        }
                    } else {
                        if ($waktu_sekarang < $waktu_mulai) {
                            $success = false;
                            $message = "Periode input penawaran mata kuliah belum dimulai, input penawaran mata kuliah akan dimulai pada \n " . tgl_indo_timestamp($waktu_mulai);
                            $data = null;

                            $jatah_sks = null;
                            $ips_mhs = 0;
                            $smt_aktif_sblmya = null;
                            $thsmt = null;

                            $tgl_pertama_inputmk = tgl_indo_timestamp($waktu_mulai);
                            $tgl_akhir_inputmk = tgl_indo_timestamp($waktu_selesai);
                        } else {
                            $success = false;
                            $message = "Periode input penawaran mata kuliah sudah selesai, batas akhir input penawaran mata kuliah pada \n " . tgl_indo_timestamp($waktu_selesai);
                            $data = null;

                            $jatah_sks = null;
                            $ips_mhs = 0;
                            $smt_aktif_sblmya = null;
                            $thsmt = null;

                            $tgl_pertama_inputmk = tgl_indo_timestamp($waktu_mulai);
                            $tgl_akhir_inputmk = tgl_indo_timestamp($waktu_selesai);
                        }
                    }
                } else {
                    $success = false;
                    $message = "Periode tanggal input penawaran mata kuliah tidak sesuai format";
                    $data = null;

                    $jatah_sks = null;
                    $ips_mhs = 0;
                    $smt_aktif_sblmya = null;
                    $thsmt = null;

                    $tgl_pertama_inputmk = null;
                    $tgl_akhir_inputmk = null;
                }
            } else {
                $success = false;
                $message = "Periode tanggal input penawaran mata kuliah tidak ditemukan";
                $data = null;

                $jatah_sks = null;
                $ips_mhs = 0;
                $smt_aktif_sblmya = null;
                $thsmt = null;

                $tgl_pertama_inputmk = null;
                $tgl_akhir_inputmk = null;
            }
        } else {
            $success = false;

            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $kdpst_err = form_error('kode_pst') ? form_error('kode_pst') . ' ' : null;
            $kdjen_err = form_error('kode_jen') ? form_error('kode_jen') : null;
            $message = $unim_err . $kdpst_err . $kdjen_err;
            $data = null;

            $jatah_sks = null;
            $ips_mhs = 0;
            $smt_aktif_sblmya = null;
            $thsmt = null;

            $tgl_pertama_inputmk = null;
            $tgl_akhir_inputmk = null;
        }

        //sleep(1);


        $this->response([
            'success' => $success,
            'message' => $message,
            'jatah_sks' => $jatah_sks,
            'smt_penawaran_mk' => $thsmt,
            'smt_aktif_sebelumnya' => $smt_aktif_sblmya,
            'ips_smt_sebelumnya' => number_format($ips_mhs, 2),
            'waktu_mulai' => $tgl_pertama_inputmk,
            'waktu_selesai' => $tgl_akhir_inputmk,
            'data' => $data,
        ], REST_Controller_Smartmobile::HTTP_OK);
    }


    public function riwayat_penawaran_mk_get()
    {
        $nim = $this->get('unim');
        //$kode_makul = $this->post('kode_makul');
        $kode_pst = $this->get('kode_pst');
        $kode_jen = $this->get('kode_jen');
        $semester = $this->get('semester');

        $querylink = array("unim" => $nim, "kode_pst" => $kode_pst, "kode_jen" => $kode_jen, "semester" => $semester);
        $this->form_validation->set_data($querylink);

        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('kode_pst', 'Kode Program Studi', 'required');
        $this->form_validation->set_rules('kode_jen', 'Kode Jenjang', 'required');
        $this->form_validation->set_rules('semester', 'Semester', 'required');
        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_error_delimiters('', '');


        if ($this->form_validation->run() == true) {

            $data_mhs = $this->Api_model->cek_nim_siakad($nim);


            if ($data_mhs != null) {

                // $tahunsmtinputmk = $this->Api_model->cek_thsmt_inputmk();
                // $thsmt = $tahunsmtinputmk['conf_keyval'];
                // $sem_mhs_now = $this->smt_mhs_by_th_smt($data_mhs['TAHUNMSMHS'], $thsmt);
                $thsms_mhs_selected = $this->th_smt_mhs_by_smt($data_mhs['SMAWLMSMHS'], $semester);
                $get_list_mk = $this->Api_model->get_riwayat_mk_input_mk($thsms_mhs_selected, $kode_jen, $kode_pst, $nim);

                //var_dump($get_list_mk);

                if ($get_list_mk != null) {
                    $semester_pecah = array();

                    //var_dump($get_list_mk);

                    foreach ($get_list_mk as $value) {
                        if (!array_keys(array_column($semester_pecah, 'semester'), $value['SEMESTBKMK'])) {
                            $item_makul = null;
                            foreach ($get_list_mk as $value2) {
                                if ($value["SEMESTBKMK"] == $value2["SEMESTBKMK"]) {
                                    $item_makul[] = ["thsms_mk" => $value2['THSMSTBKMK'], "kdjen_mk" => $value2['KDJENTBKMK'], "kdpst_mk" => $value2['KDPSTTBKMK'], "kdmk_mk" => $value2['KDKMKTBKMK'], "nama_mk" => $value2['NAKMKTBKMK'], "sks_mk" => $value2['SKSMKTBKMK'], "tgl_input_pmk" => $value2['tglinput']];
                                }
                            }
                            $semester_pecah[] = array("semester" => $value["SEMESTBKMK"], "item_makul" => $item_makul);
                        }
                    }

                    $success = true;
                    $message = 'List mata kuliah ditemukan';
                    $data = $semester_pecah;
                    $thsmt = $thsms_mhs_selected;


                    $get_jatah_sks = $this->Api_model->get_prodi_jatah_sks($kode_jen, $kode_pst);

                    if ($get_jatah_sks != null) {
                        $array_jatah_sks = $get_jatah_sks;
                    } else {
                        $array_jatah_sks = array(
                            ["rentang1" => '3.50', "rentang2" => '4.00', "jatahsks" => '24'],
                            ["rentang1" => '3.00', "rentang2" => '3.49', "jatahsks" => '22'],
                            ["rentang1" => '2.50', "rentang2" => '2.99', "jatahsks" => '21'],
                            ["rentang1" => '2.00', "rentang2" => '2.49', "jatahsks" => '18'],
                            ["rentang1" => '1.50', "rentang2" => '1.99', "jatahsks" => '16'],
                            ["rentang1" => '1.00', "rentang2" => '1.49', "jatahsks" => '14'],
                            ["rentang1" => '0', "rentang2" => '0.99', "jatahsks" => '12'],
                        );
                    }


                    $thsmt_aktif_terakir = $this->Api_model->cek_last_registrasi($nim, $thsms_mhs_selected);
                    $ips_mhs = $this->Api_model->get_ips_mhs($nim, $thsmt_aktif_terakir['thsms_aktif_terakhir'], $kode_jen, $kode_pst);


                    if ($semester == 1) {
                        $jatah_sks = "24";
                    } else {
                        $jatah_sks = "12";
                    }



                    $smt_aktif_sblmya = $thsmt_aktif_terakir['thsms_aktif_terakhir'];

                    foreach ($array_jatah_sks as $val) {
                        if ($ips_mhs >= $val['rentang1'] && $ips_mhs <= $val['rentang2']) {
                            $jatah_sks = $val['jatahsks'];
                            break;
                        }
                    }
                } else {
                    $success = false;
                    $message = 'List mata kuliah tidak ditemukan';
                    $data = null;
                    $jatah_sks = 0;
                    $thsmt = null;
                    $ips_mhs = 0;
                    $smt_aktif_sblmya = null;
                }
            } else {
                $success = false;
                $message = "Nim tidak ditemukan";
                $data = null;

                $jatah_sks = null;
                $ips_mhs = 0;
                $smt_aktif_sblmya = null;
                $thsmt = null;
            }
        } else {
            $success = false;

            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $kdpst_err = form_error('kode_pst') ? form_error('kode_pst') . ' ' : null;
            $sem_err = form_error('semester') ? form_error('semester') . ' ' : null;
            $kdjen_err = form_error('kode_jen') ? form_error('kode_jen') : null;
            $message = $unim_err . $kdpst_err . $sem_err . $kdjen_err;
            $data = null;

            $jatah_sks = null;
            $ips_mhs = 0;
            $smt_aktif_sblmya = null;
            $thsmt = null;
        }

        //sleep(1);


        $this->response([
            'success' => $success,
            'message' => $message,
            'jatah_sks' => $jatah_sks,
            'smt_penawaran_mk' => $thsmt,
            'smt_aktif_sebelumnya' => $smt_aktif_sblmya,
            'ips_smt_sebelumnya' => number_format($ips_mhs, 2),

            'data' => $data,
        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    public function list_krs_mk_get()
    {
        $nim = $this->get('unim');
        //$kode_makul = $this->post('kode_makul');
        $kode_pst = $this->get('kode_pst');
        $kode_jen = $this->get('kode_jen');

        $querylink = array("unim" => $nim, "kode_pst" => $kode_pst, "kode_jen" => $kode_jen);
        $this->form_validation->set_data($querylink);

        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('kode_pst', 'Kode Program Studi', 'required');
        $this->form_validation->set_rules('kode_jen', 'Kode Jenjang', 'required');
        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_error_delimiters('', '');


        if ($this->form_validation->run() == true) {
            $conf_key = 'aam_' . $kode_jen . '~' . $kode_pst;
            $get_tgl_krs_mk = $this->Api_model->cek_tgl_input_mk($conf_key);
            if ($get_tgl_krs_mk != null) {
                $tgl_periode_krs_mk = $get_tgl_krs_mk['conf_keyval'];

                $pecah_tgl_periode_krs_mk = explode('~', '2022-01-26 08:30:00~2022-06-30 23:59:00'); //explode('~',$tgl_periode_krs_mk);

                if (count($pecah_tgl_periode_krs_mk) == 2) {
                    $waktu_sekarang = time();
                    $waktu_mulai = strtotime($pecah_tgl_periode_krs_mk[0]);
                    $waktu_selesai = strtotime($pecah_tgl_periode_krs_mk[1]);

                    if ($waktu_sekarang > $waktu_mulai && $waktu_sekarang < $waktu_selesai) {
                        $data_mhs = $this->Api_model->cek_nim_siakad($nim);

                        if ($data_mhs != null) {

                            $tahunsmtakademik = $this->Api_model->cek_thsmt_akademik()->semester_aktif;
                            $cek_status_aktif_mhs = $this->Api_model->cek_status_aktif_mhs($tahunsmtakademik, $nim);

                            if ($cek_status_aktif_mhs) {

                                $sem_mhs_now = $this->smt_mhs_by_th_smt($data_mhs['TAHUNMSMHS'], $tahunsmtakademik);
                                $get_list_mk = $this->Api_model->get_list_mk_krs($tahunsmtakademik, $kode_jen, $kode_pst, $nim, $sem_mhs_now);

                                //var_dump($get_list_mk);

                                if ($get_list_mk != null) {


                                    $mkkrspecah = $this->krs_format_array_multidimension($get_list_mk);

                                    //var_dump($get_list_mk);

                                    // foreach ($get_list_mk as $value) {
                                    //     if (!array_keys(array_column($mkkrspecah, 'kode_mk'), $value['kode_mk'])) {
                                    //         $item_makul = null;
                                    //         foreach ($get_list_mk as $value2) {
                                    //             if ($value["kode_mk"] == $value2["kode_mk"] ) {
                                    //                 $item_makul[] = ["kode_mk" => $value["kode_mk"], "makul" => $value["makul"], "dosen" => $this->nama_dosen_dg_gelar($value2['nama_dosen'], $value2['gelar_dosen']), "nodos" => $value2['nodos'],  "waktu" => $value2['hari'] . ', ' . $value2['jam'], "kuota" => $value2["kuota"], "jmlh_peserta" => $value2["peserta_terdaftar"], "selected" => $value2["selected"], "issaved" => $value2["selected"], 'isacc' => $value2["isacc"], "sks_mk" => $value2["sks_mk"], "jadwal_hari" => $value2["jadwal_hari"], "jadwal_jam" => $value2["jadwal_jam"], "jadwal_kelas" => $value2["jadwal_kelas"], "jadwal_ruang" => $value2["jadwal_ruang"]];
                                    //             }
                                    //         }
                                    //         $mkkrspecah[] = array("kode_mk" => $value["kode_mk"], "makul" => $value["makul"], "sks_mk" => $value["sks_mk"], "item_jadwal" => $item_makul);
                                    //     }
                                    // }

                                    $success = true;
                                    $message = 'List mata kuliah ditemukan';
                                    $data = $mkkrspecah;

                                    $tgl_pertama_krsmk = tgl_indo_timestamp($waktu_mulai);
                                    $tgl_akhir_krsmk = tgl_indo_timestamp($waktu_selesai);
                                } else {
                                    $success = false;
                                    $message = 'List mata kuliah tidak ditemukan';
                                    $data = null;

                                    $tgl_pertama_krsmk = tgl_indo_timestamp($waktu_mulai);
                                    $tgl_akhir_krsmk = tgl_indo_timestamp($waktu_selesai);
                                }
                            } else {
                                $success = false;
                                $message = "Pengisan KRS hanya bisa dilakukan oleh mahasiswa aktif";
                                $data = null;

                                $tgl_pertama_krsmk = tgl_indo_timestamp($waktu_mulai);
                                $tgl_akhir_krsmk = tgl_indo_timestamp($waktu_selesai);
                            }
                        } else {
                            $success = false;
                            $message = "Nim tidak ditemukan";
                            $data = null;

                            $tgl_pertama_krsmk = tgl_indo_timestamp($waktu_mulai);
                            $tgl_akhir_krsmk = tgl_indo_timestamp($waktu_selesai);
                        }
                    } else {
                        if ($waktu_sekarang < $waktu_mulai) {
                            $success = false;
                            $message = "Periode pengisian KRS belum dimulai, pengisian KRS akan dimulai pada \n " . tgl_indo_timestamp($waktu_mulai);
                            $data = null;

                            $tgl_pertama_krsmk = tgl_indo_timestamp($waktu_mulai);
                            $tgl_akhir_krsmk = tgl_indo_timestamp($waktu_selesai);
                        } else {
                            $success = false;
                            $message = "Periode pengisian KRS sudah selesai, batas akhir pengisian KRS pada \n " . tgl_indo_timestamp($waktu_selesai);
                            $data = null;

                            $tgl_pertama_krsmk = tgl_indo_timestamp($waktu_mulai);
                            $tgl_akhir_krsmk = tgl_indo_timestamp($waktu_selesai);
                        }
                    }
                } else {
                    $success = false;
                    $message = "Periode tanggal KRS tidak sesuai format";
                    $data = null;

                    $tgl_pertama_krsmk = null;
                    $tgl_akhir_krsmk = null;
                }
            } else {
                $success = false;
                $message = "Periode tanggal KRS tidak ditemukan";
                $data = null;

                $tgl_pertama_krsmk = null;
                $tgl_akhir_krsmk = null;
            }
        } else {
            $success = false;

            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $kdpst_err = form_error('kode_pst') ? form_error('kode_pst') . ' ' : null;
            $kdjen_err = form_error('kode_jen') ? form_error('kode_jen') : null;
            $message = $unim_err . $kdpst_err . $kdjen_err;
            $data = null;


            $tgl_pertama_krsmk = null;
            $tgl_akhir_krsmk = null;
        }




        $this->response([
            'success' => $success,
            'message' => $message,
            'waktu_mulai' => $tgl_pertama_krsmk,
            'waktu_selesai' =>  $tgl_akhir_krsmk,
            'data' => $data,
        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    public function krs_format_array_multidimension($get_list_mk)
    {
        $mkkrspecah = array();
        foreach ($get_list_mk as $value) {
            if (!array_keys(array_column($mkkrspecah, 'kode_mk'), $value['kode_mk'])) {
                $item_makul = null;
                foreach ($get_list_mk as $value2) {
                    if ($value["kode_mk"] == $value2["kode_mk"]) {
                        $item_makul[] = ["kode_mk" => $value["kode_mk"], "makul" => $value["makul"], "dosen" => $this->nama_dosen_dg_gelar($value2['nama_dosen'], $value2['gelar_dosen']), "nodos" => $value2['nodos'] ? $value2['nodos'] : '',  "waktu" => $value2['hari'] . ', ' . $value2['jam'], "kuota" => $value2["kuota"], "jmlh_peserta" => $value2["peserta_terdaftar"], "selected" => $value2["selected"], "issaved" => $value2["selected"], 'isacc' => $value2["isacc"], "sks_mk" => $value2["sks_mk"], "jadwal_hari" => $value2["jadwal_hari"], "jadwal_jam" => $value2["jadwal_jam"], "jadwal_kelas" => $value2["jadwal_kelas"], "jadwal_ruang" => $value2["jadwal_ruang"]];
                    }
                }
                $mkkrspecah[] = array("kode_mk" => $value["kode_mk"], "makul" => $value["makul"], "sks_mk" => $value["sks_mk"], "semester_mk" => $value['SEMESTBKMK'], "item_jadwal" => $item_makul);
            }
        }

        return $mkkrspecah;
    }

    public function input_krs_mata_kuliah_post()
    {
        $nim = $this->post('unim');
        $kode_pst = $this->post('kode_pst');
        $kode_jen = $this->post('kode_jen');
        $data_makul = $this->post('data_input_krs_mk');
        $tgl_input = date('Y-m-d H:i:s');

        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('kode_pst', 'Kode Program Studi', 'required');
        $this->form_validation->set_rules('kode_jen', 'Kode Jenjang', 'required');
        $this->form_validation->set_rules('data_input_krs_mk', 'input krs mk', 'required');

        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {

            $conf_key = 'aam_' . $kode_jen . '~' . $kode_pst;
            $get_tgl_input_mk = $this->Api_model->cek_tgl_input_mk($conf_key);


            if ($get_tgl_input_mk != null) {
                $tgl_periode_input_mk = $get_tgl_input_mk['conf_keyval'];

                $pecah_tgl_periode_input_mk = explode('~', '2022-01-26 08:30:00~2022-06-30 23:59:00'); //explode('~',$tgl_periode_input_mk);

                if (count($pecah_tgl_periode_input_mk) == 2) {

                    $waktu_sekarang = time();
                    $waktu_mulai = strtotime($pecah_tgl_periode_input_mk[0]);
                    $waktu_selesai = strtotime($pecah_tgl_periode_input_mk[1]);

                    //$tgl_mulai = date("m-d-Y H:i:s", $waktu_mulai);

                    if ($waktu_sekarang > $waktu_mulai && $waktu_sekarang < $waktu_selesai) {

                        $data_mhs = $this->Api_model->cek_nim_siakad($nim);

                        //var_dump($data_mhs);

                        if ($data_mhs != null) {

                            $tahunsmtakademik = $this->Api_model->cek_thsmt_akademik()->semester_aktif;
                            $cek_status_aktif_mhs = $this->Api_model->cek_status_aktif_mhs($tahunsmtakademik, $nim);

                            if ($cek_status_aktif_mhs) {

                                $sem_mhs_now = $this->smt_mhs_by_th_smt($data_mhs['TAHUNMSMHS'], $tahunsmtakademik);
                                $get_list_mk = $this->Api_model->get_list_mk_krs($tahunsmtakademik, $kode_jen, $kode_pst, $nim, $sem_mhs_now);

                                if ($get_list_mk != null) {
                                    $data_2 = json_decode($data_makul, true);

                                    if ($data_2 != null) {


                                        //buat array_list mk dari databse, untuk perbandingan dengan data yang di post user
                                        $item_makul = null;
                                        foreach ($get_list_mk as $value2) {
                                            $item_makul[] = array("kode_mk" => $value2["kode_mk"], "sks_mk" => $value2["sks_mk"], "jadwal_hari" => $value2["jadwal_hari"], "jadwal_jam" => $value2["jadwal_jam"], "jadwal_kelas" => $value2["jadwal_kelas"], "jadwal_ruang" => $value2["jadwal_ruang"], "nodos" => $value2["nodos"], 'isacc' => $value2["isacc"]);
                                        }

                                        //cek data post list mk dengan array_list_mk dan cek kuota
                                        $validation_kuota = true;
                                        $nama_mk_habis_kuota = null;
                                        $array_input = null;
                                        foreach ($data_2 as $value) {
                                            //error_reporting(0);
                                            $validation_mk = in_array(array("kode_mk" => $value["kode_mk"], "sks_mk" => $value["sks_mk"], "jadwal_hari" => $value["jadwal_hari"], "jadwal_jam" => $value["jadwal_jam"], "jadwal_kelas" => $value["jadwal_kelas"], "jadwal_ruang" => $value["jadwal_ruang"], "nodos" => $value["nodos"], "isacc" => "T"), $item_makul);

                                            //jika nilai validasi tidak sesuai karena tidak ada kesamaan item array maka hentikan
                                            $nama_makul_invalid = null;
                                            if (($validation_mk === false)) {
                                                $nama_makul_invalid = $value["kode_mk"];
                                                break;
                                            } else {
                                                foreach ($get_list_mk as $cek) {
                                                    // cek sisa kuota
                                                    if ($value["kode_mk"] == $cek["kode_mk"] && $value["jadwal_kelas"] == $cek["jadwal_kelas"] && $cek["selected"] != "Y" && (($cek["kuota"] - $cek["peserta_terdaftar"]) <= 0)) {
                                                        $validation_kuota = false;
                                                        $nama_mk_habis_kuota = $value["kode_mk"];

                                                        break;
                                                    }
                                                }
                                            }
                                            $array_input[] = array("nimhs" => $nim, "thsms" => $tahunsmtakademik, "kdjen" => $kode_jen, "kdpst" => $kode_pst, "kdkmk" => $value["kode_mk"], "nodos" => $value["nodos"], "tglinput" => $tgl_input, "sksmk" => $value["sks_mk"], "jadwal_hari" => $value["jadwal_hari"], "jadwal_jam" => $value["jadwal_jam"], "jadwal_kelas" => $value["jadwal_kelas"], "jadwal_ruang" => $value["jadwal_ruang"]);
                                        }


                                        if ($validation_mk === false) {
                                            $get_list_mk_2 = $this->Api_model->get_list_mk_krs($tahunsmtakademik, $kode_jen, $kode_pst, $nim, $sem_mhs_now);
                                            $data = $this->krs_format_array_multidimension($get_list_mk_2);
                                            $success = false;
                                            $message = "Input krs mata kuliah gagal, parameter mata kuliah dengan kode $nama_makul_invalid tidak sesuai atau krs mata kuliah tersebut sudah di acc dosen pembimbing akademik, silahkan refresh data";
                                        } else if ($validation_kuota === false) {
                                            $get_list_mk_2 = $this->Api_model->get_list_mk_krs($tahunsmtakademik, $kode_jen, $kode_pst, $nim, $sem_mhs_now);
                                            $data = $this->krs_format_array_multidimension($get_list_mk_2);
                                            $success = false;
                                            $message = "Input krs mata kuliah gagal, kuota mata kuliah dengan kode $nama_mk_habis_kuota sudah habis";
                                        } else {

                                            $insert_krs_mk = $this->Api_model->input_krs_mata_kuliah($nim, $kode_jen, $kode_pst, $tahunsmtakademik, $array_input);

                                            if ($insert_krs_mk) {
                                                $get_list_mk_2 = $this->Api_model->get_list_mk_krs($tahunsmtakademik, $kode_jen, $kode_pst, $nim, $sem_mhs_now);
                                                $data = $this->krs_format_array_multidimension($get_list_mk_2);
                                                $success = true;
                                                $message = "Input krs mata kuliah berhasil";
                                            } else {
                                                $get_list_mk_2 = $this->Api_model->get_list_mk_krs($tahunsmtakademik, $kode_jen, $kode_pst, $nim, $sem_mhs_now);
                                                $data = $this->krs_format_array_multidimension($get_list_mk_2);
                                                $success = false;
                                                $message = "Input penawaran mata kuliah gagal,terjadi kendala di sistem database";
                                            }
                                        }
                                    } else {
                                        $success = false;
                                        $message = 'parameter mata kuliah tidak dapat diurai';
                                        $data = null;
                                    }
                                } else {
                                    $success = false;
                                    $message = 'List mata kuliah tidak ditemukan';
                                    $data = null;
                                }
                            } else {
                                $success = false;
                                $message = "Input krs mata kuliah hanya bisa dilakukan oleh mahasiswa aktif";
                                $data = null;
                            }
                        } else {
                            $success = false;
                            $message = "Nim tidak ditemukan";
                            $data = null;
                        }
                    } else {
                        if ($waktu_sekarang < $waktu_mulai) {
                            $success = false;
                            $message = "Periode input krs mata kuliah belum dimulai, input krs mata kuliah akan dimulai pada tanggal " . $pecah_tgl_periode_input_mk[0];
                            $data = null;
                        } else {
                            $success = false;
                            $message = "Periode input krs mata kuliah sudah selesai, batas akhir input krs mata kuliah pada tanggal " . $pecah_tgl_periode_input_mk[1];
                            $data = null;
                        }
                    }
                } else {
                    $success = false;
                    $message = "Periode tanggal input krs mata kuliah tidak sesuai format";
                    $data = null;
                }
            } else {
                $success = false;
                $message = "Periode tanggal input krs mata kuliah tidak ditemukan";
                $data = null;
            }
        } else {
            $success = false;

            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $kdpst_err = form_error('kode_pst') ? form_error('kode_pst') . ' ' : null;
            $kdjen_err = form_error('kode_jen') ? form_error('kode_jen') . ' ' : null;
            $kdmk_err = form_error('data_input_krs_mk') ? form_error('data_input_krs_mk') : null;
            $message = $unim_err . $kdpst_err . $kdjen_err . $kdmk_err;
            $data = null;
        }

        // sleep(1);
        $this->response([
            'success' => $success,
            'message' => $message,
            'tgl_input' =>  $tgl_input,
            'data' => $data,

        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    public function input_penawaran_mata_kuliah_post()
    {
        $nim = $this->post('unim');
        $kode_pst = $this->post('kode_pst');
        $kode_jen = $this->post('kode_jen');
        $data_makul = $this->post('data_input_penawaran_mk');
        $tgl_input = date('Y-m-d H:i:s');

        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('kode_pst', 'Kode Program Studi', 'required');
        $this->form_validation->set_rules('kode_jen', 'Kode Jenjang', 'required');
        $this->form_validation->set_rules('data_input_penawaran_mk', 'input penawaran mk', 'required');

        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {

            $conf_key = 'cminatkrs_' . $kode_jen . '~' . $kode_pst;
            $get_tgl_input_mk = $this->Api_model->cek_tgl_input_mk($conf_key);


            if ($get_tgl_input_mk != null) {
                $tgl_periode_input_mk = $get_tgl_input_mk['conf_keyval'];

                $pecah_tgl_periode_input_mk = explode('~', '2022-01-26 08:30:00~2022-06-30 23:59:00'); //explode('~',$tgl_periode_input_mk);

                if (count($pecah_tgl_periode_input_mk) == 2) {

                    $waktu_sekarang = time();
                    $waktu_mulai = strtotime($pecah_tgl_periode_input_mk[0]);
                    $waktu_selesai = strtotime($pecah_tgl_periode_input_mk[1]);

                    //$tgl_mulai = date("m-d-Y H:i:s", $waktu_mulai);

                    if ($waktu_sekarang > $waktu_mulai && $waktu_sekarang < $waktu_selesai) {

                        $data_mhs = $this->Api_model->cek_nim_siakad($nim);

                        //var_dump($data_mhs);

                        if ($data_mhs != null) {

                            $tahunsmtakademik = $this->Api_model->cek_thsmt_akademik()->semester_aktif;
                            $cek_status_aktif_mhs = $this->Api_model->cek_status_aktif_mhs($tahunsmtakademik, $nim);

                            if ($cek_status_aktif_mhs) {
                                $tahunsmtinputmk = $this->Api_model->cek_thsmt_inputmk();
                                $thsmt = $tahunsmtinputmk['conf_keyval'];
                                $sem_mhs_now = $this->smt_mhs_by_th_smt($data_mhs['TAHUNMSMHS'], $thsmt);
                                $get_list_mk = $this->Api_model->get_list_mk_input_mk($thsmt, $kode_jen, $kode_pst, $nim, $sem_mhs_now);


                                if ($get_list_mk != null) {
                                    $data_2 = json_decode($data_makul, true);

                                    if ($data_2 != null) {

                                        $get_jatah_sks = $this->Api_model->get_prodi_jatah_sks($kode_jen, $kode_pst);

                                        if ($get_jatah_sks != null) {
                                            $array_jatah_sks = $get_jatah_sks;
                                        } else {
                                            $array_jatah_sks = array(
                                                ["rentang1" => '3.50', "rentang2" => '4.00', "jatahsks" => '24'],
                                                ["rentang1" => '3.00', "rentang2" => '3.49', "jatahsks" => '22'],
                                                ["rentang1" => '2.50', "rentang2" => '2.99', "jatahsks" => '21'],
                                                ["rentang1" => '2.00', "rentang2" => '2.49', "jatahsks" => '18'],
                                                ["rentang1" => '1.50', "rentang2" => '1.99', "jatahsks" => '16'],
                                                ["rentang1" => '1.00', "rentang2" => '1.49', "jatahsks" => '14'],
                                                ["rentang1" => '0', "rentang2" => '0.99', "jatahsks" => '12'],
                                            );
                                        }


                                        $thsmt_aktif_terakir = $this->Api_model->cek_last_registrasi($nim, $thsmt);
                                        $ips_mhs = $this->Api_model->get_ips_mhs($nim, $thsmt_aktif_terakir['thsms_aktif_terakhir'], $kode_jen, $kode_pst);
                                        $jatah_sks = "12";

                                        foreach ($array_jatah_sks as $val) {
                                            if ($ips_mhs >= $val['rentang1'] && $ips_mhs <= $val['rentang2']) {
                                                $jatah_sks = $val['jatahsks'];
                                                break;
                                            }
                                        }

                                        $jumlah_sks_input = array_sum(array_column($data_2, 'sks_mk'));

                                        if ($jumlah_sks_input <= $jatah_sks) {

                                            //buat array_list_mk_bersyarat
                                            $item_makul = null;
                                            foreach ($get_list_mk as $value2) {

                                                if ($value2["kdkmksyarat"] != null) {
                                                    $variabel = $value2['KDJENTBKMK'] . $value2['KDPSTTBKMK'] . $value2['KDKMKTBKMK'];
                                                    $get_nilai_mk_syarat = $this->Api_model->get_nilai_mk_syarat($variabel, $nim, $kode_jen, $kode_pst, $thsmt);

                                                    $status = "ms";

                                                    foreach ($get_nilai_mk_syarat as $kuy) {
                                                        if ($kuy['syarat'] != "ms") {
                                                            $status = "tms";
                                                        }
                                                    }


                                                    $item_makul[] = ["kode_mk" => $value2['KDKMKTBKMK'], "sks_mk" => $value2['SKSMKTBKMK'], "keterangan" => $status];
                                                } else {
                                                    $item_makul[] = ["kode_mk" => $value2['KDKMKTBKMK'], "sks_mk" => $value2['SKSMKTBKMK'], "keterangan" => "ms"];
                                                }
                                            }


                                            //$item_makul = array(["kode_mk" => "2-KKIB01", "sks_mk"=>"2","keterangan"=>"ms"],["kode_mk" => "4-KKIE01", "sks_mk"=>"3","keterangan"=>"tms"]);

                                            //cek data post list mk dengan array_lis_mk_bersyarat
                                            foreach ($data_2 as $value) {
                                                error_reporting(0);
                                                $validation_mk = in_array(array("kode_mk" => $value["kode_mk"], "sks_mk" => $value["sks_mk"], "keterangan" => "ms"), $item_makul);

                                                //jika nilai validasi tidak sesuai karena tidak ada kesamaan item array maka hentikan
                                                if (($validation_mk === false)) {
                                                    break;
                                                }
                                            }

                                            if ($validation_mk === false) {
                                                $data = null;
                                                $success = false;
                                                $message = "Input penawaran mata kuliah gagal, parameter yang dikirim tidak sesuai";
                                            } else {

                                                $array_input = null;


                                                foreach ($data_2 as $value) {
                                                    $array_input[] = array("nimhs" => $nim, "thsms" => $thsmt, "kdjen" => $kode_jen, "kdpst" => $kode_pst, "kdkmk" => $value["kode_mk"], "tglinput" => $tgl_input, "sksmk" => $value["sks_mk"]);
                                                }

                                                $insert_pmk = $this->Api_model->input_penawaran_mata_kuliah($nim, $kode_jen, $kode_pst, $thsmt, $array_input);

                                                if ($insert_pmk) {
                                                    $data = $array_input;
                                                    $success = true;
                                                    $message = "Input penawaran mata kuliah berhasil";
                                                } else {
                                                    $data = $array_input;
                                                    $success = false;
                                                    $message = "Input penawaran mata kuliah gagal,terjadi kendala di sistem database";
                                                }
                                            }
                                        } else {
                                            $success = false;
                                            $message = 'Input penawaran mata kuliah gagal, jumlah sks melebihi ketentuan';
                                            $data = null;
                                        }
                                        //var_dump($jumlah_sks_input);

                                    } else {
                                        $success = false;
                                        $message = 'parameter mata kuliah tidak dapat diurai';
                                        $data = null;
                                    }
                                } else {
                                    $success = false;
                                    $message = 'List mata kuliah tidak ditemukan';
                                    $data = null;
                                }
                            } else {
                                $success = false;
                                $message = "Input penawaran mata kuliah hanya bisa dilakukan oleh mahasiswa aktif";
                                $data = null;
                            }
                        } else {
                            $success = false;
                            $message = "Nim tidak ditemukan";
                            $data = null;
                        }
                    } else {
                        if ($waktu_sekarang < $waktu_mulai) {
                            $success = false;
                            $message = "Periode input penawaran mata kuliah belum dimulai, input penawaran mata kuliah akan dimulai pada tanggal " . $pecah_tgl_periode_input_mk[0];
                            $data = null;
                        } else {
                            $success = false;
                            $message = "Periode input penawaran mata kuliah sudah selesai, batas akhir input penawaran mata kuliah pada tanggal " . $pecah_tgl_periode_input_mk[1];
                            $data = null;
                        }
                    }
                } else {
                    $success = false;
                    $message = "Periode tanggal input penawaran mata kuliah tidak sesuai format";
                    $data = null;
                }
            } else {
                $success = false;
                $message = "Periode tanggal input penawaran mata kuliah tidak ditemukan";
                $data = null;
            }
        } else {
            $success = false;

            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $kdpst_err = form_error('kode_pst') ? form_error('kode_pst') . ' ' : null;
            $kdjen_err = form_error('kode_jen') ? form_error('kode_jen') . ' ' : null;
            $kdmk_err = form_error('data_input_penawaran_mk') ? form_error('data_input_penawaran_mk') : null;
            $message = $unim_err . $kdpst_err . $kdjen_err . $kdmk_err;
            $data = null;
        }

        sleep(2);
        $this->response([
            'success' => $success,
            'message' => $message,
            'tgl_input' =>  $tgl_input,
            'data' => $data,

        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    public function khs_post()
    {

        $semester = $this->post('selected_semester');
        $nim = $this->post('unim');
        $kdjen = $this->post('kdjen');
        $kdpst = $this->post('kdpst');

        $this->form_validation->set_rules('selected_semester', 'Semester', 'required');
        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('kdjen', 'Kode Program Studi', 'required');
        $this->form_validation->set_rules('kdpst', 'Kode Jenjang', 'required');


        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {
            $data_mhs = $this->Api_model->cek_nim_siakad($nim);

            //var_dump($data_mhs);

            //var_dump($data_mhs);
            if ($data_mhs != null) {
                $thsmt_selected = $this->th_smt_mhs_by_smt($data_mhs['SMAWLMSMHS'], $semester);

                $data_khs = $this->Api_model->get_data_khs($thsmt_selected, $nim, $kdjen, $kdpst);

                if ($data_khs != null) {
                    $success = true;
                    $data = $data_khs;
                    $message = 'Data KHS ditemukan';
                } else {
                    $success = false;
                    $data = null;
                    $message = 'Data KHS tidak ditemukan';
                }
            } else {
                $success = false;
                $message = 'Nim mahasiswa tidak ditemukan';
                $data = null;
            }
        } else {
            $success = false;

            $sem_err = form_error('selected_semester') ? form_error('selected_semester') . ' ' : null;
            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $kdpst_err = form_error('kdpst') ? form_error('kdpst') . ' ' : null;
            $kdjen_err = form_error('kdjen') ? form_error('kdjen')  : null;

            $message = $sem_err . $unim_err . $kdpst_err . $kdjen_err;
            $data = null;
        }


        // var_dump($get_data_lokasi);

        // $data_khs_mhs_3 = array(
        //     ["makul" => "Filsafat Ilmu", "sks" => 3, "kelas" => "Kelas A.7", "nilaihuruf" => "A", "nilaiangka" => 4.0],
        //     ["makul" => "Bahasa Arab I", "sks" => 4, "kelas" => "Kelas A.7", "nilaihuruf" => "A-", "nilaiangka" => 3.5],
        //     ["makul" => "Hadis", "sks" => 3, "kelas" => "Kelas A.7", "nilaihuruf" => "A", "nilaiangka" => 4.0],
        //     ["makul" => "Nahwu", "sks" => 2, "kelas" => "Kelas A.7", "nilaihuruf" => "A-", "nilaiangka" => 3.5],
        //     ["makul" => "Bahasa Indonesia", "sks" => 4, "kelas" => "Kelas A.7", "nilaihuruf" => "A", "nilaiangka" => 4.0],
        //     ["makul" => "Bahasa Inggris", "sks" => 4, "kelas" => "Kelas A.7", "nilaihuruf" => "A-", "nilaiangka" => 3.5],
        //     ["makul" => "Sejarah Peradaban Islam", "sks" => 2, "kelas" => "Kelas A.7", "nilaihuruf" => "A", "nilaiangka" => 4.0],
        //     ["makul" => "Pendidikan Agama", "sks" => 2, "kelas" => "Kelas A.7", "nilaihuruf" => "A-", "nilaiangka" => 3.5]
        // );

        // $data_khs_mhs_2 = array(
        //     ["makul" => "Desain Web", "sks" => 3, "kelas" => "Kelas A.7", "nilaihuruf" => "B", "nilaiangka" => 3.0],
        //     ["makul" => "Pemprograman Mobile", "sks" => 2, "kelas" => "Kelas A.7", "nilaihuruf" => "A-", "nilaiangka" => 3.5],
        //     ["makul" => "Database", "sks" => 3, "kelas" => "Kelas A.7", "nilaihuruf" => "A", "nilaiangka" => 4.0],
        //     ["makul" => "Kalkulus", "sks" => 2, "kelas" => "Kelas A.7", "nilaihuruf" => "A-", "nilaiangka" => 3.5],
        //     ["makul" => "Aljabar Linier dan Matrik", "sks" => 4, "kelas" => "Kelas A.7", "nilaihuruf" => "A", "nilaiangka" => 4.0],
        //     ["makul" => "Manajemen OTODA", "sks" => 2, "kelas" => "Kelas A.7", "nilaihuruf" => "A", "nilaiangka" => 4.0],
        //     ["makul" => "Pengantar Ilmu Politik", "sks" => 1, "kelas" => "Kelas A.7", "nilaihuruf" => "B+", "nilaiangka" => 3.25]
        // );

        // $data_khs_mhs_1 = array(
        //     ["makul" => "Data Mining", "sks" => 4, "kelas" => "Kelas A.7", "nilaihuruf" => "B", "nilaiangka" => 3.0],
        //     ["makul" => "Bahasa Inggris I", "sks" => 2, "kelas" => "Kelas A.7", "nilaihuruf" => "A-", "nilaiangka" => 3.5],
        //     ["makul" => "Bahasa Indonesia II", "sks" => 3, "kelas" => "Kelas A.7", "nilaihuruf" => "A", "nilaiangka" => 4.0],
        //     ["makul" => "Matematika Diskrit", "sks" => 2, "kelas" => "Kelas A.7", "nilaihuruf" => "A-", "nilaiangka" => 3.5],
        //     ["makul" => "Database Lanjutan", "sks" => 2, "kelas" => "Kelas A.7", "nilaihuruf" => "A", "nilaiangka" => 4.0],
        //     ["makul" => "Kapita Selekta", "sks" => 1, "kelas" => "Kelas A.7", "nilaihuruf" => "A", "nilaiangka" => 4.0],
        //     ["makul" => "Manajemen Resiko", "sks" => 1, "kelas" => "Kelas A.7", "nilaihuruf" => "B+", "nilaiangka" => 3.25]
        // );


        // $message = 'Data KHS ditemukan';
        // if ($semester == 1) {
        //     $data_khs = $data_khs_mhs_1;
        // } else if ($semester == 2) {
        //     $data_khs = $data_khs_mhs_2;
        // } else if ($semester == 3) {
        //     $data_khs = $data_khs_mhs_3;
        // } else {
        //     $data_khs = null;
        //     $message = 'Data KHS tidak ditemukan';
        // }

        // sleep(2);
        $this->response([
            'success' => $success,
            'message' => $message,
            'semester' => $semester,
            'data' => $data,

        ], REST_Controller_Smartmobile::HTTP_OK);
    }


    public function krs_get()
    {

        $nim = $this->get('unim');
        $kdjen = $this->get('kdjen');
        $kdpst = $this->get('kdpst');

        $querylink = array("unim" => $nim, "kdjen" => $kdjen, "kdpst" => $kdpst);
        $this->form_validation->set_data($querylink);


        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('kdjen', 'Kode Program Studi', 'required');
        $this->form_validation->set_rules('kdpst', 'Kode Jenjang', 'required');


        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {
            $data_mhs = $this->Api_model->cek_nim_siakad($nim);

            //var_dump($data_mhs);

            //var_dump($data_mhs);
            if ($data_mhs != null) {
                $tahunsmtakademik = $this->Api_model->cek_thsmt_akademik()->semester_aktif;



                $get_jatah_sks = $this->Api_model->get_prodi_jatah_sks($kdjen, $kdpst);

                if ($get_jatah_sks != null) {
                    $array_jatah_sks = $get_jatah_sks;
                } else {
                    $array_jatah_sks = array(
                        ["rentang1" => '3.50', "rentang2" => '4.00', "jatahsks" => '24'],
                        ["rentang1" => '3.00', "rentang2" => '3.49', "jatahsks" => '22'],
                        ["rentang1" => '2.50', "rentang2" => '2.99', "jatahsks" => '21'],
                        ["rentang1" => '2.00', "rentang2" => '2.49', "jatahsks" => '18'],
                        ["rentang1" => '1.50', "rentang2" => '1.99', "jatahsks" => '16'],
                        ["rentang1" => '1.00', "rentang2" => '1.49', "jatahsks" => '14'],
                        ["rentang1" => '0', "rentang2" => '0.99', "jatahsks" => '12'],
                    );
                }


                $thsmt_aktif_terakir = $this->Api_model->cek_last_registrasi($nim, $tahunsmtakademik);
                $ips_mhs = $this->Api_model->get_ips_mhs($nim, $thsmt_aktif_terakir['thsms_aktif_terakhir'], $kdjen, $kdpst);


                $semester_berjalan = $this->smt_mhs_by_th_smt($data_mhs['TAHUNMSMHS'], $tahunsmtakademik);

                if ($semester_berjalan == 1) {
                    $jatah_sks = "24";
                } else {
                    $jatah_sks = "12";
                }



                $smt_aktif_sblmya = $thsmt_aktif_terakir['thsms_aktif_terakhir'];

                foreach ($array_jatah_sks as $val) {
                    if ($ips_mhs >= $val['rentang1'] && $ips_mhs <= $val['rentang2']) {
                        $jatah_sks = $val['jatahsks'];
                        break;
                    }
                }

                $data_krs = $this->Api_model->get_data_krs($tahunsmtakademik, $nim, $kdjen, $kdpst);

                if ($data_krs != null) {

                    $item_krs = array();
                    foreach ($data_krs as $value2) {
                        $item_krs[] = ["kode_mk" => $value2['kode_mk'], "paket_semester" => $value2['SEMESTBKMK'], "kelas" => $value2["kelas"], "makul" => $value2['makul'], "sks" => $value2['sks'], "ruang" => $value2['ruang'], "waktu" => $value2['hari'] . ', ' . $value2['jam'], "dosen" => $this->nama_dosen_dg_gelar($value2['dosen'], $value2['gelar']), "ruang" => $value2['ruang']];
                    }
                    $success = true;
                    $data = $item_krs;
                    $message = 'Data KRS ditemukan';
                } else {
                    $success = false;
                    $data = null;
                    $message = 'Data KRS tidak ditemukan';
                }
            } else {
                $success = false;
                $message = 'Nim mahasiswa tidak ditemukan';
                $jatah_sks = "0";
                $semester_berjalan = "0";
                $data = null;
            }
        } else {
            $success = false;

            $sem_err = form_error('selected_semester') ? form_error('selected_semester') . ' ' : null;
            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $kdpst_err = form_error('kdpst') ? form_error('kdpst') . ' ' : null;
            $kdjen_err = form_error('kdjen') ? form_error('kdjen')  : null;

            $jatah_sks = "0";
            $semester_berjalan = "0";
            $message = $sem_err . $unim_err . $kdpst_err . $kdjen_err;
            $data = null;
        }


        // sleep(2);
        $this->response([
            'success' => $success,
            'message' => $message,
            'jatah_sks' => $jatah_sks,
            'semester_berjalan' => "$semester_berjalan",
            'data' => $data,
        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    public function tagihanmhs_post()
    {
        $nim = $this->post('unim');
        $kdjen = $this->post('kdjen');
        $kdpst = $this->post('kdpst');


        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('kdjen', 'Kode Program Studi', 'required');
        $this->form_validation->set_rules('kdpst', 'Kode Jenjang', 'required');


        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {

            $data_mhs = $this->Api_model->cek_nim_siakad($nim);

            //var_dump($data_mhs);

            if ($data_mhs != null) {
                $tahunsmtinputmk = $this->Api_model->cek_thsmt_keu();
                $thsmt = $tahunsmtinputmk->semester_aktif;


                $sem_mhs_now = $this->smt_mhs_by_th_smt($data_mhs['TAHUNMSMHS'], $thsmt);


                $semester_cuti_mhs = null;
                $info_cuti = $this->Api_model->get_cuti($nim);
                foreach ($info_cuti as $val) {
                    $tampung_semester_cuti = $val->THSMSTRLSM;
                    $semester_cuti_mhs[] = $this->smt_mhs_by_th_smt($data_mhs['TAHUNMSMHS'], $tampung_semester_cuti);
                }

                $gettagihan = $this->Api_model->get_tagihan($nim, $sem_mhs_now, $semester_cuti_mhs);

                // $gettagihan = array(
                //     ["semester" => "2", "namatagihan" => "UKT", "jumlah" => 2500000],
                //     ["semester" => "3", "namatagihan" => "UKT", "jumlah" => 2500000],
                //     ["semester" => "3", "namatagihan" => "Biaya Her Registrasi", "jumlah" => 100000],
                //     ["semester" => "2", "namatagihan" => "UKT", "jumlah" => 2500000],
                //     ["semester" => "3", "namatagihan" => "UKT", "jumlah" => 2500000],
                //     ["semester" => "3", "namatagihan" => "Biaya Her Registrasi", "jumlah" => 100000],
                //     ["semester" => "2", "namatagihan" => "UKT", "jumlah" => 2500000],
                //     ["semester" => "3", "namatagihan" => "UKT", "jumlah" => 2500000],
                //     ["semester" => "3", "namatagihan" => "Biaya Her Registrasi", "jumlah" => 100000],
                //     ["semester" => "2", "namatagihan" => "UKT", "jumlah" => 2500000],
                //     ["semester" => "3", "namatagihan" => "UKT", "jumlah" => 2500000],
                //     ["semester" => "3", "namatagihan" => "Biaya Her Registrasi", "jumlah" => 100000],
                //     // ["semester" => "4", "namatagihan" => "Biaya Cuti", "jumlah" => 100000],
                // );

                if ($gettagihan != null) {

                    $tagihanpecah = array();
                    foreach ($gettagihan as $value) {
                        if (!array_keys(array_column($tagihanpecah, 'semester'), $value['semester'])) {
                            $item_tagihan = null;
                            foreach ($gettagihan as $value2) {
                                if ($value["semester"] == $value2["semester"]) {
                                    $item_tagihan[] = ["namatagihan" => $value2['namatagihan'], "jumlah" => $value2['jumlah']];
                                }
                            }
                            $tagihanpecah[] = array("semester" => $value["semester"], "item_tagihan" => $item_tagihan);
                        }
                    }

                    $success = true;
                    $data = $tagihanpecah;
                    $message = "Tagihan ditemukan";
                } else {
                    $success = true;
                    $message = "Tidak ditemukan tagihan";
                    $data = null;
                }
            } else {
                $success = false;
                $message = 'Nim mahasiswa tidak ditemukan';
                $data = null;
            }
        } else {
            $success = false;

            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $kdpst_err = form_error('kdpst') ? form_error('kdpst') . ' ' : null;
            $kdjen_err = form_error('kdjen') ? form_error('kdjen')  : null;

            $message = $unim_err . $kdpst_err . $kdjen_err;
            $data = null;
        }


        sleep(1);

        $this->response([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    public function rekappembayaran_post()
    {
        $nim = $this->post('unim');
        $kdjen = $this->post('kdjen');
        $kdpst = $this->post('kdpst');

        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('kdjen', 'Kode Program Studi', 'required');
        $this->form_validation->set_rules('kdpst', 'Kode Jenjang', 'required');


        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {
            // $getrekap = array(
            //     ["semester" => "1", "namatagihan" => "Registrasi PBAK", "jumlah" => 200000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "UKT", "jumlah" => 2500000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "Biaya Her Registrasi", "jumlah" => 100000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "Registrasi PBAK", "jumlah" => 200000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "UKT", "jumlah" => 2500000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "Biaya Her Registrasi", "jumlah" => 100000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "Registrasi PBAK", "jumlah" => 200000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "UKT", "jumlah" => 2500000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "Biaya Her Registrasi", "jumlah" => 100000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "Registrasi PBAK", "jumlah" => 200000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "UKT", "jumlah" => 2500000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "Biaya Her Registrasi", "jumlah" => 100000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "Registrasi PBAK", "jumlah" => 200000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "UKT", "jumlah" => 2500000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "Biaya Her Registrasi", "jumlah" => 100000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "Registrasi PBAK", "jumlah" => 200000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "UKT", "jumlah" => 2500000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "Biaya Her Registrasi", "jumlah" => 100000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "Registrasi PBAK", "jumlah" => 200000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "UKT", "jumlah" => 2500000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     ["semester" => "1", "namatagihan" => "Biaya Her Registrasi", "jumlah" => 100000, "tanggalbayar" => "2019-01-04 08:00:00", "noref" => "56XCFD"],
            //     // ["semester" => "4", "namatagihan" => "Biaya Cuti", "jumlah" => 100000],
            // );

            $getrekap = $this->Api_model->get_rekap_bayar_tghn_mhs($nim, $kdjen, $kdpst);



            if ($getrekap != null) {
                $data_rekap = array();
                foreach ($getrekap as $value) {
                    $keterangan = json_decode($value["keterangan"], true);
                    if ($keterangan != null) {
                        if (isset($keterangan["kodeBank"])) {
                            $bankname = $keterangan["kodeBank"];
                        } else {
                            $bankname = $value['melalui'];
                        }
                    } else {
                        $bankname = $value['melalui'];
                    }
                    $data_rekap[] = array("semester" => $value["semester"], "namatagihan" => $value["namatagihan"], "jumlah" => $value["jumlah"], "tanggalbayar" => $value["tanggalbayar"], "melalui" => $bankname);
                }

                $success = true;
                $message = "Rekap Pembayaran Ditemukan";
                $data = $data_rekap;
            } else {
                $success = false;
                $message = "Rekap Pembayaran Tidak Ditemukan";
                $data = null;
            }
        } else {
            $success = false;

            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $kdpst_err = form_error('kdpst') ? form_error('kdpst') . ' ' : null;
            $kdjen_err = form_error('kdjen') ? form_error('kdjen')  : null;

            $message = $unim_err . $kdpst_err . $kdjen_err;
            $data = null;
        }


        sleep(1);

        $this->response([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    public function tatacarapembayaran_post()
    {
        $nim = $this->post("unim");

        $data_tata_cara = array(
            ["nama_metode" => "ATM Bank Jateng", "norek" => $nim, "deskripsi" => "Hanya merima dari Bank Jateng / Bank Jateng Syariah", "link_logo" => "https://upload.wikimedia.org/wikipedia/id/thumb/c/c4/Bank_Jateng_logo.svg/1200px-Bank_Jateng_logo.svg.png", "tata_cara" => '<p><strong> Melalui Mesin ATM BANK JATENG </strong> </p><ol style=" padding-left: 1.2em; list-style-type: decimal;"><li style="padding-bottom:0.3em">Masukkan kartu ke mesin ATM BANK JATENG Syariah / BANK JATENG</li><li style="padding-bottom:0.3em">Masukkan PIN</li><li style="padding-bottom:0.3em">Pilih Menu Pembayaran</li><li style="padding-bottom:0.3em">Pilih Menu UNIVERSITAS</li><li style="padding-bottom:0.3em">Pilih Menu NOMOR INDUK EDUKASI untuk memasukkan KODEBAYAR</li><li style="padding-bottom:0.3em">Masukkan kode Institusi IAIN SALATIGA (065) kemudian tekan BENAR</li><li style="padding-bottom:0.3em">Masukkan nomor induk mahasiswa <strong>(' . $nim . ')</strong> kemudian tekan LANJUTKAN</li><li style="padding-bottom:0.3em">Pilih jenis rekening yang Anda gunakan.</li><li style="padding-bottom:0.3em">Tekan tombol BAYAR TAGIHAN</li><li style="padding-bottom:0.3em">Tekan YA, simpan slip transaksi sebagai bukti pembayaran</li></ol>'],
            ["nama_metode" => "ATM Bank Syariah Indonesia", "norek" => $nim, "deskripsi" => "Hanya merima dari Bank Syariah Indonesia", "link_logo" => "https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/Bank_Syariah_Indonesia.svg/330px-Bank_Syariah_Indonesia.svg.png", "tata_cara" => '<p><strong> Melalui Mesin ATM BANK BSI </strong> </p><ol style=" padding-left: 1.2em; list-style-type: decimal;"><li style="padding-bottom:0.3em">Masukkan kartu ke mesin ATM BANK BSI</li><li style="padding-bottom:0.3em">Masukkan PIN</li><li style="padding-bottom:0.3em">Pilih Menu Pembayaran</li><li style="padding-bottom:0.3em">Pilih Menu UNIVERSITAS</li><li style="padding-bottom:0.3em">Pilih Menu NOMOR INDUK EDUKASI untuk memasukkan KODEBAYAR</li><li style="padding-bottom:0.3em">Masukkan kode Institusi IAIN SALATIGA (065) kemudian tekan BENAR</li><li style="padding-bottom:0.3em">Masukkan nomor induk mahasiswa <strong>(' . $nim . ')</strong> kemudian tekan LANJUTKAN</li><li style="padding-bottom:0.3em">Pilih jenis rekening yang Anda gunakan.</li><li style="padding-bottom:0.3em">Tekan tombol BAYAR TAGIHAN</li><li style="padding-bottom:0.3em">Tekan YA, simpan slip transaksi sebagai bukti pembayaran</li></ol>'],
            ["nama_metode" => "ATM Bersama", "norek" => '44065' . $nim, "deskripsi" => "Pembayaran ini akan ditransfer ke rekening Bank Jateng Syariah IAIN Salatiga", "link_logo" => "https://upload.wikimedia.org/wikipedia/id/e/e8/ATM_Bersama_2016.png", "tata_cara" => '<p><strong> Transfer Dari Bank Lain Dengan Jaringan ATM Bersama/Prima Ke VA BANK JATENG Syariah</strong> </p><ol style=" padding-left: 1.2em; list-style-type: decimal;"><li style="padding-bottom:0.3em">Masukkan kartu ke mesin ATM Bersama/Prima</li><li style="padding-bottom:0.3em">Masukkan PIN</li><li style="padding-bottom:0.3em">Pilih menu "Transfer"</li><li style="padding-bottom:0.3em">Pilih "Transfer ke Bank Lain"</li><li style="padding-bottom:0.3em">Masukkan kode bank JATENG (<strong>113</strong>) diikuti Nomor VA <strong>(44065' . $nim . ')</strong></li><li style="padding-bottom:0.3em">Masukkan nominal transfer <strong></strong>. Nominal yang berbeda tidak dapat diproses</li> <li style="padding-bottom:0.3em">Pada layar konfirmasi, tekan tombol "Ya" bila data sudah benar untuk melanjutkan transaksi</li><li style="padding-bottom:0.3em">Transaksi selesai, simpan slip transaksi sebagai bukti pembayaran</li></ol>']
        );

        sleep(2);
        $this->response([
            'success' => true,
            'message' => "Tata cara pembayaran ditemukan",
            'data' => $data_tata_cara,
        ], REST_Controller_Smartmobile::HTTP_OK);
    }


    // public function authenticationmhs_post()
    // {
    //     $username = $this->post('unim');
    //     $password = $this->post('upassword');

    //     $this->form_validation->set_rules('unim', 'Nim', 'required');
    //     $this->form_validation->set_rules('upassword', 'Passwrod', 'required');
    //     $this->form_validation->set_message('required', '%s tidak valid');
    //     $this->form_validation->set_error_delimiters('', '');

    //     if ($this->form_validation->run() == true) {
    //         $cek_auth_login = $this->Api_model->check_user_mhs($username, $password);

    //         if ($cek_auth_login != null) {
    //             $data_mhs = $this->Api_model->get_data_mhs($username);

    //             $smstr_berjalan = $this->Api_model->cek_thsmt_akademik();
    //             $semester_berjalan = isset($smstr_berjalan->semester_aktif) ? $smstr_berjalan->semester_aktif : '';

    //             $semester_mhs = $this->smt_mhs_by_th_smt($data_mhs['tahunms'], $semester_berjalan);


    //             $cek_status_aktif_mhs = $this->Api_model->cek_status_aktif_mhs($semester_berjalan, $username);
    //             if ($data_mhs['status'] == "C" || $data_mhs['status'] == "A" || $data_mhs['status'] == "N") {

    //                 if ($cek_status_aktif_mhs) {
    //                     $status = "A";
    //                 } else {
    //                     $cek_cuti_mhs = $this->Api_model->get_cuti_mhs($username, $semester_berjalan);

    //                     if ($cek_cuti_mhs) {
    //                         $status = "C";
    //                     } else {
    //                         $status = "N";
    //                     }
    //                 }
    //             } else {
    //                 $status = $data_mhs['status'];
    //             }

    //             //cek sks ditempuh
    //             //var_dump($data_mhs['angkatan']);
    //             $get_sks_belum_terekap = $this->Api_model->get_sks_ipk_kumulatif($username);
    //             $sks_kumulatif = $get_sks_belum_terekap['jumlah_sks'] ?  $get_sks_belum_terekap['jumlah_sks'] : 0;
    //             $ipk_kumulatif = $get_sks_belum_terekap['jumlah_ipk'] ?  $get_sks_belum_terekap['jumlah_ipk'] : 0;

    //             if ($data_mhs['ISADDEMAIL'] == "true") {
    //                 $isaddemail = true;
    //             } else {
    //                 $isaddemail = false;
    //             }

    //             if ($data_mhs['EMAILVERIFICATION'] == "true") {
    //                 $emailverif = true;
    //             } else {
    //                 $emailverif = false;
    //             }


    //             $merger_datamhs_sem = array(
    //                 "nim" => $data_mhs['nim'],
    //                 "kodefakultas" => $data_mhs['kodefakultas'],
    //                 "kodepst" => $data_mhs['kodepst'],
    //                 "kodejen" => $data_mhs['kodejen'],
    //                 "nama" => $data_mhs['nama'],
    //                 "fakultas" => $data_mhs['fakultas'],
    //                 "programstudi" => $data_mhs['programstudi'],
    //                 "semester" =>  $semester_mhs,
    //                 "ipkkumulatif" => $ipk_kumulatif,
    //                 "skstempuh" => $sks_kumulatif,
    //                 "angkatan" => $data_mhs['angkatan'],
    //                 "jenjang" => $data_mhs['jenjang'],
    //                 "telp" => $data_mhs['telp'],
    //                 "status" => $status,
    //                 "isaddemail" => $isaddemail,
    //                 "emailverifycation" => $emailverif,
    //                 "email" => $data_mhs['EMAIL']
    //             );

    //             sleep(1);
    //             $this->response([
    //                 'success' => true,
    //                 'message' => 'Data MHS ditemukan',
    //                 'data' => $merger_datamhs_sem,
    //             ], REST_Controller_Smartmobile::HTTP_OK);
    //         } else {
    //             $this->response([
    //                 'success' => false,
    //                 'message' => 'Username atau Password salah, Silahkan periksa kembali ',
    //                 'data' => null
    //             ], REST_Controller_Smartmobile::HTTP_OK);
    //         }
    //     } else {
    //         $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
    //         $upass_err = form_error('upassword') ? form_error('upassword') : null;


    //         $this->response([
    //             'success' => false,
    //             'message' => $unim_err . $upass_err,
    //             'data' => null
    //         ], REST_Controller_Smartmobile::HTTP_OK);
    //     }




    //     // $data_login = array(["nim" => "14118431", "password" => "12345"]);
    //     // $data_mhs = array("nim" => "14118431", "kodefakultas" => "1ADF", "kodepst" => "2FD", "nama" => "maulana ayub dwi saputra", "fakultas" => "Fakultas Dakwah", "programstudi" => "Komunikasi Penyiaran Islam", "semester" => 2, "ipkkumulatif" => "3,5", "skstempuh" => 56);
    //     // if ($username == $data_login[0]["nim"] && $password == $data_login[0]["password"]) {
    // }

    public function authenticationmhs_post()
    {
        $username_post = $this->post('unim');
        $password_post = $this->post('upassword');
        $iddevice_post = $this->post('deviceid');
        $devicename_post = $this->post('devicename');



        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('upassword', 'Passwrod', 'required');
        $this->form_validation->set_rules('deviceid', 'ID Perangkat', 'required');
        $this->form_validation->set_rules('devicename', 'Nama Perangkat', 'required');
        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {


            $username = BniEnc::decrypt_string($username_post, $this->cid_app(), $this->cis_app()); //$username_post;
            $password = BniEnc::decrypt_string($password_post, $this->cid_app(), $this->cis_app()); //$password_post;
            $iddevice = BniEnc::decrypt_string($iddevice_post, $this->cid_app(), $this->cis_app()); //$iddevice_post;
            $devicename = BniEnc::decrypt_string($devicename_post, $this->cid_app(), $this->cis_app()); //$devicename_post;
            $kodeinstruksi = BniEnc::decrypt_string($this->post("resyncrondevice"), $this->cid_app(), $this->cis_app()); //$this->post("resyncrondevice");

            if ($username != null && $password != null && $iddevice != null && $devicename != null && $kodeinstruksi != null) {
                $cek_auth_login = $this->Api_model->check_user_mhs($username, $password);

                if ($cek_auth_login != null) {


                    $data_mhs = $this->Api_model->get_data_mhs($username);

                    $smstr_berjalan = $this->Api_model->cek_thsmt_akademik();
                    $semester_berjalan = isset($smstr_berjalan->semester_aktif) ? $smstr_berjalan->semester_aktif : '';

                    $semester_mhs = $this->smt_mhs_by_th_smt($data_mhs['tahunms'], $semester_berjalan);


                    $cek_status_aktif_mhs = $this->Api_model->cek_status_aktif_mhs($semester_berjalan, $username);
                    if ($data_mhs['status'] == "C" || $data_mhs['status'] == "A" || $data_mhs['status'] == "N") {

                        if ($cek_status_aktif_mhs) {
                            $status = "A";
                        } else {
                            $cek_cuti_mhs = $this->Api_model->get_cuti_mhs($username, $semester_berjalan);

                            if ($cek_cuti_mhs) {
                                $status = "C";
                            } else {
                                $status = "N";
                            }
                        }
                    } else {
                        $status = $data_mhs['status'];
                    }

                    //cek sks ditempuh
                    //var_dump($data_mhs['angkatan']);
                    $get_sks_belum_terekap = $this->Api_model->get_sks_ipk_kumulatif($username);
                    $sks_kumulatif = $get_sks_belum_terekap['jumlah_sks'] ?  $get_sks_belum_terekap['jumlah_sks'] : 0;
                    $ipk_kumulatif = $get_sks_belum_terekap['jumlah_ipk'] ?  $get_sks_belum_terekap['jumlah_ipk'] : 0;

                    if ($data_mhs['ISADDEMAIL'] == "true") {
                        $isaddemail = true;
                    } else {
                        $isaddemail = false;
                    }

                    if ($data_mhs['EMAILVERIFICATION'] == "true") {
                        $emailverif = true;
                    } else {
                        $emailverif = false;
                    }


                    $merger_datamhs_sem = array(
                        "nim" => $data_mhs['nim'],
                        "kodefakultas" => $data_mhs['kodefakultas'],
                        "kodepst" => $data_mhs['kodepst'],
                        "kodejen" => $data_mhs['kodejen'],
                        "nama" => $data_mhs['nama'],
                        "fakultas" => $data_mhs['fakultas'],
                        "programstudi" => $data_mhs['programstudi'],
                        "semester" =>  $semester_mhs,
                        "ipkkumulatif" => $ipk_kumulatif,
                        "skstempuh" => $sks_kumulatif,
                        "angkatan" => $data_mhs['angkatan'],
                        "jenjang" => $data_mhs['jenjang'],
                        "telp" => $data_mhs['telp'],
                        "status" => $status,
                        "isaddemail" => $isaddemail,
                        "emailverifycation" => $emailverif,
                        "email" => $data_mhs['EMAIL']
                    );

                    $client_id = $this->cid_app();
                    $client_secret = $this->cis_app();
                    $data_response = BniEnc::encrypt($merger_datamhs_sem, $client_id, $client_secret);

                    $cek_perangkat = $this->Api_model->cek_perangkat_mhs($username, $iddevice);

                    if ($cek_perangkat == 1) { //jika kode 1 maka perangkat sudah digunakan oleh user lain dan user ingin mengganti perangkatnya     
                        $cek_blokir = $this->Api_model->cek_waktu_blokir_device_and_mhs($username, $iddevice);

                        //var_dump($cek_blokir);
                        if ($cek_blokir['kode'] === 3) {
                            $batasblokirabsensi = time() + (3 * 86400);
                            $batasblokirperangkatbaru = time() + (7 * 86400);
                            if ($kodeinstruksi === "okganti") {

                                $data_insert = array(
                                    "NIMHS" => $username,
                                    "DEVICEID" => $iddevice,
                                    "DEVICEMODEL" => $devicename,
                                    "TGLLOGIN" => date('Y-m-d H:i:s'),
                                    "TGLAKHIRAKTIF" => date('Y-m-d H:i:s'),
                                    "BATASBLOKIRABSENSI" => $batasblokirabsensi,
                                    "BATASBLOKIRDEVICEBARU" => $batasblokirperangkatbaru,
                                    "AKTIFASI" => 1
                                );

                                $data_update = array(
                                    "AKTIFASI" => 0
                                );
                                $change_with_new_device_and_nonactiv_this_device_in_another_account = $this->Api_model->insert_new_device_and_nonactiv_this_device_in_another_account($iddevice, $username, $data_update, $data_insert);

                                if ($change_with_new_device_and_nonactiv_this_device_in_another_account) {
                                    $success = true;
                                    $message = "Selamat perangkat ini berhasil dihubungkan dengan akunmu dan telah diputus dari akun user lain, perangkat ini dapat digunakan untuk absensi kehadiran mulai " . date("d-m-Y H:i", $batasblokirabsensi);
                                    $resyncrondevice = false;
                                    $datamhs = $data_response;
                                } else {
                                    $success = false;
                                    $message = 'Login gagal, terjadi kendala di sistem database.';
                                    $resyncrondevice = false;
                                    $datamhs = null;
                                }
                            } else {
                                $success = false;
                                $message =  'Perangkat ini sebelumnya digunakan oleh user lain, apakah kamu yakin ingin menautkan perangkat ini dengan akun siakadmu, Jika iya kamu tidak dapat berganti perangkat lain sampai ' . date("d F Y", $batasblokirperangkatbaru) . ' ' . date("H:i", $batasblokirperangkatbaru);
                                $resyncrondevice = true;
                                $datamhs = null;
                            }
                        } else {
                            $success = false;
                            $message =  $cek_blokir['message'];
                            $resyncrondevice = false;
                            $datamhs = null;
                        }
                    } else if ($cek_perangkat == 2) { //jika kode 2 user sebelumnya sudah punya perangkat dan akan mengganti dengan perangkat baru

                        $cek_blokir = $this->Api_model->cek_waktu_blokir_device_and_mhs($username, $iddevice);
                        if ($cek_blokir['kode'] === 3) {
                            $batasblokirabsensi = time() + 86400;
                            $batasblokirperangkatbaru = time() + (3 * 86400);
                            if ($kodeinstruksi === "okganti") {

                                $data_insert = array(
                                    "NIMHS" => $username,
                                    "DEVICEID" => $iddevice,
                                    "DEVICEMODEL" => $devicename,
                                    "TGLLOGIN" => date('Y-m-d H:i:s'),
                                    "TGLAKHIRAKTIF" => date('Y-m-d H:i:s'),
                                    "BATASBLOKIRABSENSI" => $batasblokirabsensi,
                                    "BATASBLOKIRDEVICEBARU" => $batasblokirperangkatbaru,
                                    "AKTIFASI" => 1
                                );

                                $data_update = array("AKTIFASI" => 0);
                                $change_with_new_device_and_nonactiv_old_device = $this->Api_model->insert_new_device_and_update_old_device($username, $data_update, $data_insert);

                                if ($change_with_new_device_and_nonactiv_old_device) {
                                    $success = true;
                                    $message = "Selamat perangkat ini berhasil dihubungkan dengan akunmu, perangkat ini dapat digunakan untuk absensi kehadiran mulai " . date("d-m-Y H:i", time() + 86400);
                                    $resyncrondevice = false;
                                    $datamhs = $data_response;
                                } else {
                                    $success = false;
                                    $message = 'Login gagal, terjadi kendala di sistem database.';
                                    $resyncrondevice = false;
                                    $datamhs = null;
                                }
                            } else {
                                $success = false;
                                $message = 'Kamu terdeteksi menggunakan perangkat baru, Apakah kamu yakin ingin mengganti perangkat lama dengan perangakat baru ini, Jika iya kamu tidak dapat berganti perangkat lain sampai ' . date("d F Y", $batasblokirperangkatbaru) . ' ' . date("H:i", $batasblokirperangkatbaru);
                                $resyncrondevice = true;
                                $datamhs = null;
                            }
                        } else {
                            $success = false;
                            $message =  $cek_blokir['message'];
                            $resyncrondevice = false;
                            $datamhs = null;
                        }
                    } else if ($cek_perangkat == 3) { //jika kode 3 user login dengan perangkat yang sama dengan data di trdevicemhs
                        $data_update = array("TGLAKHIRAKTIF" => date('Y-m-d H:i:s'));
                        $update_last_active_device = $this->Api_model->update_data_perangkat($username, $iddevice, $data_update);
                        if ($update_last_active_device) {
                            $success = true;
                            $message = 'Login berhasil, data aktif terakhir berhasil diperbaharui.';
                            $resyncrondevice = false;
                            $datamhs = $data_response;
                        } else {
                            $success = false;
                            $message = 'Login gagal, terjadi kendala di sistem database.';
                            $resyncrondevice = false;
                            $datamhs = null;
                        }
                    } else if ($cek_perangkat == 4) { // jika kode 4 user tidak ada perangkat aktif dan ingin menambahkan perangkat baru
                        $batasblokirabsensi = time() + 86400;
                        $batasblokirperangkatbaru = time() + (3 * 86400);
                        if ($kodeinstruksi === "okganti") {

                            $data_insert = array(
                                "NIMHS" => $username,
                                "DEVICEID" => $iddevice,
                                "DEVICEMODEL" => $devicename,
                                "TGLLOGIN" => date('Y-m-d H:i:s'),
                                "TGLAKHIRAKTIF" => date('Y-m-d H:i:s'),
                                "BATASBLOKIRABSENSI" => $batasblokirabsensi,
                                "BATASBLOKIRDEVICEBARU" => $batasblokirperangkatbaru,
                                "AKTIFASI" => 1
                            );
                            $add_perangkat = $this->Api_model->add_device_mhs($data_insert);

                            if ($add_perangkat) {
                                $success = true;
                                $message = 'Login Berhasil, Perangkat berhasil ditautkan.';
                                $resyncrondevice = false;
                                $datamhs = $data_response;
                            } else {
                                $success = false;
                                $message = 'Login gagal, terjadi kendala di sistem database.';
                                $resyncrondevice = false;
                                $datamhs = null;
                            }
                        } else {
                            $success = false;
                            $message = 'Kamu terdeteksi menggunakan perangkat baru, Apakah kamu yakin ingin mengganti perangkat lama dengan perangakat baru ini, Jika iya kamu tidak dapat berganti perangkat lain sampai ' . date("d F Y", $batasblokirperangkatbaru) . ' ' . date("H:i", $batasblokirperangkatbaru);
                            $resyncrondevice = true;
                            $datamhs = null;
                        }
                    } else { //jika kode 5 user pertama kali login tambahkan id perangakt ke tabel trdevicemhs 
                        $batasblokirabsensi = time();
                        $batasblokirperangkatbaru = time() + (3 * 86400);
                        if ($kodeinstruksi === "okganti") {
                            $data_insert = array(
                                "NIMHS" => $username,
                                "DEVICEID" => $iddevice,
                                "DEVICEMODEL" => $devicename,
                                "TGLLOGIN" => date('Y-m-d H:i:s'),
                                "TGLAKHIRAKTIF" => date('Y-m-d H:i:s'),
                                "BATASBLOKIRABSENSI" => $batasblokirabsensi,
                                "BATASBLOKIRDEVICEBARU" => $batasblokirperangkatbaru,
                                "AKTIFASI" => 1
                            );
                            $add_perangkat = $this->Api_model->add_device_mhs($data_insert);

                            if ($add_perangkat) {
                                $success = true;
                                $message = 'Login Berhasil, Perangkat berhasil ditautkan.';
                                $resyncrondevice = false;
                                $datamhs = $data_response;
                            } else {
                                $success = false;
                                $message = 'Login gagal, terjadi kendala di sistem database.';
                                $resyncrondevice = false;
                                $datamhs = null;
                            }
                        } else {
                            $success = false;
                            $message = 'Apakah kamu yakin ingin menghubungkan perangkat ini kedalam akun siakad kamu, Jika iya kamu tidak dapat berganti perangkat lain sampai ' . date("d F Y", $batasblokirperangkatbaru) . ' ' . date("H:i", $batasblokirperangkatbaru);
                            $resyncrondevice = true;
                            $datamhs = null;
                        }
                    }
                } else {
                    $success = false;
                    $message = 'Username atau Password salah, Silahkan periksa kembali.';
                    $resyncrondevice = false;
                    $datamhs = null;
                }
            } else {
                $success = false;
                $message = 'Mahasiswa yang baik adalah orang yang berkelakuan baik dan menjaga semua fasilitas kampus tanpa merusaknya.';
                $resyncrondevice = false;
                $datamhs = null;
            }
        } else {
            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $dev_err = form_error('deviceid') ? form_error('deviceid') . ' ' : null;
            $namedev_err = form_error('devicename') ? form_error('devicename') : null;
            $upass_err = form_error('upassword') ? form_error('upassword') . ' ' : null;

            $success = false;
            $message = $unim_err . $upass_err . $dev_err . $namedev_err;
            $resyncrondevice = false;
            $datamhs = null;
        }

        sleep(1);

        $this->response([
            'success' => $success,
            'message' => $message,
            'resyncrondevice' => $resyncrondevice,
            'data' => $datamhs
        ], REST_Controller_Smartmobile::HTTP_OK);


        // $data_login = array(["nim" => "14118431", "password" => "12345"]);
        // $data_mhs = array("nim" => "14118431", "kodefakultas" => "1ADF", "kodepst" => "2FD", "nama" => "maulana ayub dwi saputra", "fakultas" => "Fakultas Dakwah", "programstudi" => "Komunikasi Penyiaran Islam", "semester" => 2, "ipkkumulatif" => "3,5", "skstempuh" => 56);
        // if ($username == $data_login[0]["nim"] && $password == $data_login[0]["password"]) {
    }

    public function refreshdata_post()
    {
        $username_post = $this->post('unim');
        $iddevice_post = $this->post('deviceid');

        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('deviceid', 'ID Device', 'required');
        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_error_delimiters('', '');


        if ($this->form_validation->run() == true) {

            $username = BniEnc::decrypt_string($username_post, $this->cid_app(), $this->cis_app());
            $iddevice = BniEnc::decrypt_string($iddevice_post, $this->cid_app(), $this->cis_app());

            if ($username != null && $iddevice != null) {

                $cek_perangkat = $this->Api_model->cek_perangkat_mhs($username, $iddevice);
                if ($cek_perangkat == 3) { //jika kode 3 user refresh session dengan perangkat yang sama dengan data di trdevicemhs
                    $data_mhs = $this->Api_model->get_data_mhs($username);

                    if ($data_mhs != null) {

                        $smstr_berjalan = $this->Api_model->cek_thsmt_akademik();
                        $semester_berjalan = isset($smstr_berjalan->semester_aktif) ? $smstr_berjalan->semester_aktif : '';

                        $semester_mhs = $this->smt_mhs_by_th_smt($data_mhs['tahunms'], $semester_berjalan);


                        $cek_status_aktif_mhs = $this->Api_model->cek_status_aktif_mhs($semester_berjalan, $username);
                        if ($data_mhs['status'] == "C" || $data_mhs['status'] == "A" || $data_mhs['status'] == "N") {

                            if ($cek_status_aktif_mhs) {
                                $status = "A";
                            } else {
                                $cek_cuti_mhs = $this->Api_model->get_cuti_mhs($username, $semester_berjalan);

                                if ($cek_cuti_mhs) {
                                    $status = "C";
                                } else {
                                    $status = "N";
                                }
                            }
                        } else {
                            $status = $data_mhs['status'];
                        }

                        //cek sks ditempuh

                        $get_sks_belum_terekap = $this->Api_model->get_sks_ipk_kumulatif($username);
                        $sks_kumulatif = $get_sks_belum_terekap['jumlah_sks'] ?  $get_sks_belum_terekap['jumlah_sks'] : 0;
                        $ipk_kumulatif = $get_sks_belum_terekap['jumlah_ipk'] ?  $get_sks_belum_terekap['jumlah_ipk'] : 0;


                        if ($data_mhs['ISADDEMAIL'] == "true") {
                            $isaddemail = true;
                        } else {
                            $isaddemail = false;
                        }

                        if ($data_mhs['EMAILVERIFICATION'] == "true") {
                            $emailverif = true;
                        } else {
                            $emailverif = false;
                        }

                        $merger_datamhs_sem = array(
                            "nim" => $data_mhs['nim'],
                            "kodefakultas" => $data_mhs['kodefakultas'],
                            "kodepst" => $data_mhs['kodepst'],
                            "kodejen" => $data_mhs['kodejen'],
                            "nama" => $data_mhs['nama'],
                            "fakultas" => $data_mhs['fakultas'],
                            "programstudi" => $data_mhs['programstudi'],
                            "semester" =>  $semester_mhs,
                            "ipkkumulatif" => $ipk_kumulatif,
                            "skstempuh" => $sks_kumulatif,
                            "angkatan" => $data_mhs['angkatan'],
                            "jenjang" => $data_mhs['jenjang'],
                            "telp" => $data_mhs['telp'],
                            "status" => $status,
                            "isaddemail" => $isaddemail,
                            "emailverifycation" => $emailverif,
                            "email" => $data_mhs['EMAIL']
                        );

                        $client_id = $this->cid_app();
                        $client_secret = $this->cis_app();
                        $data_response = BniEnc::encrypt($merger_datamhs_sem, $client_id, $client_secret);

                        $data_update = array("TGLAKHIRAKTIF" => date('Y-m-d H:i:s'));
                        $this->Api_model->update_data_perangkat($username, $iddevice, $data_update);

                        $success = true;
                        $forcelogout = false;
                        $message = 'Data Update ditemukan';
                        $data = $data_response;
                    } else {
                        $success = false;
                        $forcelogout = true;
                        $message = 'Data Update tidak ditemukan';
                        $data = null;
                    }
                } else {
                    $success = false;
                    $forcelogout = true;
                    $message = 'Sessi kamu kadaluarsa.';
                    $data = null;
                }
            } else {
                $success = false;
                $forcelogout = true;
                $message = 'Mahasiswa yang baik adalah orang yang berkelakuan baik dan menjaga semua fasilitas kampus tanpa merusaknya.';
                $data = null;
            }
        } else {
            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $udev_err = form_error('deviceid') ? form_error('deviceid') : null;

            $success = false;
            $forcelogout = true;
            $message = $unim_err . $udev_err;
            $data = null;
        }


        // $data_update = array("nim" => "14118431", "kodefakultas" => "1ADF", "kodepst" => "2FD", "nama" => "maulana ayub dwi saputra", "fakultas" => "Fakultas Dakwah", "programstudi" => "Komunikasi Penyiaran Islam", "semester" => 3, "ipkkumulatif" => "3,7", "skstempuh" => 60);

        //sleep(1);
        $this->response([
            'success' => $success,
            'message' => $message,
            'forcelogout' => $forcelogout,
            'data' => $data,

        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    public function pengumuman_get()
    {
        $kode_jen = $this->get('kodejen');
        $kode_fakultas = $this->get('kodefak');
        $kode_program_studi = $this->get('kodepst');
        $page = $this->get('page');
        $searchquery = $this->get('search');

        $querylink = array("kodejen" => $kode_jen, "kodefak" => $kode_fakultas, "kodepst" => $kode_program_studi);
        $this->form_validation->set_data($querylink);

        $this->form_validation->set_rules('kodejen', 'Kode Jenis', 'required');
        $this->form_validation->set_rules('kodefak', 'Kode Fakultas', 'required');
        $this->form_validation->set_rules('kodepst', 'Kode Program Studi', 'required');

        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {
            $limit = 10;
            if ($page == null || $page == "") {
                $page = 1;
            }
            $star_row = ($page - 1) * 10;

            $prodi = $kode_jen . '~' . $kode_program_studi;
            $data_pengumuman = $this->Api_model->get_data_pengumuman($prodi, $star_row, $limit, $searchquery);

            //var_dump($star_row);


            $data_merger_pengumuman = null;
            foreach ($data_pengumuman as $row) {
                $decode = json_decode($row['params'], true);
                $publisher = $decode['createdby'];
                $data_merger_pengumuman[] = array(
                    "judul" => $row['judul'], "linkpicture" => "https://iainsalatiga.ac.id/web/wp-content/uploads/2022/04/WEB-PENGUMUMAN-1024x640.png", "isi" => $row["isi"], "tanggal" => $row["tanggal"], "kategori" => $row["kategori"], "publisher" => $publisher
                );
            }

            if ($data_merger_pengumuman != null) {
                $success = true;
                $message = 'pengumuman ditemukan';
            } else {
                $success = false;
                $message = 'pengumuman tidak ditemukan';
            }
        } else {
            $success = false;

            $jen_err = form_error('kodejen') ? form_error('kodejen') . ' ' : null;
            $fak_err = form_error('kodefak') ? form_error('kodefak') . ' ' : null;
            $pst_err = form_error('kodepst') ? form_error('kodepst') : null;
            $message = $jen_err . $fak_err . $pst_err;

            $data_merger_pengumuman = null;
        }

        sleep(1);
        $this->response([
            'success' => $success,
            'message' => $message,
            'data' => $data_merger_pengumuman,

        ], REST_Controller_Smartmobile::HTTP_OK);

        // $data = array(
        //     [
        //         "judul" => "HELPDESK / PUSAT BANTUAN INFORMASI BEASISWA & KIP KULIAH",
        //         "linkpicture" => "https://cdn-asset.jawapos.com/wp-content/uploads/2017/08/kabar-gembira-bulan-ini-uang-bantuan-kip-cair_m_148619-640x421.jpeg",
        //         "isi" => '<div>&nbsp;Selamat siang,<br /><br />Berikut kami sampaikan link helpdesk media sosial Sub Bagian Kemahasiswaan, Alumni dan Kerjasama untuk pelayanan terkait Beasiswa, KIP Kuliah, ORMAWA dan pelayanan pendukung lainnya dalam tupoksi kami.<br /><br />Link <a href="https://wa.me/6285870544049">Whatsapp</a></div><div>Link <a href="https://www.instagram.com/kemahasiswaaniainsalatiga/">Instagram&nbsp;</a></div><div>Email: kemahasiswaan@iainsalatiga.ac.id.<br /><br />Seluruh kanal helpdesk tersebut akan kami aktifkan ketika jam kerja / jam pelayanan yaitu <strong>Senin - Kamis pukul 07.30 - 16.00</strong> dan<strong>Jumat pukul 07.30 - 16.30.<br /></strong><br />Semoga dapat membantu rekan-rekan semua dan memaksimalkan pelayanan kami.<br /><br />Terima kasih.<br /><br />Salam,<br />Kemahasiswaan IAIN Salatiga</div>',
        //         "tanggal" => "24 Agustus 2021 06:50:00",
        //         "kategori" => "Berita Fakultas",
        //         "publisher" => "Aditya Mufti Kurniawan"
        //     ],
        //     [
        //         "judul" => "RALAT PENGUMUMAN KIP KULIAH TAHUN 2021 - SURAT KETERANGAN PENGHASILAN ORANGTUA BERMATERAI 10000",
        //         "linkpicture" => "https://blog-static.mamikos.com/wp-content/uploads/2021/04/Surat-keterangan-penghasilan.jpg",
        //         "isi" => '<div style="padding-left: 3mm;"><span style="font-size: 14px;">&nbsp;Unduh Pengumuman ini:</span></div><div style="padding-left: 3mm;"><span style="font-size: 14px;"><br type="_moz" /></span></div><div style="padding-left: 3mm;"><span style="font-size: 14px;"><strong><a href="https://drive.google.com/file/d/1_jHz9sIYFSTkYMXmXVzgwHDexqc3dwKx/view?usp=sharing">DOWNLOAD</a></strong></span></div>',
        //         "tanggal" => "23 Agustus 2021 08:00:00",
        //         "kategori" => "Berita Akademik",
        //         "publisher" => "Dinda Saputri"
        //     ],
        //     [
        //         "judul" => "PENGUMUMAN WISUDA PERIODE 54 PROGRAM STUDI PASCASARJANA",
        //         "linkpicture" => "https://iainsalatiga.ac.id/web/wp-content/uploads/2021/09/041A0504-1024x683-1-400x225.jpg",
        //         "isi" => '<div>&nbsp;Assalamualaikum w. w.</div><div>Berikut kami sampaikan pengumuman mengenai&nbsp;Pendaftaran Wisuda Program Sarjana dan Magister Periode November Semester Gasal Tahun Akademik 2021/2022.</div><div>&nbsp;</div><div><a href="https://drive.google.com/file/d/1gVoVed7kVT4z7wP07mNFSav88Th2cuGp/view?usp=sharing">Lihat Pengumuman</a></div><div>&nbsp;</div><div>Wassalamualaikum w. w.</div>',
        //         "tanggal" => "22 Agustus 2021 08:00:00",
        //         "kategori" => "Berita Akademik",
        //         "publisher" => "Dinda Saputri"
        //     ],
        //     [
        //         "judul" => "FAKULTAS SYARI'AH: NILAI UJIAN KOMPREHENSIF TULIS PG SEPTEMBER 2021",
        //         "linkpicture" => "https://iainsalatiga.ac.id/web/wp-content/uploads/2021/09/PPL-KKI.jpg",
        //         "isi" => '<div style="text-indent: 18pt;">&nbsp;Assalamualaikum wr.wb.</div><div style="text-indent: 18pt;">Silahkan unduh hasil ujian kompre tulis PG, di bawah ini:</div><div style="text-indent: 18pt;">&nbsp;</div><div style="text-indent: 18pt;"><a href="https://drive.google.com/file/d/1mzoSHj_nGu6JLfTvz76dk_R-G3VhieBg/view?usp=sharing"><strong>DOWNLOAD</strong></a></div><div style="text-indent: 18pt;">&nbsp;</div><div style="text-indent: 18pt;">Terima kasih.</div><div style="text-indent: 18pt;">Wassalamualaikum wr.wb</div>',
        //         "tanggal" => "20 Agustus 2021 08:00:00",
        //         "kategori" => "Beasiswa",
        //         "publisher" => "Admin"
        //     ]

        // );
    }

    public function create_otp_verif_email_post()
    {
        $encunim = $this->post('unim');
        $encemail = $this->post('uemail');
        $enckode_pst = $this->post('kode_pst');

        $this->form_validation->set_rules('kode_pst', 'Kode Program Studi', 'required');
        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('uemail', 'Email', 'required|callback_email_check');
        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_message('valid_email', 'format %s tidak valid');
        $this->form_validation->set_message('is_unique', '%s sudah digunakan pada akun lain');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {

            $unim = BniEnc::decrypt_string($encunim, $this->cid_app(), $this->cis_app());
            $email = BniEnc::decrypt_string($encemail, $this->cid_app(), $this->cis_app());
            $kode_pst = BniEnc::decrypt_string($enckode_pst, $this->cid_app(), $this->cis_app());


            if ($unim != null && $email != null && $kode_pst != null) {
                $data_mhs = $this->Api_model->cek_nim_siakad($unim);

                if ($data_mhs != null) {

                    $cek_limit_per_hari = $this->Api_model->cek_limit_verif_email($unim);
                    $limit = 5;

                    if ($cek_limit_per_hari >= $limit) {
                        $success = false;
                        $message = "Permintaan Kode OTP penautan email gagal, Percobaan telah melampaui batas maksimal dalam satu hari yaitu $limit kali.";
                        $countdown = 0;
                    } else {

                        $cek_waktu_periksa_otp = $this->Api_model->cek_waktu_periksa_otp($unim);

                        if ($cek_waktu_periksa_otp > 0) {
                            $success = false;
                            $message = "Permintaan Kode OTP penautan email gagal, Mohon tunggu untuk percobaan berikutnya.";
                            $countdown = $cek_waktu_periksa_otp;
                        } else {

                            $otp = mt_rand(1001, 9999);


                            $waktu_tunggu = 120; //2 menit
                            $kadaluarsa_dalam_menit = $waktu_tunggu / 60;
                            $data_insert = array("NIMHS" => $unim, "EMAILMHS" => $email, "OTP" => $otp, "OTPVALIDUTIL" => time() + $waktu_tunggu, "TANGGALINPUT" => date("Y-m-d H:i:s"));
                            $data_update = array("EMAIL" => $email);
                            $update_insert_id = $this->Api_model->change_email_mhs($unim, $kode_pst, $data_update, $data_insert);

                            if ($update_insert_id != 0) {
                                $text_email = "Pakai kode OTP <b> $otp </b> untuk menautkan email dengan akun siakad kamu, Kode otp ini berlaku $kadaluarsa_dalam_menit menit. <br><br> Jangan pernah memberikan kode OTP ini ke pihak siapapun termasuk yang mengaku dari IAIN Salatiga";
                                $subject = "IAIN Salatiga : Kode OTP penautan akun siakad";

                                // $success = true;
                                // $message = "Email berhasil disimpan, verifikasi email dengan kode otp yang sudah dikirimkan ke email untuk menautkan akun";
                                // $countdown = $waktu_tunggu;


                                //$this->send_email($email, $text_email, $subject);


                                $kirim_otp = $this->send_email($email, $text_email, $subject);

                                if ($kirim_otp) {
                                    $success = true;
                                    $message = "Email berhasil disimpan, verifikasi email dengan kode otp yang sudah dikirimkan ke email untuk menautkan akun";
                                    $countdown = $waktu_tunggu;
                                } else {
                                    $delete_otp = $this->Api_model->delete_otp($unim, $update_insert_id);
                                    $success = false;
                                    $message = "Email gagal ditautkan, terjadi kendala pada server SMTP";
                                    $countdown = 0;
                                }
                            } else {
                                $success = false;
                                $message = "Email gagal ditautkan, terjadi kendala pada sistem database.";
                                $countdown = 0;
                            }
                        }
                    }
                } else {
                    $success = false;
                    $message = "Nim mahasiswa tidak ditemukan";
                    $countdown = 0;
                }
            } else {
                $success = false;
                $message = "Cie mau ngehack";
                $countdown = 0;
            }
        } else {
            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $email_err = form_error('uemail') ? form_error('uemail') : null;
            $kdpst_err = form_error('kode_pst') ? form_error('kode_pst') . ' ' : null;

            $success = false;
            $message = $unim_err . $kdpst_err . $email_err;
            $countdown = 0;
        }

        $this->response([
            'success' => $success,
            'message' => $message,
            'countdown' => $countdown,

        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    public function verif_email_mhs_post()
    {
        $encunim = $this->post('unim');
        $encemail = $this->post('uemail');
        $enckode_pst = $this->post('kode_pst');
        $encotp_post = $this->post('otp');

        $this->form_validation->set_rules('kode_pst', 'Kode Program Studi', 'required');
        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('otp', 'Kode OTP', 'required');
        $this->form_validation->set_rules('uemail', 'Email', 'required');
        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_message('valid_email', 'format %s tidak valid');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {
            $unim = BniEnc::decrypt_string($encunim, $this->cid_app(), $this->cis_app());
            $email = BniEnc::decrypt_string($encemail, $this->cid_app(), $this->cis_app());
            $kode_pst = BniEnc::decrypt_string($enckode_pst, $this->cid_app(), $this->cis_app());
            $otp_post = BniEnc::decrypt_string($encotp_post, $this->cid_app(), $this->cis_app());

            if ($unim != null && $email != null && $kode_pst != null && $otp_post != null) {
                $data_mhs = $this->Api_model->cek_nim_siakad($unim);

                if ($data_mhs != null) {
                    $cek_otp = $this->Api_model->cek_otp_email($unim, $email, $otp_post);

                    if ($cek_otp == 1) {

                        $data_update_tremailverif = array("ISVERIFIED" => 1);

                        $update_trverifemail = $this->Api_model->update_email_verified($unim, $email, $otp_post, $data_update_tremailverif);

                        if ($update_trverifemail) {
                            $success = true;
                            $message = "Selamat Email berhasil ditautkan dengan akun SIAKAD.";
                        } else {
                            $success = false;
                            $message = "Email gagal ditautkan, terjadi kendala pada sistem database.";
                        }
                    } else if ($cek_otp == 2) {
                        $success = false;
                        $message = "Kode OTP kadaluarsa";
                    } else {
                        $success = false;
                        $message = "Kode OTP tidak sesuai";
                    }
                } else {
                    $success = false;
                    $message = "Nim mahasiswa tidak ditemukan.";
                }
            } else {
                $success = false;
                $message = "Cie mau ngehack";
            }
        } else {
            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $email_err = form_error('uemail') ? form_error('uemail') : null;
            $kdpst_err = form_error('kode_pst') ? form_error('kode_pst') . ' ' : null;
            $otp_err = form_error('otp') ? form_error('otp') . ' ' : null;

            $success = false;
            $message = $unim_err . $kdpst_err . $otp_err . $email_err;
        }

        $this->response([
            'success' => $success,
            'message' => $message,

        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    public function create_otp_reset_password_post()
    {
        $nimpost = $this->post('unim');
        $emailpost = $this->post('uemail');

        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('uemail', 'Email', 'required');
        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_message('valid_email', 'format %s tidak valid');

        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {
            $unim = BniEnc::decrypt_string($nimpost, $this->cid_app(), $this->cis_app());
            $email = BniEnc::decrypt_string($emailpost, $this->cid_app(), $this->cis_app());
            if ($unim != null && $email != null) {
                $data_mhs = $this->Api_model->cek_nim_email_siakad($unim, $email);

                if ($data_mhs == 1) {


                    $cek_limit_per_hari = $this->Api_model->cek_limit_reset_password($unim);
                    $limit = 5;

                    if ($cek_limit_per_hari >= $limit) {
                        $success = false;
                        $message = "Permintaan Kode OTP reset password gagal, Percobaan telah melampaui batas maksimal dalam satu hari yaitu $limit kali.";
                        $countdown = 0;
                    } else {

                        $cek_waktu_periksa_otp = $this->Api_model->cek_waktu_periksa_otp_reset_password($unim);

                        if ($cek_waktu_periksa_otp > 0) {
                            $success = false;
                            $message = "Permintaan Kode OTP reset password gagal, Mohon tunggu untuk percobaan berikutnya.";
                            $countdown = $cek_waktu_periksa_otp;
                        } else {

                            $otp = mt_rand(1001, 9999);

                            $waktu_tunggu = 120; //2 menit
                            $kadaluarsa_dalam_menit = $waktu_tunggu / 60;
                            $old_pass_mhs = $this->Api_model->get_old_pass_mhs($unim, $email);

                            $data_insert = array("NIMHS" => $unim, "EMAILMHS" => $email, "OTP" => $otp, "OTPVALIDUTIL" => time() + $waktu_tunggu, "OLDPASS" => $old_pass_mhs["login_pass"], "TANGGALINPUT" => date("Y-m-d H:i:s"));

                            $insert_otp = $this->Api_model->create_otp_reset_password_mhs($data_insert);

                            if ($insert_otp != 0) {
                                $text_email = "Pakai kode OTP <b> $otp </b> untuk mengganti password akun siakad kamu, Kode otp ini berlaku $kadaluarsa_dalam_menit menit. <br><br> Jangan pernah memberikan kode OTP ini ke pihak siapapun termasuk yang mengaku dari IAIN Salatiga";
                                $subject = "IAIN Salatiga : Kode OTP reset password akun siakad";



                                $kirim_otp = $this->send_email($email, $text_email, $subject);

                                if ($kirim_otp) {
                                    $success = true;
                                    $message = "Kode OTP reset password berhasil dikirim";
                                    $countdown = $waktu_tunggu;
                                } else {
                                    $delete_otp = $this->Api_model->delete_otp_reset_password($unim, $insert_otp);
                                    $success = false;
                                    $message = "Kode OTP reset password gagal dikirim, terjadi kendala pada server SMTP";
                                    $countdown = 0;
                                }
                            } else {
                                $success = false;
                                $message = "Kode OTP reset password gagal dikirim, terjadi kendala pada sistem database.";
                                $countdown = 0;
                            }
                        }
                    }
                } else if ($data_mhs == 2) {
                    $success = false;
                    $message = "Tidak dapat melakukan reset password, email yang kamu masukan belum pernah dilakukan verifikasi.";
                    $countdown = 0;
                } else if ($data_mhs == 3) {
                    $success = false;
                    $message = "Tidak dapat melakukan reset password, email yang kamu masukan belum tertaut pada akun manapun.";
                    $countdown = 0;
                } else {
                    $success = false;
                    $message = "Nim atau email mahasiswa tidak ditemukan";
                    $countdown = 0;
                }
            } else {
                $success = false;
                $message = "Ciee mau ngehack";
                $countdown = 0;
            }
        } else {
            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $email_err = form_error('uemail') ? form_error('uemail') : null;


            $success = false;
            $message = $unim_err . $email_err;
            $countdown = 0;
        }

        sleep(1);
        $this->response([
            'success' => $success,
            'message' => $message,
            'countdown' => $countdown,

        ], REST_Controller_Smartmobile::HTTP_OK);
    }


    public function verif_otp_reset_password_mhs_post()
    {
        $nimpost = $this->post('unim');
        $emailpost = $this->post('uemail');
        $otppost = $this->post('otp');

        $this->form_validation->set_rules('unim', 'Nim', 'required');
        $this->form_validation->set_rules('otp', 'Kode OTP', 'required');
        $this->form_validation->set_rules('uemail', 'Email', 'required');
        $this->form_validation->set_message('required', '%s tidak valid');
        //$this->form_validation->set_message('valid_email', 'format %s tidak valid');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {
            $unim = BniEnc::decrypt_string($nimpost, $this->cid_app(), $this->cis_app());
            $email = BniEnc::decrypt_string($emailpost, $this->cid_app(), $this->cis_app());
            $otp_post = BniEnc::decrypt_string($otppost, $this->cid_app(), $this->cis_app());

            $data_mhs = $this->Api_model->cek_nim_siakad($unim);

            if ($data_mhs != null) {
                $cek_otp = $this->Api_model->cek_otp_reset_password($unim, $email, $otp_post);

                //var_dump($cek_otp);
                if ($cek_otp == 1) {

                    $data_update_trresetpassword = array("ISVERIFIED" => 1);

                    $update_trresetpassword = $this->Api_model->update_otp_res_pas_verified($unim, $email, $otp_post, $data_update_trresetpassword);

                    if ($update_trresetpassword) {
                        $success = true;
                        $message = "OTP Valid.";
                        $nimenc = BniEnc::encrypt_string($unim, $this->cid_reset_pas(), $this->cis_reset_pas());
                    } else {
                        $success = false;
                        $message = "OTP gagal diverifikasi, terjadi kendala pada sistem database.";
                        $nimenc = null;
                    }
                } else if ($cek_otp == 2) {
                    $success = false;
                    $message = "Kode OTP kadaluarsa.";
                    $nimenc = null;
                } else {
                    $success = false;
                    $message = "Kode OTP tidak sesuai.";
                    $nimenc = null;
                }
            } else {
                $success = false;
                $message = "Nim mahasiswa tidak ditemukan.";
                $nimenc = null;
            }
        } else {
            $unim_err = form_error('unim') ? form_error('unim') . ' ' : null;
            $email_err = form_error('uemail') ? form_error('uemail') : null;
            $otp_err = form_error('otp') ? form_error('otp') . ' ' : null;

            $success = false;
            $message = $unim_err . $otp_err . $email_err;
            $nimenc = null;
        }

        $this->response([
            'success' => $success,
            'message' => $message,
            'nimenc' => $nimenc

        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    public function change_password_mhs_post()
    {
        $encnim = $this->post('encnim');
        $encemail = $this->post('uemail');
        $encotp = $this->post('otp');
        $encpassword = $this->post('encnewpassword');

        $this->form_validation->set_rules('encnim', 'Enkripsi Nim', 'required');
        $this->form_validation->set_rules('encnewpassword', 'Enkripsi Password Baru', 'required');
        $this->form_validation->set_rules('otp', 'Kode OTP', 'required');
        $this->form_validation->set_rules('uemail', 'Email', 'required');
        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_message('valid_email', 'format %s tidak valid');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {
            $decrypt_encnim = BniEnc::decrypt_string($encnim, $this->cid_reset_pas(), $this->cis_reset_pas());
            $decrypt_newpass = BniEnc::decrypt_string($encpassword, $this->cid_app(), $this->cis_app()); //"ayubgantengt";
            $decrypt_otp = BniEnc::decrypt_string($encotp, $this->cid_app(), $this->cis_app());
            $decrypt_email = BniEnc::decrypt_string($encemail, $this->cid_app(), $this->cis_app());

            if ($decrypt_encnim != null && $decrypt_newpass != null && $decrypt_otp != null && $decrypt_email != null) {
                $data_mhs = $this->Api_model->cek_nim_siakad($decrypt_encnim);
                if ($data_mhs != null) {
                    $cek_otp_to_change = $this->Api_model->cek_otp_when_try_to_change_password($decrypt_encnim, $decrypt_email, $decrypt_otp, 1);

                    if ($cek_otp_to_change == 2) {
                        $cek_old_password = $this->Api_model->cek_old_password($decrypt_encnim, $decrypt_newpass);
                        if ($cek_old_password) {
                            $success = false;
                            $message = "Password pernah digunakan, gunakan password lain.";
                        } else {
                            $update = $this->Api_model->update_password_and_useotp_mahasiswa($decrypt_encnim, $decrypt_newpass, $decrypt_email, $decrypt_otp);
                            if ($update) {
                                $success = true;
                                $message = "Update password berhasil, Silahkan menuju halaman login";

                                $data_update = array(
                                    "AKTIFASI" => 0
                                );
                                $this->Api_model->non_active_old_device($decrypt_encnim, $data_update);

                                $mahasiswa = $data_mhs['NMMHSMSMHS'];
                                $text_email = "Hai $mahasiswa, Kamu berhasil mengganti password akun SIAKAD melalui aplikasi SMART . Jika kamu tidak merasa melakukan aktifitas ini segera laporkan kebagian <b>UPT TIPD IAIN SALATIGA</b>, atau anda dapat mengambil alih akun anda dengan cara <b>reset password</b>. ";
                                $subject = "IAIN Salatiga : Pemberitahuan reset password";
                                $this->send_email($decrypt_email, $text_email, $subject);
                            } else {
                                $success = false;
                                $message = "Update password gagal, terjadi kendala database.";
                            }
                        }
                    } else if ($cek_otp_to_change == 1) {
                        $success = false;
                        $message = "Akses ditolak, otp tidak sesuai / sudah digunakan";
                    } else {
                        $success = false;
                        $message = "Akses ditolak, parameter tidak sesuai";
                    }
                } else {
                    $success = false;
                    $message = "Nim mahasiswa tidak ditemukan.";
                }
            } else {
                $success = false;
                $message = "Akses Ditolak Formulir Kadaluarsa.";
            }
        } else {
            $unim_err = form_error('encnim') ? form_error('encnim') . ' ' : null;
            $upass_err = form_error('encnewpassword') ? form_error('encnewpassword') . ' ' : null;
            $email_err = form_error('uemail') ? form_error('uemail') : null;
            $otp_err = form_error('otp') ? form_error('otp') . ' ' : null;

            $success = false;
            $message = $unim_err . $upass_err . $otp_err . $email_err;
        }

        $this->response([
            'success' => $success,
            'message' => $message

        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    public function change_password_mhs_use_old_password_post()
    {
        $encnim = $this->post('encnim');
        $encemail = $this->post('uemail');
        $encoldpassword = $this->post('encoldpassword');
        $encnewpassword = $this->post('encnewpassword');

        $this->form_validation->set_rules('encnim', 'Enkripsi Nim', 'required');
        $this->form_validation->set_rules('encnewpassword', 'Enkripsi Password Baru', 'required');
        $this->form_validation->set_rules('encoldpassword', 'Enkripsi Password Lama', 'required');
        $this->form_validation->set_rules('uemail', 'Email', 'required');



        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_message('valid_email', 'format %s tidak valid');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {
            $decrypt_encnim =  BniEnc::decrypt_string($encnim, $this->cid_app(), $this->cis_app());
            $decrypt_email =   BniEnc::decrypt_string($encemail, $this->cid_app(), $this->cis_app());
            $decrypt_newpass = BniEnc::decrypt_string($encnewpassword, $this->cid_app(), $this->cis_app());
            $decrypt_oldpass = BniEnc::decrypt_string($encoldpassword, $this->cid_app(), $this->cis_app());

            if ($decrypt_encnim != null && $decrypt_newpass != null && $decrypt_email != null && $decrypt_oldpass != null) {
                $data_mhs = $this->Api_model->cek_nim_siakad($decrypt_encnim);
                if ($data_mhs != null) {
                    $cek_auth_login = $this->Api_model->check_user_mhs($decrypt_encnim, $decrypt_oldpass);
                    if ($cek_auth_login != null) {
                        $cek_old_password = $this->Api_model->cek_old_password($decrypt_encnim, $decrypt_newpass);
                        if ($cek_old_password || ($decrypt_newpass == $decrypt_oldpass)) {
                            $success = false;
                            $message = "Password pernah digunakan, gunakan password lain.";
                        } else {
                            $old_pass_mhs = $this->Api_model->get_old_pass_mhs($decrypt_encnim, $decrypt_email);

                            if ($old_pass_mhs != null) {
                                $data_insert = array("NIMHS" => $decrypt_encnim, "EMAILMHS" => $decrypt_email, "OTP" => 0000, "OTPVALIDUTIL" => 0, "OLDPASS" => $old_pass_mhs["login_pass"], "ISVERIFIED" => 1, "USETOCHANGEPASSWORD" => 1, "TANGGALINPUT" => date("Y-m-d H:i:s"));

                                $update = $this->Api_model->update_password_using_old_password($decrypt_encnim, $decrypt_newpass, $decrypt_email, $data_insert);
                                if ($update) {
                                    $success = true;
                                    $message = "Update password berhasil.";

                                    $mahasiswa = $data_mhs['NMMHSMSMHS'];
                                    $text_email = "Hai $mahasiswa, Kamu berhasil mengganti password akun SIAKAD. Jika kamu tidak merasa melakukan aktifitas ini segera laporkan kebagian <b>UPT TIPD IAIN SALATIGA</b>, atau anda dapat mengambil alih akun anda dengan cara <b>reset password</b>. ";
                                    $subject = "IAIN Salatiga : Pemberitahuan reset password";
                                    $this->send_email($decrypt_email, $text_email, $subject);
                                } else {
                                    $success = false;
                                    $message = "Update password gagal, terjadi kendala database.";
                                }
                            } else {
                                $success = false;
                                $message = "Email tidak sesuai";
                            }
                        }
                    } else {
                        $success = false;
                        $message = "Password lama yang kamu masukan salah.";
                    }
                } else {
                    $success = false;
                    $message = "Nim mahasiswa tidak ditemukan.";
                }
            } else {
                $success = false;
                $message = "Mahasiswa yang baik adalah orang yang berkelakuan baik dan menjaga semua fasilitas kampus tanpa merusaknya.";
            }
        } else {
            $unim_err = form_error('encnim') ? form_error('encnim') . ' ' : null;
            $unewpass_err = form_error('encnewpassword') ? form_error('encnewpassword') . ' ' : null;
            $email_err = form_error('uemail') ? form_error('uemail') : null;
            $uoldpass_err = form_error('encoldpassword') ? form_error('encoldpassword') . ' ' : null;

            $success = false;
            $message = $unim_err . $unewpass_err . $uoldpass_err . $email_err;
        }

        $this->response([
            'success' => $success,
            'message' => $message

        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    public function get_lokasi_post()
    {
        $idlokasi = $this->input->post("idlokasi");
        $idlevel = $this->input->post("idlevel");
    

        $this->form_validation->set_rules('idlokasi', "idlokasi", 'required');
        $this->form_validation->set_rules('idlevel', "idlevel", 'required');
        $this->form_validation->set_message('required', '%s tidak valid');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == true) {
            if ($idlokasi == "ID" && $idlevel == 1) {
                $get_propinsi = $this->Api_model->get_propinsi_mhs($idlokasi);
                if ($get_propinsi != null) {
                    $success = true;
                    $message = "List provinsi ditemukan";
                    $data = $get_propinsi;
                } else {
                    $success = false;
                    $message = "Tidak dapat menemukan list provinsi";
                    $data = null;
                }
            } else if ($idlevel == 2) {
                $get_kota = $this->Api_model->get_kota_mhs($idlokasi);
                if ($get_kota != null) {
                    $success = true;
                    $message = "List kab / kota ditemukan";
                    $data = $get_kota;
                } else {
                    $success = false;
                    $message = "Tidak dapat menemukan list kab / kota";
                    $data = null;
                }
            } else if ($idlevel == 3) {
                $get_kecamatan = $this->Api_model->get_kecamatan_mhs($idlokasi);
                if ($get_kecamatan != null) {
                    $success = true;
                    $message = "List kecamatan ditemukan";
                    $data = $get_kecamatan;
                } else {
                    $success = false;
                    $message = "Tidak dapat menemukan list kecamatan";
                    $data = null;
                }
            }else{
                $success = false;
                $message = "Tidak dapat menemukan list lokasi manapun";
                $data = null;
            }
        } else {
            $idnegara_err = form_error('idlokasi') ? form_error('idlokasi') . ' ' : null;
            $idlevel_err = form_error('idlevel') ? form_error('idlevel') : null;
            $success = false;
            $message = $idnegara_err . $idlevel_err;
            $data = null;
        }

        $this->response([
            'success' => $success,
            'message' => $message,
            'data' => $data

        ], REST_Controller_Smartmobile::HTTP_OK);
    }

    // public function get_kota_post(){
    //     $idprovinsi = $this->input->post("idprovinsi");

    //     $this->form_validation->set_rules('idprovinsi', 'ID Provinsi', 'required');
    //     $this->form_validation->set_message('required', '%s tidak valid');
    //     $this->form_validation->set_error_delimiters('', '');

    //     if ($this->form_validation->run() == true) {

    //             $get_kota = $this->Api_model->get_kota_mhs($idprovinsi);
    //             if($get_kota!=null){
    //                 $success = true;
    //                 $message = "List kab / kota ditemukan";
    //                 $data = $get_kota;
    //             }else{
    //                 $success = false;
    //                 $message = "Tidak dapat menemukan list kab / kota";
    //                 $data = null;
    //             }

    //     }else{
    //         $idprovinsi_err = form_error('idprovinsi') ? form_error('idprovinsi') : null;
    //         $success = false;
    //         $message = $idprovinsi_err;
    //         $data = null;
    //     }

    //     $this->response([
    //         'success' => $success,
    //         'message' => $message,
    //         'data' => $data

    //     ], REST_Controller_Smartmobile::HTTP_OK);

    // }

    // public function get_kecamatan_post(){
    //     $idkota= $this->input->post("idkota");

    //     $this->form_validation->set_rules('idkota', 'ID Kota', 'required');
    //     $this->form_validation->set_message('required', '%s tidak valid');
    //     $this->form_validation->set_error_delimiters('', '');

    //     if ($this->form_validation->run() == true) {

    //             $get_kota = $this->Api_model->get_kecamatan_mhs($idkota);
    //             if($get_kota!=null){
    //                 $success = true;
    //                 $message = "List kecamatan ditemukan";
    //                 $data = $get_kota;
    //             }else{
    //                 $success = false;
    //                 $message = "Tidak dapat menemukan list kecamatan";
    //                 $data = null;
    //             }

    //     }else{
    //         $idkota_err = form_error('idkota') ? form_error('idkota') : null;
    //         $success = false;
    //         $message = $idkota_err;
    //         $data = null;
    //     }

    //     $this->response([
    //         'success' => $success,
    //         'message' => $message,
    //         'data' => $data

    //     ], REST_Controller_Smartmobile::HTTP_OK);

    // }





    private function cid_app()
    {
        return "smartajib";
    }

    private function cis_app()
    {
        return "kerenbro";
    }


    private function cid_reset_pas()
    {
        return "madsggk";
    }

    private function cis_reset_pas()
    {
        return "madslovelove";
    }

    public function email_check()
    {
        $email = BniEnc::decrypt_string($this->input->post("uemail"), $this->cid_app(), $this->cis_app());
        $cek = $this->Api_model->cek_exist_email($email);
        if (!$cek) {
            $this->form_validation->set_message('email_check', 'Email telah digunakan oleh user lain.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function th_smt_mhs_by_smt($smtawlmhs, $smt)
    {

        $tahun = substr($smtawlmhs, 0, 4);

        if ($smt > 2) {
            $tahun_ke = ceil($smt / 2) - 1;
            $semester_ke = $smt % 2;

            //var_dump($semester_ke);

            $tahun =  $tahun + $tahun_ke;

            if ($semester_ke == 0) {
                $thsmt = $tahun . '2';
            } else {
                $thsmt = $tahun . '1';
            }
        } else {
            if ($smt == 1) {
                $thsmt = $smtawlmhs;
            } else {
                $thsmt = $tahun . '2';
            }
        }



        return $thsmt;
    }

    private function smt_mhs_by_th_smt($thmsk, $thsmt)
    {

        if ($thsmt % 2 != 0) {
            $a = (($thsmt + 10) - 1) / 10;
            $b = $a - $thmsk;
            $c = ($b * 2) - 1;
            $semester_mhs = $c;
        } else {
            $a = (($thsmt + 10) - 2) / 10;
            $b = $a - $thmsk;
            $c = $b * 2;
            $semester_mhs = $c;
        }

        return $semester_mhs;
    }

    private function nama_dosen_dg_gelar($dosen, $gelar)
    {

        $pecahgelar = explode(' ', $gelar);
        $jumarray = count($pecahgelar);


        if ((substr($pecahgelar[0], 0, 4) == 'Prof') and (substr($pecahgelar[1], 0, 2) == 'Dr')) {
            $dosen = $pecahgelar[0] . ' ' . $pecahgelar[1] . ' ' . $dosen;
            for ($x = 2; $x < $jumarray; $x++) {
                $dosen = $dosen . ' ' . $pecahgelar[$x];
            }
        } else if ((substr($pecahgelar[0], 0, 2) == 'Dr') or (substr($pecahgelar[0], 0, 2) == 'Ir') or (substr($pecahgelar[0], 0, 2) == 'dr')) {
            $dosen = $pecahgelar[0] . ' ' . $dosen;
            for ($x = 1; $x < $jumarray; $x++) {
                $dosen = $dosen . ' ' . $pecahgelar[$x];
            }
        } else {
            for ($x = 0; $x < $jumarray; $x++) {
                $dosen = $dosen . ' ' . $pecahgelar[$x];
            }
        }

        return $dosen;
    }

    private function thsmt_min_1($thsmt)
    {
        $jenis_semester = substr($thsmt, 4, 1);
        $th = substr($thsmt, 0, 4);

        if ($jenis_semester == 1) {
            $semester_sebelumnya = ($th - 1) . "2";
        } else {
            $semester_sebelumnya = $th . "1";
        }

        return $semester_sebelumnya;
    }

    private function send_email($email_penerima, $text_email, $subject)
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('email');

        //konfigurasi email
        $config = array();
        $config['charset'] = 'utf-8';
        $config['useragent'] = 'Codeigniter';
        $config['protocol'] = "smtp";
        $config['mailtype'] = "html";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = 465;
        $config['smtp_timeout'] = "5";
        $config['smtp_user'] = "smart@iainsalatiga.ac.id";
        $config['smtp_pass'] = "1a1nsala3@smart";
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";

        $config['wordwrap'] = TRUE;


        $this->email->initialize($config);
        $this->email->from("smart@iainsalatiga.ac.id");
        $this->email->to($email_penerima);
        $this->email->subject($subject);
        $this->email->message($text_email);


        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }



    private function decrypt_post()
    {

        $string = $this->post('enc');
        $a = BniEnc::decrypt_string($string, $this->cid_app(), $this->cis_app());

        // $b =BniEnc::encrypt_string("123ayubayub", $this->cid_app(), $this->cis_app());


        var_dump($a);
    }

    public function time_to_date_get($mytimestamp)
    {

        echo date("d F Y H:i", $mytimestamp);
    }
}
