<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="activity"></i></div>
                        Dashboard
                    </h1>
                    <div class="page-header-subtitle">Sistem Informasi Manajemen Terpadu IAIN Salatiga</div>
                </div>
                <div class="col-12 col-xl-auto mt-4">
                    <button class="btn btn-white rounded-0 p-3">
                        <i class="mr-2 text-primary" data-feather="calendar"></i>
                        <span></span>
                        <div class="text-left">
                            <?php echo date("d F Y"); ?>
                        </div>

                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container mt-n10">
    <div class="row">
        <div class=" col-xl-12 mb-4">
            <div class="card rounded-0 h-100">
                <div class="card-body h-100 d-flex flex-column justify-content-center py-2">
                    <div class="row align-items-center">
                        
                        <div class="col-xl-7 ">
                            <div class="text-xl-left text-sm-center mb-4 mt-4">
                                <h1 class="text-primary">Selamat datang di Single Sign On IAIN Salatiga</h1>
                                <p class="text-gray-700 mb-0">SSO SMART IAIN Salatiga merupakan portal utama yang digunakan untuk mengakses sistem - sistem lain milik IAIN Salatiga dengan menggunakan akun SIAKAD mahasiswa,dosen atau tenaga kependidikan. </p>
                            </div>
                        </div>
                        <div class="col-xl-5 text-center mt-2"><img class="img-fluid" src="<?php echo base_url(); ?>media/images/logosmart/smart.svg" /></div>
                       
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mt-2">
                            <div class="text-xl-right text-sm-center">
                                <p class="my-0 font-italic"><small>Bagi dosen dan tenaga kependidikan untuk membuat akun SIAKAD Anda dapat menghubungi bagian akademik institut.</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Example Colored Cards for Dashboard Demo-->

    <!-- Example Charts for Dashboard Demo-->
    <div class="row">
        <div class="col-xl-4 mb-4">
            <div class="card rounded-0">
                <div class="card-header">

                    <?php echo $judul_chart_mhs_per_smt_all_fak ?>

                </div>
                <div class="card-body">
                    <div class="chart-area"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-8 text-left">
                            <p class="my-0 font-italic"><small>Sumber : <?php echo $sumber_data_siakad ?></small></p>
                        </div>
                        <div class="col-4 text-right">
                            <a class="btn btn-sm btn-outline-primary rounded-0" href="<?php echo base_url('smart/refresh_mhs_aktif_all_fak/?continue=' . current_url()) ?>" role="button">
                                <i class="fa fa-sync mr-1"></i>Refresh Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 mb-4">
            <div class="card rounded-0">
                <div class="card-header">

                    <?php echo $judul_chart_mhs_per_fak ?>

                </div>
                <div class="card-body ">
                    <div class="chart-bar"><canvas id="myBarChart" width="100%" height="30"></canvas></div>
                </div>
                <div class="card-footer text-right">
                    <div class="row">
                        <div class="col-8 text-left">
                            <p class="my-0 font-italic"><small>Sumber : <?php echo $sumber_data_siakad ?></small></p>
                        </div>
                        <div class="col-4 text-right">
                            <a class="btn btn-sm btn-outline-primary rounded-0" href="<?php echo base_url('smart/refresh_mhs_aktif_per_fak/?continue=' . current_url()) ?>" role="button">
                                <i class="fa fa-sync mr-1"></i>Refresh Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 mb-4">
            <!-- Tabbed dashboard card example-->
            <div class="card rounded-0 card-header-actions h-100">
                <div class="card-header ">
                    <div id="label_chart_mhs_aktif_per_prodi"></div>
                    <div class="dropdown no-caret">
                        <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="areaChartDropdownExample" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down text-gray-500"></i></button>
                        <div class="dropdown-menu dropdown-menu-right animated--fade-in-up" aria-labelledby="areaChartDropdownExample">
                            <a class="dropdown-item" href="#!" id="ftik_click">Fakultas Tadris dan Ilmu Keguruan</a>
                            <a class="dropdown-item" href="#!" id="febi_click">Fakultas Ekonomi dan Bisnis Islam</a>
                            <a class="dropdown-item" href="#!" id="fs_click">Fakultas Syariah</a>
                            <a class="dropdown-item" href="#!" id="fd_click">Fakultas Dakwah</a>
                            <a class="dropdown-item" href="#!" id="fuadah_click">Fakultas Ushuluddin Adab dan Humaniora</a>
                            <a class="dropdown-item" href="#!" id="pasca_click">Pascasarjana</a>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="chart-bar"><canvas id="mhs_prodichart" width="100%"></canvas></div>
                </div>
                <div class="card-footer text-right">
                    <div class="row">
                        <div class="col-8 text-left">
                            <p class="my-0 font-italic"><small>Sumber : <?php echo $sumber_data_siakad ?></small></p>
                        </div>
                        <div class="col-4 text-right">
                            <a class="btn btn-sm btn-outline-primary rounded-0" href="<?php echo base_url('smart/refresh_mhs_aktif_per_prodi/?continue=' . current_url()) ?>" role="button">
                                <i class="fa fa-sync mr-1"></i>Refresh Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 mb-4">
            <!-- Tabbed dashboard card example-->
            <div class="card rounded-0">
                <div class="card-header ">
                    <?php echo $judul_chart_dosen_karyawan ?>
                </div>
                <div class="card-body">
                    <div class="chart-bar ml-1"><canvas id="dosen_karyawan" width="100%"></canvas></div>
                </div>
                <div class="card-footer text-right">
                    <div class="row">
                        <div class="col-8 text-left">
                            <p class="my-0 font-italic"><small>Sumber : <?php echo $sumber_data_simpis ?></small></p>
                        </div>
                        <div class="col-4 text-right">
                            <a class="btn btn-sm btn-outline-primary rounded-0" href="<?php echo base_url('smart/refresh_dosen_karyawan/?continue=' . current_url()) ?>" role="button">
                                <i class="fa fa-sync mr-1"></i>Refresh Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        //chart jumlh mhs aktif all fak
        //label
        var tahun_berjalan = <?php echo $thsmt; ?>;
        var tahun_sebelumnya_1 = tahun_berjalan - 1;
        var tahun_sebelumnya_2 = tahun_berjalan - 2;
        var tahun_sebelumnya_3 = tahun_berjalan - 3;
        var tahun_sebelumnya_4 = tahun_berjalan - 4;      


        var mhs_aktif_ganjil = new Array();
        var mhs_aktif_genap = new Array();

        //dataset
        <?php
        foreach ($mhs_aktif_all_fak as $row) {
            if (substr($row['thsmt'], -1) == 1) {
        ?>
                mhs_aktif_ganjil.push('<?= $row['jumlah']; ?>');
            <?php
            } else {
            ?>
                mhs_aktif_genap.push('<?= $row['jumlah']; ?>');
        <?php
            }
        }
        ?>


        //end chart jumlh mhs aktif all fak



        //chart jumlh mhs aktif per fak
        var mhs_ushuludin = new Array();
        var mhs_dakwah = new Array();
        var mhs_tarbiyah = new Array();
        var mhs_ekonomi = new Array();
        var mhs_syariah = new Array();
        var mhs_pasca = new Array();

        //dataset
        <?php
        foreach ($mhs_aktif_per_fak as $row2) {
            if ('U' == $row2['KDFAKMSFAK']) {
        ?>
                mhs_ushuludin.push('<?= $row2['jumlah']; ?>');
            <?php
            } else if ('T' == $row2['KDFAKMSFAK']) {
            ?>
                mhs_tarbiyah.push('<?= $row2['jumlah']; ?>');
            <?php
            } else if ('D' == $row2['KDFAKMSFAK']) {
            ?>
                mhs_dakwah.push('<?= $row2['jumlah']; ?>');
            <?php
            } else if ('S' == $row2['KDFAKMSFAK']) {
            ?>
                mhs_syariah.push('<?= $row2['jumlah']; ?>');
            <?php
            } else if ('E' == $row2['KDFAKMSFAK']) {
            ?>
                mhs_ekonomi.push('<?= $row2['jumlah']; ?>');
            <?php
            } else if ('PS' == $row2['KDFAKMSFAK']) {
            ?>
                mhs_pasca.push('<?= $row2['jumlah']; ?>');
        <?php
            }
        }
        ?>

        //label
        var label_mhs_aktif_per_fak = new Array();
        <?php
        foreach ($rentang_semester as $row) {

            if (substr($row['thsmt'], -1) == 1) {
                $jenis_semester = 'ganjil';
            } else {
                $jenis_semester = 'genap';
            }
            $th_semester = substr($row['thsmt'], 0, -1);
        ?>
            label_mhs_aktif_per_fak.push('<?= $th_semester . ' ' . $jenis_semester; ?>');
        <?php


        }
        ?>

        //chart jumlah aktif mhs per prodi smt berjalan
        var label_mhs_aktif_per_prodi = "<?php echo $judul_chart_mhs_per_prodi ?>";
        var label_prodi_ftik = new Array();
        var label_prodi_fd = new Array();
        var label_prodi_febi = new Array();
        var label_prodi_fs = new Array();
        var label_prodi_fuadah = new Array();
        var label_prodi_pasca = new Array();
        var mhs_prodi_ftik = new Array();
        var mhs_prodi_febi = new Array();
        var mhs_prodi_fs = new Array();
        var mhs_prodi_fuadah = new Array();
        var mhs_prodi_fd = new Array();
        var mhs_prodi_pasca = new Array();

        <?php
        foreach ($mhs_aktif_per_prodi_smt_berjalan as $row3) {
            if ('T' == $row3['KDFAKMSFAK']) {
        ?>
                label_prodi_ftik.push('<?= $row3['NMPSTMSPST']; ?>');
                mhs_prodi_ftik.push(<?= $row3['jumlah']; ?>);
            <?php
            } else if ('E' == $row3['KDFAKMSFAK']) {
            ?>
                label_prodi_febi.push('<?= $row3['NMPSTMSPST']; ?>');
                mhs_prodi_febi.push(<?= $row3['jumlah']; ?>);
            <?php
            } else if ('S' == $row3['KDFAKMSFAK']) {
            ?>
                label_prodi_fs.push('<?= $row3['NMPSTMSPST']; ?>');
                mhs_prodi_fs.push(<?= $row3['jumlah']; ?>);
            <?php
            } else if ('D' == $row3['KDFAKMSFAK']) {
            ?>
                label_prodi_fd.push('<?= $row3['NMPSTMSPST']; ?>');
                mhs_prodi_fd.push(<?= $row3['jumlah']; ?>);
            <?php
            } else if ('U' == $row3['KDFAKMSFAK']) {
            ?>
                label_prodi_fuadah.push('<?= $row3['NMPSTMSPST']; ?>');
                mhs_prodi_fuadah.push(<?= $row3['jumlah']; ?>);
            <?php
            } else if ('PS' == $row3['KDFAKMSFAK']) {
            ?>
                label_prodi_pasca.push('<?= $row3['NMPSTMSPST']; ?>');
                mhs_prodi_pasca.push(<?= $row3['jumlah']; ?>);
        <?php
            }
        }
        ?>

        // chart jumlah dosen dan karyawan
        var label_pegawai = new Array();
        var jumlah_pegawai = new Array();

        <?php
        foreach ($jmlh_dosen_karyawan as $row4) {
        ?>
            label_pegawai.push('<?= $row4['jenis_pegawai'];?>');
            jumlah_pegawai.push(<?= $row4['jumlah'];?>);
        <?php
        }
        ?>
    </script>

</div>
<script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/iain-smart-chart.js"></script>