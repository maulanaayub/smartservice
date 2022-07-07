<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SSO - IAIN SMART</title>
    <link href="<?php echo base_url(); ?>assets/sb_admin_pro/dist/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/sb_admin_pro/dist/assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/all.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/feather.js" crossorigin="anonymous"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body class="bg-gradient-primary-to-secondary">
    <?php
    //echo $this->input->get('continue');
    // echo rawurlencode ('https://siska.iainsalatiga.ac.id/aks');
    // echo rawurldecode ('https%3A%2F%2Fsiska.iainsalatiga.ac.id%2Faks');
    ?>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-xl-4 col-lg-6 col-md-8 col-sm-11">
                            <!-- Social login form-->
                            <div class="card rounded-0 mt-5 mb-2">
                                <div class="card-body p-4 text-center">

                                    <div class="h3 font-weight">Lupa Password SIAKAD?</div>
                                   
                                </div>
                                <hr class="my-0" />
                                <div class="card-body p-3">
                                    <!-- Login form-->
                                    <form action="" method="post">
                                        <!-- Form Group (email address)-->
                                        <div class="form-group">
                                            <label class="text-gray-600 small" for="emailExample">Username</label>
                                            <input class="form-control form-control-solid <?php echo form_error('username') ? 'is-invalid' : null ?>" name="username" type="text" value="<?php echo set_value('username'); ?>" placeholder="NIM / Username SIAKAD" aria-label="Username" aria-describedby="Username untuk masuk" />
                                            <?php echo form_error('username'); ?>
                                        </div>
                                        <!-- Form Group (password)-->
                                        <div class="form-group">
                                            <label class="text-gray-600 small" for="passwordExample">Password</label>
                                            <div class="input-group show_hide_password">
                                                <input class="form-control form-control-solid <?php echo form_error('password') ? 'is-invalid' : null ?>" name="password" type="password" value="<?php echo set_value('password'); ?>" placeholder="Password SIAKAD" aria-label="Password" aria-describedby="Password untuk masuk" />
                                                <div class="input-group-prepend">
                                                    <a href="" class="input-group-text "><span id="rounded-shp"><i class="fa fa-eye-slash" aria-hidden="true"></i></span></a>
                                                </div>
                                            </div>
                                            <?php echo form_error('password'); ?>
                                        </div>
                                        <!-- Form Group (login box)-->
                                        <div class="form-group">

                                            <div class="d-flex justify-content-center">
                                                <?php echo $captcha ?>

                                            </div>
                                        </div>
                                        <div class="form-group d-flex justify-content-center">
                                            <?php echo form_error('g-recaptcha-response'); ?>
                                            <?php echo $this->session->flashdata('message'); ?>
                                        </div>
                                        <div class="col text-center">
                                            <button type="submit" class="btn btn-primary btn-block btn-md rounded-0 "><i class="fas fa-sign-in-alt mr-2"></i>Login</button>
                                        </div>
                                    </form>
                                </div>
                                <hr class="my-0" />
                                <div class="card-body px-5 py-3">
                                    <div class="small text-center">
                                       
                                        <a href="<?php echo base_url("smart_auth")?>">Return to Login</a>
                                    </div>

                                </div>
                            </div>
                            <div class="small text-center">
                                <marquee>
                                    <p class="text-white">Copyright &copy; Teknologi Informasi dan Pangkalan Data IAIN Salatiga <?php echo date('Y') ?></p>
                                </marquee>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </main>
    </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/jquery-3.5.1.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/bootstrap.bundle.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/dist/js/scripts.js"></script>
    <script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/custom.js"></script>


</body>

</html>