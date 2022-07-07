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
                    <div class="d-flex align-items-center justify-content-center chart-area">
                        <div id="loader_chart">
                            <div class="spinner-grow text-primary mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-secondary mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-success mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-danger mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-warning mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-info mx-1" role="status">

                            </div>
                        </div>
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-8 text-left">
                            <p class="my-0 font-italic"><small>Sumber : <?php echo $sumber_data_siakad ?></small></p>
                        </div>
                        <div class="col-4 text-right">
                            <a class="btn btn-sm btn-outline-primary rounded-0" href="#!" id="refresh_data_chart1" onclick="refresh_chart1()" role="button">
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
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center chart-area">
                        <div id="loader_chart_mhs_per_fak">
                            <div class="spinner-grow text-primary mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-secondary mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-success mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-danger mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-warning mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-info mx-1" role="status">

                            </div>
                        </div>
                        <canvas id="myBarChart"></canvas>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-8 text-left">
                            <p class="my-0 font-italic"><small>Sumber : <?php echo $sumber_data_siakad ?></small></p>
                        </div>
                        <div class="col-4 text-right">
                            <a class="btn btn-sm btn-outline-primary rounded-0" href="#!" id="refresh_data_chart2" onclick="refresh_chart2()" role="button">
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
                    <div class="d-flex align-items-center justify-content-center chart-area">
                        <div id="loader_chart_mhs_per_prodi">
                            <div class="spinner-grow text-primary mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-secondary mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-success mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-danger mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-warning mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-info mx-1" role="status">

                            </div>
                        </div>
                        <canvas id="mhs_prodichart"></canvas>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-8 text-left">
                            <p class="my-0 font-italic"><small>Sumber : <?php echo $sumber_data_siakad ?></small></p>
                        </div>
                        <div class="col-4 text-right">
                            <a class="btn btn-sm btn-outline-primary rounded-0" href="#!" id="refresh_data_chart3" onclick="refresh_chart3()" role="button">
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
                    <div class="d-flex align-items-center justify-content-center chart-area">
                        <div id="loader_chart_data_pegawai">
                            <div class="spinner-grow text-primary mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-secondary mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-success mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-danger mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-warning mx-1" role="status">

                            </div>
                            <div class="spinner-grow text-info mx-1" role="status">

                            </div>
                        </div>
                        <canvas id="dosen_karyawan"></canvas>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-8 text-left">
                            <p class="my-0 font-italic"><small>Sumber : <?php echo $sumber_data_simpis ?></small></p>
                        </div>
                        <div class="col-4 text-right">
                            <a class="btn btn-sm btn-outline-primary rounded-0" href="#!" id="refresh_data_chart4" onclick="refresh_chart4()" role="button">
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
        var tahun_smt_all_fak = [];
        var mhs_aktif_ganjil = [];
        var mhs_aktif_genap = [];
        var refresh = 0;

        function load_chart_mhs_all_fak() {
            $.ajax({
                url: "<?php echo base_url() ?>Setting_view/get_data_chart_mhs_all_fak?refresh=" + refresh,
                method: "GET",
                dataType: "json",
                beforeSend: function() {
                    // Show image container
                    $("#loader_chart").show();
                    $("#myAreaChart").hide();
                },
                success: function(data) {
                    var tahun_chart = data.tahun;
                    //console.log(count.length);
                    tahun_smt_all_fak = tahun_chart;
                    mhs_aktif_ganjil = data.mhs_aktif_ganjil;
                    mhs_aktif_genap = data.mhs_aktif_genap;

                    refresh = 0;
                    chart1();
                    //}

                },
                complete: function(data) {
                    // Hide image container
                    $("#loader_chart").hide();
                    $("#myAreaChart").show();
                }
            });
        }

        load_chart_mhs_all_fak();
        //end chart jumlh mhs aktif all fak

        //chart jumlh mhs aktif per fak
        var label_mhs_aktif_per_fak = [];
        var mhs_ushuludin = [];
        var mhs_dakwah = [];
        var mhs_tarbiyah = [];
        var mhs_ekonomi = [];
        var mhs_syariah = [];
        var mhs_pasca = [];
        var refresh2 = 0;

        function load_chart_mhs_per_fak() {
            $.ajax({
                url: "<?php echo base_url() ?>Setting_view/get_data_chart_mhs_per_fak?refresh=" + refresh2,
                method: "GET",
                dataType: "json",
                beforeSend: function() {
                    // Show image container
                    $("#loader_chart_mhs_per_fak").show();
                    $("#myBarChart").hide();
                },
                success: function(data) {
                    var tahun_chart_per_fak = data.tahun;

                    label_mhs_aktif_per_fak = tahun_chart_per_fak;
                    mhs_ushuludin = data.mhs_aktif_fuadah;
                    mhs_tarbiyah = data.mhs_aktif_ftik;
                    mhs_dakwah = data.mhs_aktif_fd;
                    mhs_syariah = data.mhs_aktif_fs;
                    mhs_ekonomi = data.mhs_aktif_febi;
                    mhs_pasca = data.mhs_aktif_pasca;

                    refresh2 = 0;
                    chart2();

                },
                complete: function(data) {
                    // Hide image container
                    $("#loader_chart_mhs_per_fak").hide();
                    $("#myBarChart").show();
                }
            });
        }

        load_chart_mhs_per_fak();

        //chart jumlah aktif mhs per prodi smt berjalan
        var label_mhs_aktif_per_prodi = "<?php echo $judul_chart_mhs_per_prodi ?>";
        var label_prodi_ftik = [];
        var label_prodi_fd = [];
        var label_prodi_febi = [];
        var label_prodi_fs = [];
        var label_prodi_fuadah = [];
        var label_prodi_pasca = [];
        var mhs_prodi_ftik = [];
        var mhs_prodi_febi = [];
        var mhs_prodi_fs = [];
        var mhs_prodi_fuadah = [];
        var mhs_prodi_fd = [];
        var mhs_prodi_pasca = [];

        var refresh3 = 0;

        function load_chart_mhs_per_prodi() {
            $.ajax({
                url: "<?php echo base_url() ?>Setting_view/get_data_chart_mhs_per_prodi?refresh=" + refresh3,
                method: "GET",
                dataType: "json",
                beforeSend: function() {
                    // Show image container
                    $("#loader_chart_mhs_per_prodi").show();
                    $("#mhs_prodichart").hide();
                },
                success: function(data) {


                    label_prodi_ftik = data.label_ftik;
                    mhs_prodi_ftik = data.mhs_ftik;

                    label_prodi_fd = data.label_fd;
                    mhs_prodi_fd = data.mhs_fd;

                    label_prodi_febi = data.label_febi;
                    mhs_prodi_febi = data.mhs_febi;

                    label_prodi_pasca = data.label_pasca;
                    mhs_prodi_pasca = data.mhs_pasca;

                    label_prodi_fs = data.label_fs;
                    mhs_prodi_fs = data.mhs_fs;

                    label_prodi_fuadah = data.label_fuadah;
                    mhs_prodi_fuadah = data.mhs_fuadah;

                    refresh3 = 0;
                    chart3();
                },
                complete: function(data) {
                    // Hide image container
                    $("#loader_chart_mhs_per_prodi").hide();
                    $("#mhs_prodichart").show();
                }
            });
        }
        load_chart_mhs_per_prodi();
        // chart jumlah dosen dan karyawan
        var label_pegawai = [];
        var jumlah_pegawai = [];
        var refresh4 = 0;

        function load_data_pegawai() {
            $.ajax({
                url: "<?php echo base_url() ?>Setting_view/get_data_pegawai?refresh=" + refresh4,
                method: "GET",
                dataType: "json",
                beforeSend: function() {
                    $("#loader_chart_data_pegawai").show();
                    $("#dosen_karyawan").hide();
                },
                success: function(data) {
                    var total_pegawai = data.jenis_pegawai;

                    label_pegawai = data.jenis_pegawai;
                    jumlah_pegawai = data.jumlah;

                    refresh4 = 0;
                    chart4();
                },
                complete: function(data) {
                    $("#loader_chart_data_pegawai").hide();
                    $("#dosen_karyawan").show();
                }
            });
        }

        load_data_pegawai();
    </script>

</div>
<script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/iain-smart-chart.js"></script>