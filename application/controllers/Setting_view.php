<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting_view extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        //$this->load->database();
        $this->load->model('view_model');
        $this->load->model('Smart_model');
    }

    public function setting_app_list()
    {
        $tipe_akun = $this->session->userdata('tipe_akun');
        $username = $this->session->userdata('username');
        $id_request = $this->input->get('id');

        $list_kateg = $this->view_model->list_kateg_smart();

        $list_app = $this->view_model->list_app_smart();

        if ($id_request == "menu_top_smart") {
            foreach ($list_kateg as $kateg) {
                echo '<div class="row px-2 py-2">';

                echo '<div class="col-12 text-left px-3"><small>' . $kateg['nama_kategori'] . '</small><hr class="mt-1 mb-0"></div>';
                //echo'<div class="col-12 text-left pl-3"><span class="badge badge-orange">'.$kateg['nama_kategori'].'</span></div>';

                foreach ($list_app as $app) {
                    if ($kateg['id_kategori'] == $app['kategori']) {
                        $src_source = "media/images/logoaplikasi/" . $app['AppName'] . '.svg';
                        if (file_exists($src_source)) {
                            // var_dump(file_exists($src_source));
                            $src_source = base_url("media/images/logoaplikasi/") . $app['AppName'] . '.svg';
                        } else {
                            //  var_dump(file_exists($src_source));
                            $src_source = base_url("media/images/logoaplikasi/default.svg");
                        }
                        echo '
                        <div class="col-4 mt-1 text-center">
                            <a class="btn btn-transparent-dark dropdown-item-listapp" type="button" href="' . $app['redirect_uri'] . '">
                                <div class="row">
                                    <div class="col-12">
                                        <img class="img-fluid" alt="Responsive image" src=" ' . $src_source . '" style="max-width:50px;">
                                    </div>
                                    <div class="col-12 mt-1">
                                        <p class="text-gray-700 mb-0"><small>' . $app['AppName'] . '</small></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        ';
                    }
                }

                echo '</div>';
            }
        } else if ($id_request == "menu_home_smart") {
            $i = 0;

            foreach ($list_kateg as $kateg) {
                $i++;
                if($i==1){
                    $show= 'true';
                    $expand = 'show';
                }else{
                    $show='false';
                    $expand ='';
                }
                echo '
                <div class=" d-flex justify-content-beetwen align-items-sm-center align-items-xl-right flex-column flex-sm-row ">
                            <div class="col-9">
                                <h1 class="mb-0">' . $kateg['nama_kategori'] . '</h1>
                            </div>
                            <div class="col-3 text-right">
                                <button class="btn btn-link rounded-0" data-toggle="collapse" data-target="#collapse'.$i.'" aria-expanded="'.$show.'" aria-controls="collaps'.$i.'">
                                    <i class="fas fa-angle-down"></i>
                                </button>
                            </div>
                </div>
                <hr class="mt-2 mb-4" />
                <div id="collapse'.$i.'" class="collapse '.$expand.'" aria-labelledby="headingOne" data-parent="#menu_smart">
                    <div class="row">
                ';

                foreach ($list_app as $app) {
                    if ($kateg['id_kategori'] == $app['kategori']) {
                        $src_source = "media/images/logoaplikasi/" . $app['AppName'] . '.svg';
                        //echo 'file adlah' . file_exists($src_source);
                        if (file_exists($src_source)) {
                            $src_source = base_url("media/images/logoaplikasi/") . $app['AppName'] . '.svg';
                        } else {
                            $src_source = base_url("media/images/logoaplikasi/default.svg");
                        }
                        echo '
                            <div class="col-xl-4 mb-4">
                                <a class="card lift h-100 rounded-0" href="' . $app['redirect_uri'] . '">
                                    <div class="card-title-menu-smart justify-content-center">
                                        <h5>' . $app['AppName'] . '</h5>
                                    </div>
                                    <div class="card-body-menu-smart d-flex justify-content-center flex-column">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <div class="mr-3">
                                                <div class="text-muted small">' . $app['description_app'] . '.</div>
                                            </div>
                                            <img class="img-fluid mb-2" src="' . $src_source . '" style="width: 5rem" />
                                        </div>
                                    </div>

                                </a>
                            </div>';
                    }
                }

                echo'
                    </div>
                </div>
                ';



                ////////////
                // echo '
                // <div class="d-flex justify-content-beetwen align-items-sm-center align-items-xl-right flex-column flex-sm-row mb-4">
                //         <div class="ml-2 mb-3 mb-sm-0">
                //             <h1 class="mb-0">' . $kateg['nama_kategori'] . '</h1>
                //         </div>
                //     </div>
                // ';

                

                // echo '
                // <div class="row">
                // ';

                // foreach ($list_app as $app) {
                //     if ($kateg['id_kategori'] == $app['kategori']) {
                //         $src_source = "media/images/logoaplikasi/" . $app['AppName'] . '.svg';
                //         //echo 'file adlah' . file_exists($src_source);
                //         if (file_exists($src_source)) {
                //             $src_source = base_url("media/images/logoaplikasi/") . $app['AppName'] . '.svg';
                //         } else {
                //             $src_source = base_url("media/images/logoaplikasi/default.svg");
                //         }
                //         echo '
                //             <div class="col-xl-4 mb-4">
                //                 <a class="card lift h-100 rounded-0" href="' . $app['redirect_uri'] . '">
                //                     <div class="card-title-menu-smart justify-content-center">
                //                         <h5>' . $app['AppName'] . '</h5>
                //                     </div>
                //                     <div class="card-body-menu-smart d-flex justify-content-center flex-column">
                //                         <div class="d-flex align-items-center justify-content-start">
                //                             <div class="mr-3">
                //                                 <div class="text-muted small">' . $app['description_app'] . '.</div>
                //                             </div>
                //                             <img class="img-fluid mb-2" src="' . $src_source . '" style="width: 5rem" />
                //                         </div>
                //                     </div>

                //                 </a>
                //             </div>';
                //     }
                // }

                // echo '
                // </div>
                // ';
            }

            //var_dump($list_app);

            // foreach ($list_app as $app) {
            //     echo '
            //     <div class="col-xl-4 mb-4">
            //         <a class="card lift h-100 rounded-0" href="' . $app['redirect_uri'] . '">
            //             <div class="card-title-menu-smart justify-content-center">
            //                 <h5>' . $app['AppName'] . '</h5>
            //             </div>
            //             <div class="card-body-menu-smart d-flex justify-content-center flex-column">
            //                 <div class="d-flex align-items-center justify-content-start">
            //                     <div class="mr-3">
            //                         <div class="text-muted small">' . $app['description_app'] . '.</div>
            //                     </div>
            //                     <img class="img-fluid mb-2" src="' . base_url("media/images/logoaplikasi/") . $app['AppName'] . '.svg" style="width: 5rem" />
            //                 </div>
            //             </div>

            //         </a>
            //     </div>';
            // }
        }
    }

    public function get_pengumuman()
    {
        $i = 0;

        if ($this->input->post('limit') == "") {
            $limit = 5;
        } else {
            $limit = $this->input->post('limit');
        }

        if ($this->input->post('start') == "") {
            $start = 0;
        } else {
            $start = $this->input->post('start');
        }


        $start = $this->input->post('start');
        $key = $this->input->post('key');
        //$key ="xxxxw";

        $pengumuman = $this->view_model->get_pengumuman($limit, $start, $key, 1);
        $totalpengumuman = $this->view_model->get_pengumuman($limit, $start, $key, 2);

        //var_dump($totalpengumuman);


        if ($totalpengumuman > 0) {
            foreach ($pengumuman as $row) {
                $preg_link = preg_replace('/[^a-z\d ]/i', '', $row->judul);
                $str_link = str_replace(' ', '-', $preg_link);
                $link = "https://siakad.iainsalatiga.ac.id/baa/index.php/newsdetail/" . $row->idpengumuman . "-" . $str_link;
                if ($i == 0 && $start == 0 && $key == "") {
                    //     echo '
                    //     <div class="timeline-item">
                    //         <div class="timeline-item-marker">
                    //             <div class="timeline-item-marker-text">' . $row->tanggal_ind . '</div>
                    //             <div class="timeline-item-marker-indicator bg-green"></div>
                    //         </div>
                    //         <div class="timeline-item-content">
                    //             <a class="font-weight-normal text-muted" href="#!">' . $row->judul . '</a>
                    //         </div>
                    //     </div>
                    // ';
                    $view[] = '
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">' . $row->tanggal_ind . '</div>
                                <div class="timeline-item-marker-indicator bg-green"></div>
                            </div>
                            <div class="timeline-item-content line_pengumuman_smart">
                               
                                    <a class="font-weight-normal text-muted" href="#!" onClick=MyWindow=window.open("' . $link . '/?layout=free","MyWindow","width=900,height=600"); return false;">' . $row->judul . '</a>
                                
                            </div>
                        </div>
                    ';
                } else {
                    //     echo '
                    //     <div class="timeline-item">
                    //         <div class="timeline-item-marker">
                    //             <div class="timeline-item-marker-text">' . $row->tanggal_ind . '</div>
                    //             <div class="timeline-item-marker-indicator bg-yellow"></div>
                    //         </div>
                    //         <div class="timeline-item-content">
                    //             <a class="font-weight-normal text-muted" href="#!">' . $row->judul . '</a>
                    //         </div>
                    //     </div>
                    // ';
                    $view[] = '
                    <div class="timeline-item">
                        <div class="timeline-item-marker">
                            <div class="timeline-item-marker-text">' . $row->tanggal_ind . '</div>
                            <div class="timeline-item-marker-indicator bg-yellow"></div>
                        </div>
                        <div class="timeline-item-content">
                            
                                <a class="font-weight-normal text-muted" href="#!"  onClick=MyWindow=window.open("' . $link . '/?layout=free","MyWindow","width=900,height=600"); return false;">' . $row->judul . '</a>
                           
                        </div>
                    </div>
                ';
                }
                $i++;
            }


            $param = array("total" => $totalpengumuman, "view" => $view);
            echo json_encode($param);
        } else {
            $view = '
            <div class="row align-items-center mt-5" style="height:20rem">
               
                <div class="col-xxl-12 mt-0 text-center">
                    <span style="font-size:100px;">&#128543;</span>
                    <p class="text-mute-700 mb-0">Keywoard Tidak Ditemukan</p>
                </div>
            </div>
                ';
            $param = array("total" => $totalpengumuman, "view" => $view);
            echo json_encode($param);
        }
    }

    public function get_data_chart_mhs_all_fak()
    {
        $refresh = $this->input->get('refresh');
        if ($refresh == 1) {
            $array_items = array('mhs_aktif_all_fak');
            $this->session->unset_userdata($array_items);
            $this->set_json_parameter_chart_mhs_all_fak();
        } else {
            $this->set_json_parameter_chart_mhs_all_fak();
        }
    }

    private function set_json_parameter_chart_mhs_all_fak()
    {
        $tahunsmtsiakad = $this->Smart_model->cek_thsmt_siakad();
        $thsmt_berjalan = substr($tahunsmtsiakad['conf_keyval'], 0, -1); //menghilangkan string terakhir dan dapat tahunya


        //================data untuk chart mhs aktif all fakultas 5 thn terakhir
        $th_smt_max = $thsmt_berjalan . '2';
        $th_smt_min = ($thsmt_berjalan - 4) . '1';
        $data['judul_chart_mhs_per_smt_all_fak'] = 'Jumlah Mahasiswa Aktif';
        if ($this->session->userdata('mhs_aktif_all_fak') == null) {
            $session_data['mhs_aktif_all_fak'] = $this->Smart_model->cek_mhs_aktif($th_smt_max, $th_smt_min);
            $this->session->set_userdata($session_data);
            $value_mhs_all_fak = $this->session->userdata('mhs_aktif_all_fak');
        } else {
            $value_mhs_all_fak = $this->session->userdata('mhs_aktif_all_fak');
        }

        $jumlah_tahun_smt = count($value_mhs_all_fak) / 2;

        for ($x = 0; $x < $jumlah_tahun_smt;) {
            $x++;
            $tahun[] = ($thsmt_berjalan - $jumlah_tahun_smt) + $x;
        }

        foreach ($value_mhs_all_fak as $row) {
            if (substr($row['thsmt'], -1) == 1) {
                $data_mhs_aktif_ganjil[] = $row['jumlah'];
            } else {
                $data_mhs_aktif_genap[] = $row['jumlah'];
            }
        }

        $param = array("tahun" => $tahun, "mhs_aktif_ganjil" => $data_mhs_aktif_ganjil, "mhs_aktif_genap" => $data_mhs_aktif_genap);
        echo json_encode($param);
    }

    public function get_data_chart_mhs_per_fak()
    {
        $refresh = $this->input->get('refresh');
        if ($refresh == 1) {
            $array_items = array('mhs_aktif_per_fak', 'rentang_semester');
            $this->session->unset_userdata($array_items);
            $this->set_json_parameter_chart_mhs_per_fak();
        } else {
            $this->set_json_parameter_chart_mhs_per_fak();
        }
    }

    private function set_json_parameter_chart_mhs_per_fak()
    {
        $tahunsmtsiakad = $this->Smart_model->cek_thsmt_siakad();
        $thsmt_berjalan = substr($tahunsmtsiakad['conf_keyval'], 0, -1); //menghilangkan string terakhir dan dapat tahunya

        $th_smt_max_per_fak = $tahunsmtsiakad['conf_keyval'];
        if (substr($tahunsmtsiakad['conf_keyval'], -1) == 1) { //jika semester berjalan adalah ganjil
            $th_smt_min_per_fak = ($thsmt_berjalan - 3) . '2';
        } else { //jika semester berjalan adalah genap
            $th_smt_min_per_fak = ($thsmt_berjalan - 2) . '1';
        }
        $data['judul_chart_mhs_per_fak'] = 'Jumlah Mahasiswa Aktif Per Fakultas';
        if ($this->session->userdata('mhs_aktif_per_fak') == null || $this->session->userdata('rentang_semester') == null) {
            $session_data['mhs_aktif_per_fak'] = $this->Smart_model->cek_mhs_aktif_per_fak($th_smt_max_per_fak, $th_smt_min_per_fak);
            $session_data['rentang_semester'] = $this->Smart_model->get_rentang_smt($th_smt_max_per_fak, $th_smt_min_per_fak);
            $this->session->set_userdata($session_data);
            $value_mhs_per_fak = $this->session->userdata('mhs_aktif_per_fak');
            $value_rentang_smt = $this->session->userdata('rentang_semester');
        } else {
            $value_mhs_per_fak = $this->session->userdata('mhs_aktif_per_fak');
            $value_rentang_smt = $this->session->userdata('rentang_semester');
        }


        foreach ($value_mhs_per_fak as $row2) {
            if ('U' == $row2['KDFAKMSFAK']) {
                $fuadah[] = $row2['jumlah'];
            } else if ('T' == $row2['KDFAKMSFAK']) {
                $ftik[] = $row2['jumlah'];
            } else if ('D' == $row2['KDFAKMSFAK']) {
                $fd[] = $row2['jumlah'];
            } else if ('S' == $row2['KDFAKMSFAK']) {
                $fs[] = $row2['jumlah'];
            } else if ('E' == $row2['KDFAKMSFAK']) {
                $febi[] = $row2['jumlah'];
            } else if ('PS' == $row2['KDFAKMSFAK']) {
                $ps[] = $row2['jumlah'];
            }
        }



        foreach ($value_rentang_smt as $row) {
            if (substr($row['thsmt'], -1) == 1) {
                $jenis_semester = 'ganjil';
            } else {
                $jenis_semester = 'genap';
            }
            $th_semester = substr($row['thsmt'], 0, -1);
            $tahun_per_fak[] = $th_semester . ' ' . $jenis_semester;
        }

        $param = array("tahun" => $tahun_per_fak, "mhs_aktif_febi" => $febi, "mhs_aktif_fs" => $fs, "mhs_aktif_fuadah" => $fuadah, "mhs_aktif_ftik" => $ftik, "mhs_aktif_fd" => $fd, "mhs_aktif_pasca" => $ps);
        echo json_encode($param);
    }

    public function get_data_chart_mhs_per_prodi()
    {
        $refresh = $this->input->get('refresh');
        if ($refresh == 1) {
            $array_items = array('mhs_aktif_per_prodi_smt_berjalan');
            $this->session->unset_userdata($array_items);
            $this->set_json_parameter_chart_mhs_per_prodi();
        } else {
            $this->set_json_parameter_chart_mhs_per_prodi();
        }
    }

    private function set_json_parameter_chart_mhs_per_prodi()
    {
        $tahunsmtsiakad = $this->Smart_model->cek_thsmt_siakad();

        if ($this->session->userdata('mhs_aktif_per_prodi_smt_berjalan') == null) {
            $session_data['mhs_aktif_per_prodi_smt_berjalan'] = $this->Smart_model->cek_mhs_aktif_per_prodi($tahunsmtsiakad['conf_keyval']);;
            $this->session->set_userdata($session_data);
            $value_mhs_per_prodi = $this->session->userdata('mhs_aktif_per_prodi_smt_berjalan');
        } else {
            $value_mhs_per_prodi = $this->session->userdata('mhs_aktif_per_prodi_smt_berjalan');
        }
        foreach ($value_mhs_per_prodi as $row3) {
            if ('T' == $row3['KDFAKMSFAK']) {
                $label_ftik[] = $row3['NMPSTMSPST'];
                $mhs_ftik[] = $row3['jumlah'];
            } else if ('D' == $row3['KDFAKMSFAK']) {
                $label_fd[] = $row3['NMPSTMSPST'];
                $mhs_fd[] = $row3['jumlah'];
            } else if ('S' == $row3['KDFAKMSFAK']) {
                $label_fs[] = $row3['NMPSTMSPST'];
                $mhs_fs[] = $row3['jumlah'];
            } else if ('U' == $row3['KDFAKMSFAK']) {
                $label_fuadah[] = $row3['NMPSTMSPST'];
                $mhs_fuadah[] = $row3['jumlah'];
            } else if ('E' == $row3['KDFAKMSFAK']) {
                $label_febi[] = $row3['NMPSTMSPST'];
                $mhs_febi[] = $row3['jumlah'];
            } else if ('PS' == $row3['KDFAKMSFAK']) {
                $label_pasca[] = $row3['NMPSTMSPST'];
                $mhs_pasca[] = $row3['jumlah'];
            }
        }

        $param = array("label_ftik" => $label_ftik, "label_fd" => $label_fd, "label_fs" => $label_fs, "label_fuadah" => $label_fuadah, "label_febi" => $label_febi, "label_pasca" => $label_pasca, "mhs_ftik" => $mhs_ftik, "mhs_ftik" => $mhs_ftik, "mhs_fd" => $mhs_fd, "mhs_febi" => $mhs_febi, "mhs_fs" => $mhs_fs, "mhs_fuadah" => $mhs_fuadah, "mhs_pasca" => $mhs_pasca);
        echo json_encode($param);
    }

    public function get_data_pegawai()
    {
        $refresh = $this->input->get('refresh');
        if ($refresh == 1) {
            $array_items = array('jmlh_dosen_karyawan');
            $this->session->unset_userdata($array_items);
            $this->set_json_parameter_chart_data_pegawai();
        } else {
            $this->set_json_parameter_chart_data_pegawai();
        }
    }

    private function set_json_parameter_chart_data_pegawai()
    {
        if ($this->session->userdata('jmlh_dosen_karyawan') == null) {
            $session_data['jmlh_dosen_karyawan'] = $this->Smart_model->cek_jmlh_dosen_karyawan();
            $this->session->set_userdata($session_data);
            $value_dosen_karyawan = $this->session->userdata('jmlh_dosen_karyawan');
        } else {
            $value_dosen_karyawan = $this->session->userdata('jmlh_dosen_karyawan');
        }

        foreach ($value_dosen_karyawan as $row4) {
            $jenis_pegawai[] = $row4['jenis_pegawai'];
            $jumlah_pegawai[] = $row4['jumlah'];
        }
        $param = array("jenis_pegawai" => $jenis_pegawai, "jumlah" => $jumlah_pegawai);
        echo json_encode($param);
    }
}
