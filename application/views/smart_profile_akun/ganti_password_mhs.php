<script src='https://www.google.com/recaptcha/api.js'></script>
<div class="container mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link ml-0" href="<?php echo base_url('Smart_mhs/profil') ?>">Profil Akun</a>
        <a class="nav-link active" href="<?php echo base_url('Smart_mhs/ganti_password_mhs') ?>">Ganti Password</a>
    </nav>
    <hr class="mt-0 mb-4" />
    <div class="row">

        <div style="position: absolute; top: 5rem; right: 6rem;">
            <!-- Toast -->
            <div class="toast" id="toast_for_update_pass_success" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                <div class="toast-header text-success">
                    <i class="far fa-check-circle mr-1"></i>
                    <strong class="mr-auto"> Berhasil</strong>
                    <small class="text-muted ml-2">Close</small>
                    <button class="ml-2 mb-1 close" type="button" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="toast-body">Password Berhasil diubah.</div>
            </div>
        </div>
        <div style="position: absolute; top: 5rem; right: 6rem;">
            <div class="toast" id="toast_for_update_pass_failed" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                <div class="toast-header text-danger">
                    <i class="far fa-check-circle mr-1"></i>
                    <strong class="mr-auto"> Gagal</strong>
                    <small class="text-muted ml-2">Close</small>
                    <button class="ml-2 mb-1 close" type="button" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="toast-body">Password Gagal diubah.</div>
            </div>
        </div>
        <div class="col-12 mb-4">
            <!-- Profile picture card-->
            <form action="" method="post">
                <div class="row">
                    <div class="col-12">
                        <div class="card rounded-0 mt-4">
                            <div class="card-header">Ganti Password Mahasiswa</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputLastName">Password Lama</label>
                                    <div class="input-group show_hide_password_old">
                                        <input class="rounded-0 form-control <?php echo form_error('password_lama_mhs') ? 'is-invalid' : null ?>" name="password_lama_mhs" type="password" placeholder="Password Lama" value="<?php echo set_value('password_lama_mhs') ?>" />
                                        <div class="input-group-prepend">
                                            <a href="" class="input-group-text "><span id="rounded-shp"><i class="fa fa-eye-slash" aria-hidden="true"></i></span></a>
                                        </div>
                                    </div>
                                    <?php
                                    echo form_error('password_lama_mhs');
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="inputLastName">Password Baru</label>
                                    <div class="input-group show_hide_password_new">
                                        <input class="rounded-0 form-control <?php echo form_error('password_baru_mhs') ? 'is-invalid' : null ?>" name="password_baru_mhs" type="password" placeholder="Password Baru" value="<?php echo set_value('password_baru_mhs') ?>" />
                                        <div class="input-group-prepend">
                                            <a href="" class="input-group-text "><span id="rounded-shp"><i class="fa fa-eye-slash" aria-hidden="true"></i></span></a>
                                        </div>
                                    </div>
                                    <?php
                                    echo form_error('password_baru_mhs');
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="inputLastName">Konfirmasi Password Baru</label>
                                    <div class="input-group show_hide_password_konfirmasi">
                                        <input class="rounded-0 form-control <?php echo form_error('konfirmasi_password_baru_mhs') ? 'is-invalid' : null ?>" name="konfirmasi_password_baru_mhs" type="password" placeholder="Konfirmasi Password Baru" value="<?php echo set_value('konfirmasi_password_baru_mhs') ?>" />
                                        <div class="input-group-prepend ">
                                            <a href="" class="input-group-text "><span id="rounded-shp"><i class="fa fa-eye-slash" aria-hidden="true"></i></span></a>
                                        </div>
                                    </div>
                                    <?php
                                    echo form_error('konfirmasi_password_baru_mhs');
                                    ?>
                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-end">
                                        <?php echo $captcha ?>
                                    </div>
                                </div>
                                <div class="form-group d-flex justify-content-end mb-0">
                                    <?php echo form_error('g-recaptcha-response'); ?>
                                    <?php echo $this->session->flashdata('message'); ?>
                                </div>

                                <div class="custom-control custom-checkbox mb-3 d-flex justify-content-end">
                                    <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                                    <label class="custom-control-label" for="customCheck">Saya setuju dengan mengganti password SMART akan mengganti password SIAKAD mahasiswa</label>
                                </div>
                
                                <div class="float-right">
                                    <button id="submit" class="btn btn-green rounded-0" type="submit"><i class="far fa-save mr-1"></i> Simpan Perubahan</button>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/custom.js"></script>
<script>
    <?php
    if ($this->session->flashdata('pesan') == 'update_pass_mhs_success') {
    ?>
        $("#toast_for_update_pass_success").toast("show");
    <?php
    } else if ($this->session->flashdata('pesan') == 'update_pass_mhs_failed') {
    ?>
        $("#toast_for_update_pass_failed").toast("show");
    <?php
    }
    ?>
</script>