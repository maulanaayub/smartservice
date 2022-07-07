<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>404 Error Not Found</title>
    <link href="<?php echo base_url(); ?>assets/sb_admin_pro/dist/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/sb_admin_pro/dist/assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/all.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/feather.js" crossorigin="anonymous"></script>
</head>

<body class="bg-white">
    <div id="layoutError">
        <div id="layoutError_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="text-center mt-4">
                                <img class="img-fluid p-4" src="<?php echo base_url(); ?>assets/sb_admin_pro/dist/assets/img/illustrations/404-error-with-a-cute-animal.svg" alt="" />
                                <p class="lead"><?php echo $message?></p>
                                <a class="text-arrow-icon" href="<?php echo base_url() ?>">
                                    <i class="ml-0 mr-1" data-feather="arrow-left"></i>
                                    Kembali ke halaman utama
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutError_footer">
            <footer class="footer mt-auto footer-light">
                <div class="container-fluid">
                    <div class="row">
                        <div class="container-fluid">
                            <div class="text-center small">Copyright &copy; Teknologi Informasi dan Pangkalan Data IAIN Salatiga <?php echo date('Y') ?></div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/jquery-3.5.1.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/bootstrap.bundle.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/dist/js/scripts.js"></script>
</body>

</html>