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
    <!-- Smart APP-->
    <div class="row">
        <div class="col-xl-8">
            <?php echo file_exists('/user01/work/gfg.txt'); ?>
            <div class="row">
                <!-- <div class="col-xl-12">
                    <div class="d-flex justify-content-beetwen align-items-sm-center align-items-xl-right flex-column flex-sm-row mb-4">
                        <div class="ml-2 mb-3 mb-sm-0">
                            <h1 class="mb-0">APP IAIN Salatiga</h1>
                        </div>
                    </div>
                    <div class="row" id="menu_smart">

                    </div>
                </div> -->

                <div class="col-xl-12">
                    <div id="menu_smart">
                        <div class=" d-flex justify-content-beetwen align-items-sm-center align-items-xl-right flex-column flex-sm-row ">
                            <div class="col-9">
                                <h1 class="mb-0">App IAIN Salatiga</h1>
                            </div>
                            <div class="col-3 text-right">
                                <button class="btn btn-link rounded-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fas fa-angle-down"></i>
                                </button>
                            </div>
                        </div>
                        <hr class="mt-2 mb-4" />

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#menu_smart">

                            <div class="row">
                                <div class="col-xl-4 mb-4">
                                    <a class="card lift h-100 rounded-0" href="http://eclass.iainsalatiga.ac.id">
                                        <div class="card-title-menu-smart justify-content-center">
                                            <h5>ECLASS</h5>
                                        </div>
                                        <div class="card-body-menu-smart d-flex justify-content-center flex-column">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-3">
                                                    <div class="text-muted small">Eclass adalah aplikasi milik IAIN Salatiga yang digunakan untuk .</div>
                                                </div>
                                                <img class="img-fluid mb-2" src="http://localhost/service_iain/media/images/logoaplikasi/default.svg" style="width: 5rem">
                                            </div>
                                        </div>

                                    </a>
                                </div>
                                <div class="col-xl-4 mb-4">
                                    <a class="card lift h-100 rounded-0" href="http://localhost/edom">
                                        <div class="card-title-menu-smart justify-content-center">
                                            <h5>EDOM</h5>
                                        </div>
                                        <div class="card-body-menu-smart d-flex justify-content-center flex-column">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-3">
                                                    <div class="text-muted small">EDOM adalah aplikasi milik IAIN Salatiga yang digunakan untuk .</div>
                                                </div>
                                                <img class="img-fluid mb-2" src="http://localhost/service_iain/media/images/logoaplikasi/EDOM.svg" style="width: 5rem">
                                            </div>
                                        </div>

                                    </a>
                                </div>
                                <div class="col-xl-4 mb-4">
                                    <a class="card lift h-100 rounded-0" href="http://localhost/ots">
                                        <div class="card-title-menu-smart justify-content-center">
                                            <h5>OTS</h5>
                                        </div>
                                        <div class="card-body-menu-smart d-flex justify-content-center flex-column">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-3">
                                                    <div class="text-muted small">OTSadalah aplikasi milik IAIN Salatiga yang digunakan untuk .</div>
                                                </div>
                                                <img class="img-fluid mb-2" src="http://localhost/service_iain/media/images/logoaplikasi/OTS.svg" style="width: 5rem">
                                            </div>
                                        </div>

                                    </a>
                                </div>
                                <div class="col-xl-4 mb-4">
                                    <a class="card lift h-100 rounded-0" href="http://siakad.iainsalatiga.ac.id">
                                        <div class="card-title-menu-smart justify-content-center">
                                            <h5>SIAKAD</h5>
                                        </div>
                                        <div class="card-body-menu-smart d-flex justify-content-center flex-column">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-3">
                                                    <div class="text-muted small">Siakad adalah aplikasi milik IAIN Salatiga yang digunakan untuk .</div>
                                                </div>
                                                <img class="img-fluid mb-2" src="http://localhost/service_iain/media/images/logoaplikasi/default.svg" style="width: 5rem">
                                            </div>
                                        </div>

                                    </a>
                                </div>
                                <div class="col-xl-4 mb-4">
                                    <a class="card lift h-100 rounded-0" href="http://localhost/si-mona">
                                        <div class="card-title-menu-smart justify-content-center">
                                            <h5>SIMONA</h5>
                                        </div>
                                        <div class="card-body-menu-smart d-flex justify-content-center flex-column">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-3">
                                                    <div class="text-muted small">SIMONA adalah aplikasi milik IAIN Salatiga yang digunakan untuk .</div>
                                                </div>
                                                <img class="img-fluid mb-2" src="http://localhost/service_iain/media/images/logoaplikasi/SIMONA.svg" style="width: 5rem">
                                            </div>
                                        </div>

                                    </a>
                                </div>
                                <div class="col-xl-4 mb-4">
                                    <a class="card lift h-100 rounded-0" href="http://localhost/siska">
                                        <div class="card-title-menu-smart justify-content-center">
                                            <h5>SISKA</h5>
                                        </div>
                                        <div class="card-body-menu-smart d-flex justify-content-center flex-column">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-3">
                                                    <div class="text-muted small">SISKA adalah aplikasi milik IAIN Salatiga yang digunakan untuk .</div>
                                                </div>
                                                <img class="img-fluid mb-2" src="http://localhost/service_iain/media/images/logoaplikasi/SISKA.svg" style="width: 5rem">
                                            </div>
                                        </div>

                                    </a>
                                </div>
                            </div>

                        </div>
                        
                        <div class=" d-flex justify-content-beetwen align-items-sm-center align-items-xl-right flex-column flex-sm-row ">
                            <div class="col-9">
                                <h1 class="mb-0">App IAIN Salatiga</h1>
                            </div>
                            <div class="col-3 text-right">
                                <button class="btn btn-link rounded-0" data-toggle="collapse" data-target="#collapsetwo" aria-expanded="false" aria-controls="collapseOne">
                                    <i class="fas fa-angle-down"></i>
                                </button>
                            </div>
                        </div>
                        <hr class="mt-2 mb-4" />

                        <div id="collapsetwo" class="collapse" aria-labelledby="headingOne" data-parent="#menu_smart">
                            <div class="row">
                                <div class="col-xl-4 mb-4">
                                    <a class="card lift h-100 rounded-0" href="http://eclass.iainsalatiga.ac.id">
                                        <div class="card-title-menu-smart justify-content-center">
                                            <h5>ECLASS</h5>
                                        </div>
                                        <div class="card-body-menu-smart d-flex justify-content-center flex-column">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-3">
                                                    <div class="text-muted small">Eclass adalah aplikasi milik IAIN Salatiga yang digunakan untuk .</div>
                                                </div>
                                                <img class="img-fluid mb-2" src="http://localhost/service_iain/media/images/logoaplikasi/default.svg" style="width: 5rem">
                                            </div>
                                        </div>

                                    </a>
                                </div>
                                <div class="col-xl-4 mb-4">
                                    <a class="card lift h-100 rounded-0" href="http://localhost/edom">
                                        <div class="card-title-menu-smart justify-content-center">
                                            <h5>EDOM</h5>
                                        </div>
                                        <div class="card-body-menu-smart d-flex justify-content-center flex-column">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-3">
                                                    <div class="text-muted small">EDOM adalah aplikasi milik IAIN Salatiga yang digunakan untuk .</div>
                                                </div>
                                                <img class="img-fluid mb-2" src="http://localhost/service_iain/media/images/logoaplikasi/EDOM.svg" style="width: 5rem">
                                            </div>
                                        </div>

                                    </a>
                                </div>
                                <div class="col-xl-4 mb-4">
                                    <a class="card lift h-100 rounded-0" href="http://localhost/ots">
                                        <div class="card-title-menu-smart justify-content-center">
                                            <h5>OTS</h5>
                                        </div>
                                        <div class="card-body-menu-smart d-flex justify-content-center flex-column">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-3">
                                                    <div class="text-muted small">OTSadalah aplikasi milik IAIN Salatiga yang digunakan untuk .</div>
                                                </div>
                                                <img class="img-fluid mb-2" src="http://localhost/service_iain/media/images/logoaplikasi/OTS.svg" style="width: 5rem">
                                            </div>
                                        </div>

                                    </a>
                                </div>
                                <div class="col-xl-4 mb-4">
                                    <a class="card lift h-100 rounded-0" href="http://siakad.iainsalatiga.ac.id">
                                        <div class="card-title-menu-smart justify-content-center">
                                            <h5>SIAKAD</h5>
                                        </div>
                                        <div class="card-body-menu-smart d-flex justify-content-center flex-column">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-3">
                                                    <div class="text-muted small">Siakad adalah aplikasi milik IAIN Salatiga yang digunakan untuk .</div>
                                                </div>
                                                <img class="img-fluid mb-2" src="http://localhost/service_iain/media/images/logoaplikasi/default.svg" style="width: 5rem">
                                            </div>
                                        </div>

                                    </a>
                                </div>
                                <div class="col-xl-4 mb-4">
                                    <a class="card lift h-100 rounded-0" href="http://localhost/si-mona">
                                        <div class="card-title-menu-smart justify-content-center">
                                            <h5>SIMONA</h5>
                                        </div>
                                        <div class="card-body-menu-smart d-flex justify-content-center flex-column">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-3">
                                                    <div class="text-muted small">SIMONA adalah aplikasi milik IAIN Salatiga yang digunakan untuk .</div>
                                                </div>
                                                <img class="img-fluid mb-2" src="http://localhost/service_iain/media/images/logoaplikasi/SIMONA.svg" style="width: 5rem">
                                            </div>
                                        </div>

                                    </a>
                                </div>
                                <div class="col-xl-4 mb-4">
                                    <a class="card lift h-100 rounded-0" href="http://localhost/siska">
                                        <div class="card-title-menu-smart justify-content-center">
                                            <h5>SISKA</h5>
                                        </div>
                                        <div class="card-body-menu-smart d-flex justify-content-center flex-column">
                                            <div class="d-flex align-items-center justify-content-start">
                                                <div class="mr-3">
                                                    <div class="text-muted small">SISKA adalah aplikasi milik IAIN Salatiga yang digunakan untuk .</div>
                                                </div>
                                                <img class="img-fluid mb-2" src="http://localhost/service_iain/media/images/logoaplikasi/SISKA.svg" style="width: 5rem">
                                            </div>
                                        </div>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="col-xl-12" id="menu_smart">

                </div> -->

                <div class="col-xl-12">
                    <div class="d-flex justify-content-beetwen align-items-sm-center align-items-xl-right flex-column flex-sm-row mb-4">
                        <div class="ml-2 mb-3 mb-sm-0">
                            <h1 class="mb-0">Statistik Mahasiswa IAIN Salatiga</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 mb-4">
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
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xl-4">
            <div class="d-flex justify-content-beetwen align-items-sm-center align-items-xl-right flex-column flex-sm-row mb-4">
                <div class="ml-2 mb-3 mb-sm-0">
                    <h1 class="mb-0">Informasi Terbaru</h1>
                </div>
            </div>
            <div class="row" id="pengumuman_smart">
                <div class="col-12">
                    <div class="card rounded-0 h-100">
                        <div class="card-body mt-2 pb-0">

                            <div class="input-group input-group-solid">
                                <input id="input_cari_pengumuman" class="form-control mr-2 rounded-0" type="search" placeholder="Cari" aria-label="Search" />
                                <button id="button_cari_pengumuman" class="btn btn-primary rounded-0" onclick="cari_pengumuman()"><i class="fa fa-search "></i></button>
                            </div>


                        </div>
                        <div class="card-body px-3">
                            <div class="scroll_smart">
                                <div class="d-flex justify-content-center">
                                    <div id="loader">
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
                                </div>
                                <div class="timeline timeline-xs" id="info_smart">
                                    <!-- <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-text">27 min</div>
                                        <div class="timeline-item-marker-indicator bg-green"></div>
                                    </div>
                                    <div class="timeline-item-content">
                                        New order placed!
                                        <a class="font-weight-bold text-dark" href="#!">Order #2912</a>
                                        has been successfully placed.
                                    </div>
                                </div>
                                
                                <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-text">58 min</div>
                                        <div class="timeline-item-marker-indicator bg-blue"></div>
                                    </div>
                                    <div class="timeline-item-content">
                                        Your
                                        <a class="font-weight-bold text-dark" href="#!">weekly report</a>
                                        has been generated and is ready to view.
                                    </div>
                                </div>
                                
                                <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-text">2 hrs</div>
                                        <div class="timeline-item-marker-indicator bg-purple"></div>
                                    </div>
                                    <div class="timeline-item-content">
                                        New user
                                        <a class="font-weight-bold text-dark" href="#!">Valerie Luna</a>
                                        has registered
                                    </div>
                                </div>
                                
                                <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-text">1 day</div>
                                        <div class="timeline-item-marker-indicator bg-yellow"></div>
                                    </div>
                                    <div class="timeline-item-content">Server activity monitor alert</div>
                                </div>
                                
                                <div class="timeline-item">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-text">1 day</div>
                                        <div class="timeline-item-marker-indicator bg-green"></div>
                                    </div>
                                    <div class="timeline-item-content">
                                        New order placed!
                                        <a class="font-weight-bold text-dark" href="#!">Order #2911</a>
                                        has been successfully placed.
                                    </div>
                                </div> -->
                                </div>
                            </div>

                        </div>
                        <div class="card-title-menu-smart pb-4 pt-0">
                            <div class="float-left">
                                <div class="mr-3 mt-2">
                                    <div class="text-muted small" id="info_total_data">Menampilkan 1 sampai 10 dari 1000.</div>
                                </div>
                            </div>

                            <div class="float-right">
                                <button id="next" class="btn btn btn-primary rounded-0" onclick="load_next_pengumuman()" type="submit"> <i class="fas fa-angle-double-left"></i> </button>
                                <button id="prev" class="btn btn btn-primary rounded-0" onclick="load_prev_pengumuman()" type="submit"><i class="fas fa-angle-double-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>

<script type="text/javascript">
    //menu smart
    $.ajax({
        type: 'GET',
        url: '<?php echo base_url() ?>Setting_view/setting_app_list?id=menu_home_smart',
        success: function(html) {
            $("#menu_smart").html(html);
        }
    })

    //pengumuman
    var limit = 10;
    var start = 0;
    var key = "";
    var total_record = null;

    load_pengumuman();

    function load_pengumuman() {
        //console.clear();
        $.ajax({
            type: 'POST',
            headers: {
                "cache-control": "no-cache"
            },
            url: '<?php echo base_url() ?>Setting_view/get_pengumuman',
            beforeSend: function() {
                // Show image container
                $("#loader").show();
                $("#info_smart").html("");
            },
            data: {
                'limit': limit,
                'start': start,
                'key': key
            },
            dataType: "json",
            success: function(data) {
                total_record = data.total;

                $("#info_smart").html(data.view);

                if (total_record <= 10) {
                    document.getElementById("prev").disabled = true;
                } else if ((total_record - start) <= 10) {
                    document.getElementById("prev").disabled = true;
                } else {
                    document.getElementById("prev").disabled = false;
                }
                //console.log("jumlah data=" + data.total);

            },
            error: function() {
                document.getElementById("next").disabled = true;
                document.getElementById("prev").disabled = true;
                $("#info_smart").html("Error Function Ajax");
                $("#loader").hide();
            },
            complete: function(data) {
                // Hide image container
                $("#loader").hide();
                if (total_record > 0) {
                    var max_show = null;
                    var min_show = start + 1;
                    if (total_record > (start + 11)) {
                        max_show = start + 11;
                    } else {
                        max_show = total_record;
                    }
                    $("#info_total_data").html("Menampilkan " + min_show + " sampai " + max_show + " dari " + total_record);
                } else {
                    $("#info_total_data").html("Tidak ada yang bisa ditampilkan");
                }

            }
        })
    }

    function load_prev_pengumuman() {
        start = start + 10;
        document.getElementById("next").disabled = false;
        load_pengumuman();
    }

    function load_next_pengumuman() {
        if (start > 0) {
            start = start - 10;
            document.getElementById("next").disabled = false;
            if (start == 0) {
                document.getElementById("next").disabled = true;
            }

            load_pengumuman();
        }
    }

    function cari_pengumuman() {
        //penanganan akibat tombol next pengumuman masih muncul saat keywoard tidak ditemukan
        start = 0;
        document.getElementById("next").disabled = true;

        key = document.getElementById("input_cari_pengumuman").value;
        load_pengumuman();
    }
    //penanganan kalau user tidak klik cari pengumuman tapi langsung enter
    var input = document.getElementById("input_cari_pengumuman");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("button_cari_pengumuman").click();
        }
    });


    if (start == 0) {
        document.getElementById("next").disabled = true;
    }

    //chart1
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


            },
            complete: function(data) {
                // Hide image container
                $("#loader_chart").hide();
                $("#myAreaChart").show();
            }
        });
    }

    load_chart_mhs_all_fak();
</script>
<script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/iain-smart-chart.js"></script>