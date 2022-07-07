<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SMART IAIN Salatiga</title>
    <link href="<?php echo base_url(); ?>assets/sb_admin_pro/dist/css/styles.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/dataTables.bootstrap4.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/daterangepicker.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/sb_admin_pro/dist/assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/all.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/feather.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/jquery-3.5.1.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/bootstrap.bundle.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/dist/js/scripts.js"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/Chart.js" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/chartjs-plugin-datalabels@0.7.0.js"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/jquery.dataTables.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/dataTables.bootstrap4.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/dist/assets/demo/datatables-demo.js"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/moment.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/daterangepicker.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/dist/assets/demo/date-range-picker-demo.js"></script>
</head>

<body class="">
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
        <!-- Navbar Brand-->
        <!-- * * Tip * * You can use text or an image for your navbar brand.-->
        <!-- * * * * * * When using an image, we recommend the SVG format.-->
        <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
        <a href="<?php echo base_url(); ?>">
            <img class="img-fluid ml-2" src="<?php echo base_url("media/images/logosmart/smart.svg"); ?>" style="max-width: 240px; max-height:32px;" />
        </a>
        <!-- Navbar Items-->
        <ul class="navbar-nav align-items-center ml-auto">

            <!-- Navbar Search Dropdown-->
            <!-- Alerts Dropdown-->
            <!-- <li class="nav-item dropdown no-caret d-none d-sm-block mr-3 dropdown-notifications">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="bell"></i></a>
                <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">
                    <h6 class="dropdown-header dropdown-notifications-header">
                        <i class="mr-2" data-feather="bell"></i>
                        Alerts Center
                    </h6>
                    
                    <a class="dropdown-item dropdown-notifications-item" href="#!">
                        <div class="dropdown-notifications-item-icon bg-warning"><i data-feather="activity"></i></div>
                        <div class="dropdown-notifications-item-content">
                            <div class="dropdown-notifications-item-content-details">December 29, 2020</div>
                            <div class="dropdown-notifications-item-content-text">This is an alert message. It's nothing serious, but it requires your attention.</div>
                        </div>
                    </a>
                  
                    <a class="dropdown-item dropdown-notifications-item" href="#!">
                        <div class="dropdown-notifications-item-icon bg-info"><i data-feather="bar-chart"></i></div>
                        <div class="dropdown-notifications-item-content">
                            <div class="dropdown-notifications-item-content-details">December 22, 2020</div>
                            <div class="dropdown-notifications-item-content-text">A new monthly report is ready. Click here to view!</div>
                        </div>
                    </a>
                  
                    <a class="dropdown-item dropdown-notifications-item" href="#!">
                        <div class="dropdown-notifications-item-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="dropdown-notifications-item-content">
                            <div class="dropdown-notifications-item-content-details">December 8, 2020</div>
                            <div class="dropdown-notifications-item-content-text">Critical system failure, systems shutting down.</div>
                        </div>
                    </a>
                 
                    <a class="dropdown-item dropdown-notifications-item" href="#!">
                        <div class="dropdown-notifications-item-icon bg-success"><i data-feather="user-plus"></i></div>
                        <div class="dropdown-notifications-item-content">
                            <div class="dropdown-notifications-item-content-details">December 2, 2020</div>
                            <div class="dropdown-notifications-item-content-text">New user request. Woody has requested access to the organization.</div>
                        </div>
                    </a>
                    <a class="dropdown-item dropdown-notifications-footer" href="#!">View All Alerts</a>
                </div>
            </li> -->
            <!-- Messages Dropdown-->
            <?php
            if ($this->session->userdata('user_is_login') == TRUE) {

            ?>
                <li class="nav-item dropdown no-caret d-sm-block mr-3 dropdown-notifications">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownMessages" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <!-- <i class="fa fa-th"></i> -->
                        <img class="img-fluid" alt="Responsive image" src=" <?php echo base_url(); ?>media/images/logoaplikasi/apps-default.svg" style="width:15px; height:15px;">
                    </a>
                    <div class="dropdown-menu dropdown-notifications border-0 shadow animated--fade-in-up rounded-0" aria-labelledby="navbarDropdownMessages">
                        <h6 class="dropdown-header-listapp dropdown-notifications-header">
                            <img class="img-fluid mr-2" alt="Responsive image" src=" <?php echo base_url(); ?>media/images/logoaplikasi/apps-white.svg" style="width:15px; height:15px;">
                            <!-- <i class="mr-2 fa fa-th"></i> -->
                            APP IAIN Salatiga
                        </h6>
                        <!-- Example Message 1  -->
                        <div class="containter">
                            <div class="ml-1 mr-1" id="list_app">
                            </div>


                        </div>


                        <!-- Footer Link-->
                        <div class="dropdown-notifications-footer text-center pl-3 pr-3">
                            <!-- <a class="btn btn-outline-primary" href="#!">
                            <p class="text-center mb-0">Lainya dari IAIN Smart</p>
                           
                        </a> -->
                        </div>

                    </div>
                </li>
            <?php
            }
            ?>
            <!-- User Dropdown-->
            <?php
            if ($this->session->userdata('user_is_login') == FALSE) {
            ?>
                <li class="nav-item no-caret mr-3 mr-lg-0 dropdown-user">
                    <a class="btn btn-sm btn-outline-primary rounded-0" href="<?php echo base_url('smart_auth') ?>" role="button">
                        <i class="fa fa-user-circle mr-1"></i>Login
                    </a>
                </li>
            <?php
            } else {
            ?>
                <li class="nav-item dropdown no-caret mr-3 mr-lg-0 dropdown-user">
                    <?php
                    if ($this->session->userdata('user_is_login') == true) {
                        if ($this->session->userdata('tipe_akun') == 'mhs') {
                            $src_source = base_url('media/images/foto_mhs_users_smart/' . $this->session->userdata('username') . '.png');
                            if (@getimagesize($src_source)) {
                                $src_prfile = base_url('media/images/foto_mhs_users_smart/' . $this->session->userdata('username') . '.png');
                            } else {
                                $src_prfile = base_url("assets/sb_admin_pro/dist/assets/img/illustrations/profiles/profile-1.png");
                            }
                        } elseif ($this->session->userdata('tipe_akun') == 'sispt') {
                            $src_source = base_url('media/images/foto_sispt_users_smart/' . $this->session->userdata('username') . '.png');
                            if (@getimagesize($src_source)) {
                                $src_prfile = base_url('media/images/foto_sispt_users_smart/' . $this->session->userdata('username') . '.png');
                            } else {
                                $src_prfile = base_url("assets/sb_admin_pro/dist/assets/img/illustrations/profiles/profile-1.png");
                            }
                        } else {
                            $src_prfile = base_url("assets/sb_admin_pro/dist/assets/img/illustrations/profiles/profile-1.png");
                        }
                    } else {
                        $src_prfile = base_url("assets/sb_admin_pro/dist/assets/img/illustrations/profiles/profile-1.png");
                    }
                    ?>
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img id="topbarprofile" class="img-fluid NO-CHACE" src="<?php echo $src_prfile ?>" /></a>
                    <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up rounded-0" aria-labelledby="navbarDropdownUserImage">
                        <h6 class="dropdown-header d-flex align-items-center">
                            <img class="dropdown-user-img NO-CHACE" id="sub_topbarprofile" src="<?php echo $src_prfile ?>" />
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name"><?php echo $this->session->userdata('nama_lengkap') ?></div>
                                <div class="dropdown-user-details-email"><?php echo $this->session->userdata('username') ?></div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <?php
                        if ($this->session->userdata('tipe_akun') == 'mhs') {
                            $link_pengaturan_akun = 'smart_mhs/profil';
                        } else {
                            $link_pengaturan_akun = 'smart_sispt/profil';
                        }
                        ?>
                        <a class="dropdown-item" href="<?php echo base_url($link_pengaturan_akun) ?>">
                            <div class="dropdown-item-icon"><i class="fa fa-cog"></i></div>
                            Pengaturan Akun
                        </a>
                        <a class="dropdown-item" href="<?php echo base_url('smart_auth/logout') ?>">
                            <div class="dropdown-item-icon"><i class="fas fa-sign-out-alt"></i></div>
                            Logout
                        </a>
                    </div>
                </li>
            <?php
            }
            ?>
        </ul>
    </nav>

    <main>
        <!-- letakan konten disini -->
        <?php
        if (!empty($page)) {
            $this->load->view($page);
        } else {
            $this->load->view('layouts/not_found');
        }
        ?>
    </main>
    <footer class="footer mt-auto footer-light">
        <div class="container-fluid">
            <div class="text-center small">Copyright &copy; Teknologi Informasi dan Pangkalan Data IAIN Salatiga <?php echo date('Y') ?></div>
        </div>
    </footer>


    <script type="text/javascript">
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url() ?>Setting_view/setting_app_list?id=menu_top_smart',
            success: function(html) {
                $("#list_app").html(html);
            }
        })
    </script>

</body>

</html>