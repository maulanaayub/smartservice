<link rel="stylesheet" href="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
<style type="text/css">
    .previewcropper {
        overflow: hidden;
        min-width: 100px;
        min-height: 100px;
        margin-left: 10px;
        border: 1px solid red;
    }

    .modalcropper-lg {
        max-width: 500px !important;
    }
</style>

<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fas fa-user-cog"></i></div>
                        Pengaturan Akun
                    </h1>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container mt-4">
    <!-- Account page navigation-->
    <nav class="nav nav-borders">
        <a class="nav-link active ml-0" href="<?php echo base_url('Smart_mhs/profil')?>">Profil Akun</a>
        <a class="nav-link" href="<?php echo base_url('Smart_mhs/ganti_password_mhs')?>">Ganti Password</a>
    </nav>
    <hr class="mt-0 mb-4" />
    <div class="row">

        <div style="position: absolute; top: 5rem; right: 6rem;">
            <!-- Toast -->
            <div class="toast" id="toast_for_update_bio_success" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                <div class="toast-header text-success">
                    <i class="far fa-check-circle mr-1"></i>
                    <strong class="mr-auto"> Berhasil</strong>
                    <small class="text-muted ml-2">Close</small>
                    <button class="ml-2 mb-1 close" type="button" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="toast-body">Update Biodata Mahasiswa Berhasil.</div>
            </div>
        </div>
        <div style="position: absolute; top: 5rem; right: 6rem;">
            <div class="toast" id="toast_for_update_bio_failed" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                <div class="toast-header text-danger">
                    <i class="far fa-check-circle mr-1"></i>
                    <strong class="mr-auto"> Gagal</strong>
                    <small class="text-muted ml-2">Close</small>
                    <button class="ml-2 mb-1 close" type="button" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="toast-body">Update Biodata Mahasiswa Gagal.</div>
            </div>
        </div>
        <div class="col-xl-5 col-sm-12 mb-4">
            <!-- Profile picture card-->
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <div class="card-header">Profil Mahasiswa</div>
                        <div class="card-body">
                            <div class="text-center">
                                <!-- Profile picture image-->
                                <img class="img-account-profile img-fluid rounded-circle mb-2 NO-CACHE" id="uploaded_image" src="<?php echo $foto_profil ?>" alt="" />
                                <!-- Profile picture help block-->
                                <div class="small font-italic text-muted mb-4">JPG atau PNG dengan ukuran rekomendasi dibawah 2 MB</div>
                                <!-- Profile picture upload button-->
                                <button class="btn btn-md btn-cyan rounded-0" type="button" onclick="choosefile()"><i class="far fa-file-image mr-1"></i>Upload profil baru</button>
                                <form method="post">
                                    <input type="file" name="image" class="image" id="upload_image" style="display:none" onClick="this.form.reset()" />
                                </form>


                            </div>

                            <hr class="mb-0">

                            <div class="list-group list-group-flush small ">
                                <div class="list-group-item list-group-item-action py-3 px-2">
                                    <div class="row">
                                        <div class="col-5">
                                            <i class="fas fa-user-alt fa-fw text-blue"></i>
                                            Nama
                                            <div class="float-right">
                                                :
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <?php echo $mahasiswa->NMMHSMSMHS ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="list-group-item list-group-item-action py-3 px-2">
                                    <div class="row">
                                        <div class="col-5">
                                            <i class="far fa-id-card fa-fw text-purple"></i>
                                            NIM
                                            <div class="float-right">
                                                :
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <?php echo $mahasiswa->NIMHSMSMHS ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="list-group-item list-group-item-action py-3 px-2">
                                    <div class="row">
                                        <div class="col-5">
                                            <i class="fas fa-calendar-week fa-fw text-green"></i>
                                            Semester
                                            <div class="float-right">
                                                :
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <?php echo $smt_brjln_mhs ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="list-group-item list-group-item-action py-3 px-2">
                                    <div class="row">
                                        <div class="col-5">
                                            <i class="fas fa-angle-double-up fa-fw text-yellow"></i>
                                            Angkatan
                                            <div class="float-right">
                                                :
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <?php echo $mahasiswa->TAHUNMSMHS ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="list-group-item list-group-item-action py-3 px-2">
                                    <div class="row">
                                        <div class="col-5">
                                            <i class="fas fa-university fa-fw text-orange"></i>
                                            Fakultas
                                            <div class="float-right">
                                                :
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <?php echo $mahasiswa->NMFAKMSFAK ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="list-group-item list-group-item-action py-3 px-2">
                                    <div class="row">
                                        <div class="col-5">
                                            <i class="fas fa-chalkboard-teacher fa-fw text-pink"></i>
                                            Program Studi
                                            <div class="float-right">
                                                :
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <?php echo $mahasiswa->jenjang . ' - ' . $mahasiswa->NMPSTMSPST ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="list-group-item list-group-item-action py-3 px-2">
                                    <div class="row">
                                        <div class="col-5">
                                            <?php
                                            if ($mahasiswa->STMHSMSMHS == 'A' && $mahasiswa->TGL_AKTIVASI != null) {
                                            ?>
                                                <i class="fas fa-check fa-fw text-green"></i>
                                            <?php
                                            } else if ($mahasiswa->STMHSMSMHS == 'A' && $mahasiswa->TGL_AKTIVASI == null) {
                                            ?>
                                                <i class="fas fa-times fa-fw text-red"></i>
                                            <?php
                                            } else {
                                            ?>
                                                <i class="fas fa-share-square text-warning"></i>
                                            <?php
                                            }
                                            ?>

                                            Status
                                            <div class="float-right">
                                                :
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <?php echo $statusaktif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modalcropper-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Potong Gambar sebelum diupload</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center d-block">
                                    <div class="row">
                                        <div class="col-7">
                                            <img class="img-fluid" src="" id="sample_image" />
                                        </div>
                                        <div class="col-4">
                                            <div class="previewcropper" id="preview_image"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="crop" class="btn btn-success">Crop & Simpan</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form method="POST" action="">
                <div class="row">
                    <div class="col-12">
                        <div class="card rounded-0 mt-4">
                            <div class="card-header">Alamat Mahasiswa</div>
                            <div class="card-body">

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputLastName">Negara <span class="badge badge-danger">*Wajib</span></label>
                                        <?php
                                        if (form_error('alamat_negara_mhs') != null) {
                                            echo form_dropdown('alamat_negara_mhs', $dropdown_negara, '', 'class="rounded-0 form-control is-invalid" id="negara_cbo" onchange="select_propinsi()"');
                                        } else {
                                            if (set_value('alamat_negara_mhs') != null) {
                                                $selected = set_value('alamat_negara_mhs');
                                            } else {
                                                $selected =  $mahasiswa_negara;
                                            }

                                            echo form_dropdown('alamat_negara_mhs', $dropdown_negara, $selected, 'class="rounded-0 form-control" id="negara_cbo" onchange="select_propinsi()"');
                                        }
                                        echo form_error('alamat_negara_mhs');
                                        ?>


                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputLastName">Propinsi <span class="badge badge-danger">*Wajib</span></label>
                                        <select name="propinsi_cbo" id="propinsi_cbo" class="rounded-0 form-control <?php echo form_error('propinsi_cbo') ? 'is-invalid' : null ?>" value="<?php echo set_value('propinsi_cbo') ? set_value('propinsi_cbo') : $mahasiswa_propinsi; ?>" onchange="select_kabupaten()">
                                            <option value="">Pilih Propinsi</option>
                                        </select>
                                        <?php
                                        echo form_error('propinsi_cbo');
                                        ?>
                                        <input type="text" id="value_propinsi" style="display: none;" value="<?php echo set_value('propinsi_cbo') ? set_value('propinsi_cbo') : $mahasiswa_propinsi; ?>">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputLastName">Kabupaten / Kota <span class="badge badge-danger">*Wajib</span></label>
                                        <select name="kabupaten_cbo" id="kabupaten_cbo" class="rounded-0 form-control <?php echo form_error('kabupaten_cbo') ? 'is-invalid' : null ?>" value="<?php echo set_value('kabupaten_cbo') ? set_value('kabupaten_cbo') : $mahasiswa_kab; ?>" onchange="select_kecamatan()">
                                            <option value="">Pilih Kabupaten</option>
                                        </select>
                                        <?php
                                        echo form_error('kabupaten_cbo');
                                        ?>
                                        <input type="text" id="value_kabupaten" style="display: none;" value="<?php echo set_value('kabupaten_cbo') ? set_value('kabupaten_cbo') : $mahasiswa_kab; ?>">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputLastName">Kecamatan <span class="badge badge-danger">*Wajib</span></label>
                                        <select name="kecamatan_cbo" id="kecamatan_cbo" class="rounded-0 form-control <?php echo form_error('kecamatan_cbo') ? 'is-invalid' : null ?>" value="<?php echo set_value('kecamatan_cbo') ? set_value('kecamatan_cbo') : $mahasiswa_kecamatan; ?>">
                                            <option value="">Pilih Kecamatan</option>
                                        </select>
                                        <?php
                                        echo form_error('kecamatan_cbo');
                                        ?>
                                        <input type="text" id="value_kecamatan" style="display: none;" value="<?php echo set_value('kecamatan_cbo') ? set_value('kecamatan_cbo') : $mahasiswa_kecamatan; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="small mb-1" for="inputLastName">Desa / Kelurahan <span class="badge badge-danger">*Wajib</span></label>
                                    <input class="rounded-0 form-control <?php echo form_error('desa_mhs') ? 'is-invalid' : null ?>" name="desa_mhs" type="text" placeholder="Desa / Kelurahan" value="<?php echo set_value('desa_mhs') ?  set_value('desa_mhs') : $mahasiswa_desa ?>" />
                                    <?php
                                    echo form_error('desa_mhs');
                                    ?>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label class="small mb-1" for="inputLastName">Dusun</label>
                                        <input class="rounded-0 form-control <?php echo form_error('dusun_mhs') ? 'is-invalid' : null ?>" name="dusun_mhs" type="text" placeholder="Dusun" value="<?php echo set_value('dusun_mhs') ?  set_value('dusun_mhs') : $mahasiswa_dusun ?>" />
                                        <?php
                                        echo form_error('dusun_mhs');
                                        ?>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label class="small mb-1" for="inputLastName">RT</label>
                                        <input class="rounded-0 form-control <?php echo form_error('rt_mhs') ? 'is-invalid' : null ?>" name="rt_mhs" type="text" placeholder="RT" value="<?php echo set_value('rt_mhs') ?  set_value('rt_mhs') : $mahasiswa_rt ?>" />
                                        <?php
                                        echo form_error('rt_mhs');
                                        ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="small mb-1" for="inputLastName">RW</label>
                                        <input class="rounded-0 form-control <?php echo form_error('rw_mhs') ? 'is-invalid' : null ?>" name="rw_mhs" type="text" placeholder="RW" value="<?php echo set_value('rw_mhs') ?  set_value('rw_mhs') : $mahasiswa_rw ?>" />
                                        <?php
                                        echo form_error('rw_mhs');
                                        ?>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="small mb-1" for="inputLastName">Kode Pos</label>
                                        <input class="rounded-0 form-control <?php echo form_error('kode_pos_mhs') ? 'is-invalid' : null ?>" name="kode_pos_mhs" type="text" placeholder="Kode Pos" value="<?php echo set_value('kode_pos_mhs') ?  set_value('kode_pos_mhs') : $mahasiswa_kode_pos ?>" />
                                        <?php
                                        echo form_error('kode_pos_mhs');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="small mb-1" for="inputLastName">Jalan</label>
                                    <input class="rounded-0 form-control <?php echo form_error('jalan_mhs') ? 'is-invalid' : null ?>" name="jalan_mhs" type="text" placeholder="Jalan Tempat Tinggal" value="<?php echo set_value('jalan_mhs') ?  set_value('jalan_mhs') : $mahasiswa_jl ?>" />
                                    <?php
                                    echo form_error('jalan_mhs');
                                    ?>
                                </div>






                                <!-- <div class="float-right">
                                   
                                    <input class="btn btn-primary" type="submit" value="Simpan Perubahan"></input>
                                </div> -->


                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card rounded-0 mt-4">
                            <div class="card-header">Alamat Orang Tua / Wali</div>
                            <div class="card-body">

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputLastName">Negara <span class="badge badge-danger">*Wajib</span></label>
                                        <?php
                                        // var_dump($mahasiswa_ortu_negara);
                                        if (form_error('alamat_ortu_negara') != null) {
                                            echo form_dropdown('alamat_ortu_negara', $dropdown_negara, '', 'class="rounded-0 form-control is-invalid" id="negara_ortu_cbo" onchange="select_ortu_propinsi()"');
                                        } else {
                                            if (set_value('alamat_ortu_negara') != null) {
                                                $selected = set_value('alamat_ortu_negara');
                                            } else {
                                                $selected =  $mahasiswa_ortu_negara;
                                            }

                                            echo form_dropdown('alamat_ortu_negara', $dropdown_negara, $selected, 'class="rounded-0 form-control" id="negara_ortu_cbo" onchange="select_ortu_propinsi()"');
                                        }
                                        echo form_error('alamat_ortu_negara');
                                        ?>


                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputLastName">Propinsi <span class="badge badge-danger">*Wajib</span></label>
                                        <select name="propinsi_ortu_cbo" id="propinsi_ortu_cbo" class="rounded-0 form-control <?php echo form_error('propinsi_ortu_cbo') ? 'is-invalid' : null ?>" value="<?php //echo set_value('propinsi_ortu_cbo') ? set_value('propinsi_ortu_cbo') : $mahasiswa_ortu_propinsi; 
                                                                                                                                                                                                ?>" onchange="select_ortu_kabupaten()">
                                            <option value="">Pilih Propinsi</option>
                                        </select>
                                        <?php
                                        echo form_error('propinsi_ortu_cbo');
                                        ?>
                                        <input type="text" id="value_ortu_propinsi" style="display: none;" value="<?php echo set_value('propinsi_ortu_cbo') ? set_value('propinsi_ortu_cbo') : $mahasiswa_ortu_propinsi; ?>">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputLastName">Kabupaten / Kota <span class="badge badge-danger">*Wajib</span></label>
                                        <select name="kabupaten_ortu_cbo" id="kabupaten_ortu_cbo" class="rounded-0 form-control <?php echo form_error('kabupaten_ortu_cbo') ? 'is-invalid' : null ?>" value="<?php echo set_value('kabupaten_ortu_cbo') ? set_value('kabupaten_ortu_cbo') : $mahasiswa_ortu_kab; ?>">
                                            <option value="">Pilih Kabupaten</option>
                                        </select>
                                        <?php
                                        echo form_error('kabupaten_ortu_cbo');
                                        ?>
                                        <input type="text" id="value_ortu_kabupaten" style="display:none;" value="<?php echo set_value('kabupaten_ortu_cbo') ? set_value('kabupaten_ortu_cbo') : $mahasiswa_ortu_kab; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputLastName">Desa & Kecamatan <span class="badge badge-danger">*Wajib</span></label>
                                        <input class="rounded-0 form-control" name="desa_kec_ortu" type="text" placeholder="Desa & Kecamatan" value="<?php echo set_value('desa_kec_ortu') ?  set_value('desa_kec_ortu') : $mahasiswa_ortu_desa_kecamatan ?>" />
                                        <?php
                                        echo form_error('desa_kec_ortu');
                                        ?>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-9">
                                        <label class="small mb-1" for="inputLastName">Dusun atau Jalan & RT RW</label>
                                        <input class="rounded-0 form-control <?php echo form_error('dusun_jl_rt_rw_ortu') ? 'is-invalid' : null ?>" name="dusun_jl_rt_rw_ortu" type="text" placeholder="Dusun atau Jl & RT RW" value="<?php echo set_value('dusun_jl_rt_rw_ortu') ?  set_value('dusun_jl_rt_rw_ortu') : $mahasiswa_ortu_jl_rt_rw_dusun ?>" />
                                        <?php
                                        echo form_error('dusun_jl_rt_rw_ortu');
                                        ?>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="small mb-1" for="inputLastName">Kode Pos</label>
                                        <input class="rounded-0 form-control <?php echo form_error('kode_pos_ortu') ? 'is-invalid' : null ?>" name="kode_pos_ortu" type="text" placeholder="Kode Pos" value="<?php echo set_value('kode_pos_ortu') ?  set_value('kode_pos_ortu') : $mahasiswa_ortu_kode_pos ?>" />
                                        <?php
                                        echo form_error('kode_pos_ortu');
                                        ?>
                                    </div>
                                </div>

                                <!-- <div class="float-right">
                                  
                                    <input class="btn btn-primary" type="submit" value="Simpan Perubahan"></input>
                                </div> -->


                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-xl-7 col-sm-12">
            <!-- Account details card-->
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-0">
                        <div class="card-header">Biodata Mahasiswa</div>
                        <div class="card-body">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputFirstName">Nama Lengkap</label>
                                    <input class="rounded-0 form-control" type="text" placeholder="Nama Lengkap" value="<?php echo $mahasiswa->NMMHSMSMHS ?>" disabled />
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputLastName">Nomor Induk Mahasiswa</label>
                                    <input class="rounded-0 form-control" type="text" placeholder="Nomor Induk Mahasiswa" value="<?php echo $mahasiswa->NIMHSMSMHS ?>" disabled />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputLastName">Kewarganegaraan <span class="badge badge-danger">*Wajib</span></label>
                                    <?php

                                    if (form_error('kewarganegaraan') != null) {
                                        echo form_dropdown('kewarganegaraan', $dropdown_negara, '', 'class="rounded-0 form-control is-invalid" id="select_kewarganegaraan"');
                                    } else {
                                        if (set_value('kewarganegaraan') != null) {
                                            $selected = set_value('kewarganegaraan');
                                        } elseif ($mahasiswa->ISWNI == 'I') {
                                            $selected = 'ID';
                                        } else {
                                            $selected =  $mahasiswa->ISWNI;
                                        }

                                        echo form_dropdown('kewarganegaraan', $dropdown_negara, $selected, 'class="rounded-0 form-control"');
                                    }
                                    echo form_error('kewarganegaraan');
                                    ?>

                                </div>

                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputLastName">NIK (Nomor Induk Kependudukan) <span class="badge badge-danger">*Wajib</span></label>
                                    <input class="rounded-0 form-control <?php echo form_error('nik_mhs') ? 'is-invalid' : null ?>" name="nik_mhs" type="text" placeholder="Nomor Induk Kependudukan" value="<?php echo set_value('nik_mhs') ? set_value('nik_mhs') : $mahasiswa->NOKTP ?>" />
                                    <?php
                                    echo form_error('nik_mhs');
                                    ?>
                                </div>
                            </div>


                            <div class="form-row">
                                <!-- Form Group (first name)-->
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputFirstName">Tempat Lahir <span class="badge badge-danger">*Wajib</span></label>
                                    <input class="rounded-0 form-control <?php echo form_error('tempat_lahir_mhs') ? 'is-invalid' : null ?>" name="tempat_lahir_mhs" type="text" placeholder="Tempat Lahir" value="<?php echo set_value('tempat_lahir_mhs') ? set_value('tempat_lahir_mhs') : $mahasiswa->TPLHRMSMHS ?>" />
                                    <?php
                                    echo form_error('tempat_lahir_mhs');
                                    ?>
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="form-group col-md-6">

                                    <label class="small mb-1" for="inputLastName">Tanggal Lahir <small>(YYYY-MM-DD <i>Contoh : 1998-01-23</i>)</small> <span class="badge badge-danger">*Wajib</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-calendar-week"></i></span>
                                        </div>
                                        <input class="rounded-0 form-control <?php echo form_error('tgl_lahir_mhs') ? 'is-invalid' : null ?>" name="tgl_lahir_mhs" type="text" placeholder="Tanggal Lahir" value="<?php echo set_value('tgl_lahir_mhs') ? set_value('tgl_lahir_mhs') : $mahasiswa->TGLHRMSMHS ?>" />
                                    </div>
                                    <?php
                                    echo form_error('tgl_lahir_mhs');
                                    ?>

                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputLastName">Agama</label>
                                    <input class="rounded-0 form-control" type="text" placeholder="Agama" value="<?php echo $mahasiswa->AGAMA ?>" disabled />
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputLastName">Jenis Kelamin</label>
                                    <?php
                                    if ($mahasiswa->KDJEKMSMHS == 'P') {
                                        $jenis_kel = 'PEREMPUAN';
                                    } else {
                                        $jenis_kel = 'LAKI - LAKI';
                                    }
                                    ?>
                                    <input class="rounded-0 form-control" type="text" placeholder="Jenis Kelamin" value="<?php echo $jenis_kel ?>" disabled />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputLastName">Fakultas Studi</label>
                                    <input class="rounded-0 form-control" type="text" placeholder="Fakultas" value="<?php echo $mahasiswa->NMFAKMSFAK ?>" disabled />
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputLastName">Program Studi</label>
                                    <input class="rounded-0 form-control" type="text" placeholder="Program Studi" value="<?php echo $mahasiswa->NMPSTMSPST ?>" disabled />
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputLastName">No Handphone <span class="badge badge-danger">*Wajib</span></label>
                                    <input class="rounded-0 form-control <?php echo form_error('hp_mhs') ? 'is-invalid' : null ?>" name="hp_mhs" type="text" placeholder="Nomor Handphone" value="<?php echo set_value('hp_mhs') ? set_value('hp_mhs') : $mahasiswa->TELP ?>" />
                                    <?php
                                    echo form_error('hp_mhs');
                                    ?>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputLastName">Email <span class="badge badge-danger">*Wajib</span></label>
                                    <input class="rounded-0 form-control <?php echo form_error('email_mhs') ? 'is-invalid' : null ?>" name="email_mhs" type="text" placeholder="Email" value="<?php echo set_value('email_mhs') ? set_value('email_mhs') : $mahasiswa->EMAIL ?>" />
                                    <?php
                                    echo form_error('email_mhs');
                                    ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputLastName">Tinggi Badan</label>
                                    <input class="rounded-0 form-control <?php echo form_error('tinggi_mhs') ? 'is-invalid' : null ?>" name="tinggi_mhs" type="text" placeholder="Tinggi Badan" value="<?php echo set_value('tinggi_mhs') ? set_value('tinggi_mhs') : $mahasiswa->TINGGIBADAN ?>" />
                                    <?php
                                    echo form_error('tinggi_mhs');
                                    ?>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputLastName">Berat Badan</label>
                                    <input class="rounded-0 form-control <?php echo form_error('berat_mhs') ? 'is-invalid' : null ?>" name="berat_mhs" type="text" placeholder="Berat Badan" value="<?php echo set_value('berat_mhs') ? set_value('berat_mhs') : $mahasiswa->BERATBADAN ?>" />
                                    <?php
                                    echo form_error('berat_mhs');
                                    ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="small mb-1" for="inputLastName">Golongan Darah</label>
                                    <select name="golongan_darah_cbo" class="rounded-0 form-control <?php echo form_error('golongan_darah_cbo') ? 'is-invalid' : null ?>">
                                        <option value="">-- Pilih Golongan Darah --</option>
                                        <?php
                                        $jenis_darah = array('A', 'B', 'AB', 'O');
                                        if (set_value('golongan_darah_cbo') == null) {
                                            $selected = $mahasiswa->GOLDARAH;
                                        } else {
                                            $selected = set_value('golongan_darah_cbo');
                                        }
                                        //var_dump($jenis_darah);

                                        foreach ($jenis_darah as $row) {
                                            if ($row == $selected) {
                                                echo '<option value="' . $row . '" selected>' . $row . '</option>';
                                            } else {
                                                echo '<option value="' . $row . '">' . $row . '</option>';
                                            }
                                        }
                                        echo form_error('golongan_darah_cbo');
                                        ?>

                                    </select>

                                </div>
                            </div>


                            <!-- <div class="float-right">
                                    
                                    <input class="btn btn-primary" type="submit" value="Simpan Perubahan"></input>
                                </div> -->


                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mt-4">
                        <div class="card-header">Data Orang Tua / Wali</div>
                        <div class="card-body">
                            <form>

                                <div class="form-row">
                                    <!-- Form Group (first name)-->
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputFirstName">Nama Ayah <span class="badge badge-danger">*Wajib</span></label>
                                        <input class="rounded-0 form-control  <?php echo form_error('nama_ayah_mhs') ? 'is-invalid' : null ?>" name="nama_ayah_mhs" type="text" placeholder="Nama Lengkap Ayah" value="<?php echo set_value('nama_ayah_mhs') ? set_value('nama_ayah_mhs') : $mahasiswa_ayah ?>" />
                                        <?php
                                        echo form_error('nama_ayah_mhs');
                                        ?>
                                    </div>
                                    <!-- Form Group (last name)-->
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputFirstName">Nama Ibu <span class="badge badge-danger">*Wajib</span></label>
                                        <input class="rounded-0 form-control <?php echo form_error('nama_ibu_mhs') ? 'is-invalid' : null ?>" name="nama_ibu_mhs" type="text" placeholder="Nama Lengkap Ibu" value="<?php echo set_value('nama_ibu_mhs') ? set_value('nama_ibu_mhs') : $mahasiswa_ibu ?>" />
                                        <?php
                                        echo form_error('nama_ibu_mhs');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputLastName">Pekerjaan Ayah <span class="badge badge-danger">*Wajib</span></label>
                                        <select name="pekerjaan_ayah_cbo" class="rounded-0 form-control <?php echo form_error('pekerjaan_ayah_cbo') ? 'is-invalid' : null ?>">
                                            <option value="">-- Pilih Pekerjaan Ayah --</option>
                                            <?php
                                            // $jenis_pekerjaan = array('PETANI', 'KARYAWAN SWASTA', 'BURUH', 'PEDAGANG', 'NELAYAN', 'PENGUSAHA/WIRAUSAHA', 'PNS NON GURU', 'TNI/POLRI', 'PNS GURU/DOSEN', 'GURU/DOSEN NON PNS', 'LAINNYA');
                                            if (set_value('pekerjaan_ayah_cbo') == null) {
                                                $selected = $mahasiswa_pekerjaan_ayah;
                                            } else {
                                                $selected = set_value('pekerjaan_ayah_cbo');
                                            }

                                            foreach ($dropdown_ph_pk_pd_orang_tua as $row) {
                                                if ($row['KDAPLTBKOD'] == 302) {
                                                    if ($row['NMKODTBKOD'] == $selected) {
                                                        echo '<option value="' . $row['NMKODTBKOD'] . '" selected>' . $row['NMKODTBKOD'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $row['NMKODTBKOD'] . '">' . $row['NMKODTBKOD'] . '</option>';
                                                    }
                                                }
                                            }

                                            ?>

                                        </select>
                                        <?php
                                        echo form_error('pekerjaan_ayah_cbo');
                                        ?>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputLastName">Pekerjaan Ibu <span class="badge badge-danger">*Wajib</span></label>
                                        <select name="pekerjaan_ibu_cbo" class="rounded-0 form-control <?php echo form_error('pekerjaan_ibu_cbo') ? 'is-invalid' : null ?>">
                                            <option value="">-- Pilih Pekerjaan Ibu --</option>
                                            <?php
                                            //$jenis_pekerjaan = array('PETANI', 'KARYAWAN SWASTA', 'BURUH', 'PEDAGANG', 'NELAYAN', 'PENGUSAHA/WIRAUSAHA', 'PNS NON GURU', 'TNI/POLRI', 'PNS GURU/DOSEN', 'GURU/DOSEN NON PNS', 'LAINNYA');
                                            if (set_value('pekerjaan_ibu_cbo') == null) {
                                                $selected = $mahasiswa_pekerjaan_ibu;
                                            } else {
                                                $selected = set_value('pekerjaan_ibu_cbo');
                                            }
                                            //var_dump($jenis_darah);

                                            foreach ($dropdown_ph_pk_pd_orang_tua as $row) {
                                                if ($row['KDAPLTBKOD'] == 302) {
                                                    if ($row['NMKODTBKOD'] == $selected) {
                                                        echo '<option value="' . $row['NMKODTBKOD'] . '" selected>' . $row['NMKODTBKOD'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $row['NMKODTBKOD'] . '">' . $row['NMKODTBKOD'] . '</option>';
                                                    }
                                                }
                                            }

                                            ?>

                                        </select>
                                        <?php
                                        echo form_error('pekerjaan_ibu_cbo');
                                        ?>

                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputLastName">Pendidikan Ayah</label>
                                        <select name="pendidikan_ayah_cbo" class="rounded-0 form-control <?php echo form_error('pendidikan_ayah_cbo') ? 'is-invalid' : null ?>">
                                            <option value="">-- Pilih Pendidikan Ayah --</option>
                                            <?php
                                            //$jenis_pendidikan = array('<= SMA', 'DIPLOMA', 'S1', 'S2', 'S3');
                                            if (set_value('pendidikan_ayah_cbo') == null) {
                                                $selected = $mahasiswa_pendidikan_ayah;
                                            } else {
                                                $selected = set_value('pendidikan_ayah_cbo');
                                            }
                                            //var_dump($jenis_darah);

                                            foreach ($dropdown_ph_pk_pd_orang_tua as $row) {
                                                if ($row['KDAPLTBKOD'] == 303) {
                                                    if ($row['NMKODTBKOD'] == $selected) {
                                                        echo '<option value="' . $row['NMKODTBKOD'] . '" selected>' . $row['NMKODTBKOD'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $row['NMKODTBKOD'] . '">' . $row['NMKODTBKOD'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>

                                        </select>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputLastName">Pendidikan Ibu</label>
                                        <select name="pendidikan_ibu_cbo" class="rounded-0 form-control <?php echo form_error('pendidikan_ibu_cbo') ? 'is-invalid' : null ?>">
                                            <option value="">-- Pilih Pendidikan Ibu --</option>
                                            <?php
                                            //$jenis_pendidikan = array('<= SMA', 'DIPLOMA', 'S1', 'S2', 'S3');
                                            if (set_value('pendidikan_ibu_cbo') == null) {
                                                $selected = $mahasiswa_pendidikan_ibu;
                                            } else {
                                                $selected = set_value('pendidikan_ibu_cbo');
                                            }
                                            //var_dump($jenis_darah);

                                            foreach ($dropdown_ph_pk_pd_orang_tua as $row) {
                                                if ($row['KDAPLTBKOD'] == 303) {
                                                    if ($row['NMKODTBKOD'] == $selected) {
                                                        echo '<option value="' . $row['NMKODTBKOD'] . '" selected>' . $row['NMKODTBKOD'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $row['NMKODTBKOD'] . '">' . $row['NMKODTBKOD'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>

                                        </select>

                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputLastName">Penghasilan Ayah (Per Bulan)</label>
                                        <select name="penghasilan_ayah_cbo" class="rounded-0 form-control <?php echo form_error('penghasilan_ayah_cbo') ? 'is-invalid' : null ?>">
                                            <option value="">-- Pilih Penghasilan Ayah --</option>
                                            <?php
                                            // $jenis_penghasilan = array('< 1.000.000', '1.000.000 S/D  2.000.000', '2.000.001 S/D  4.000.000', '4.000.001 S/D 6.000.000', '> 6.000.000');
                                            if (set_value('penghasilan_ayah_cbo') == null) {
                                                $selected = $mahasiswa_penghasilan_ayah;
                                            } else {
                                                $selected = set_value('penghasilan_ayah_cbo');
                                            }
                                            //var_dump($jenis_darah);

                                            foreach ($dropdown_ph_pk_pd_orang_tua as $row) {
                                                if ($row['KDAPLTBKOD'] == 301) {
                                                    if ($row['NMKODTBKOD'] == $selected) {
                                                        echo '<option value="' . $row['NMKODTBKOD'] . '" selected>' . $row['NMKODTBKOD'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $row['NMKODTBKOD'] . '">' . $row['NMKODTBKOD'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>

                                        </select>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="small mb-1" for="inputLastName">Penghasilan Ibu(Per Bulan)</label>
                                        <select name="penghasilan_ibu_cbo" class="rounded-0 form-control <?php echo form_error('penghasilan_ibu_cbo') ? 'is-invalid' : null ?>">
                                            <option value="">-- Pilih Penghasilan Ibu --</option>
                                            <?php
                                            //$jenis_penghasilan = array('< 1.000.000', '1.000.000 S/D  2.000.000', '2.000.001 S/D  4.000.000', '4.000.001 S/D 6.000.000', '> 6.000.000');
                                            if (set_value('penghasilan_ibu_cbo') == null) {
                                                $selected = $mahasiswa_penghasilan_ibu;
                                            } else {
                                                $selected = set_value('penghasilan_ibu_cbo');
                                            }
                                            //var_dump($jenis_darah);

                                            foreach ($dropdown_ph_pk_pd_orang_tua as $row) {
                                                if ($row['KDAPLTBKOD'] == 301) {
                                                    if ($row['NMKODTBKOD'] == $selected) {
                                                        echo '<option value="' . $row['NMKODTBKOD'] . '" selected>' . $row['NMKODTBKOD'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $row['NMKODTBKOD'] . '">' . $row['NMKODTBKOD'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>

                                        </select>

                                    </div>
                                </div>
                                <div class="form-row">
                                    <!-- Form Group (first name)-->
                                    <div class="form-group col-md-12">
                                        <label class="small mb-1" for="inputFirstName">Telp / HP Orang Tua / Wali</label>
                                        <input class="rounded-0 form-control <?php echo form_error('telp_ortu_mhs') ? 'is-invalid' : null ?>" name="telp_ortu_mhs" type="text" placeholder="Nomor Telp / HP Orang Tua / Wali" value="<?php echo set_value('telp_ortu_mhs') ? set_value('telp_ortu_mhs') : $mahasiswa->TELPORTUWALI ?>" />
                                        <?php
                                        echo form_error('telp_ortu_mhs');
                                        ?>
                                    </div>

                                </div>
                                <!-- <div class="float-right">
                                    
                                    <input class="btn btn-primary" type="submit" value="Simpan Perubahan"></input>
                                </div> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="text-sm-center text-md-right">
                <button class="btn btn-md btn-green rounded-0" type="submit"><i class="far fa-save mr-1"></i> Simpan Perubahan</button>
            </div>
        </div>
    </div>
    </form>
</div>
<?php
// echo $mahasiswa->ALAMATLENGKAP.'<br>' ;
// $pisah = explode("\n",$mahasiswa->ALAMATLENGKAP);
// echo $pisah[0].'<br>';
// echo $pisah[1].'<br>';
// echo $pisah[2].'<br>';
// echo $pisah[3].'<br>';
// echo $pisah[4].'<br>';
// echo $pisah[5].'<br>';
// echo 'jumlah array'.count($pisah);
?>

<script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/iain_mhs_upload_profil.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        select_propinsi();
        select_ortu_propinsi();
    });
</script>
<script>
    $(function() {

        $('input[name="tgl_lahir_mhs"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1945,
            maxYear: 2100,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

    });

    function select_propinsi() {
        var negara_cbo = $("#negara_cbo").val();
        var value_propinsi = $("#value_propinsi").val();
        //select kabupaten juga dipanggil pada fungsi ini karena ketika terjadi perubahan pada propinsi, dan propinsi sudah terisi terlebih dahulu ager bisa langsung muncul kabupaten nya pada kolom kabupaten
        select_kabupaten();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>smart_mhs/propinsi_c",
            data: {
                value_propinsi: value_propinsi,
                negara_cbo: negara_cbo
            },
            success: function(data) {
                $("#propinsi_cbo").html(data);
            }
        });
    };

    function select_ortu_propinsi() {
        var negara_cbo = $("#negara_ortu_cbo").val();
        var value_propinsi = $("#value_ortu_propinsi").val();
        //select kabupaten juga dipanggil pada fungsi ini karena ketika terjadi perubahan pada propinsi, dan propinsi sudah terisi terlebih dahulu ager bisa langsung muncul kabupaten nya pada kolom kabupaten
        select_ortu_kabupaten();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>smart_mhs/propinsi_c",
            data: {
                value_propinsi: value_propinsi,
                negara_cbo: negara_cbo
            },
            success: function(data) {
                $("#propinsi_ortu_cbo").html(data);
            }
        });
    };

    function select_kabupaten() {
        var negara_cbo = $("#negara_cbo").val();
        var propinsi_cbo = $("#propinsi_cbo").val();
        var value_propinsi = $("#value_propinsi").val();
        var value_kabupaten = $("#value_kabupaten").val();
        //select kecamatan juga dipanggil pada fungsi ini karena ketika terjadi perubahan pada kabupaten, dan kabupaten sudah terisi terlebih dahulu ager bisa langsung muncul kecamatan nya pada kolom kecamatan
        select_kecamatan();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>smart_mhs/kabupaten_c",
            data: {
                value_propinsi: value_propinsi,
                value_kabupaten: value_kabupaten,
                propinsi_cbo: propinsi_cbo,
                negara_cbo: negara_cbo
            },
            success: function(data) {
                $("#kabupaten_cbo").html(data);
            }
        });
    };

    function select_ortu_kabupaten() {
        var negara_cbo = $("#negara_ortu_cbo").val();
        var propinsi_cbo = $("#propinsi_ortu_cbo").val();
        var value_propinsi = $("#value_ortu_propinsi").val();
        var value_kabupaten = $("#value_ortu_kabupaten").val();
        //select kecamatan juga dipanggil pada fungsi ini karena ketika terjadi perubahan pada kabupaten, dan kabupaten sudah terisi terlebih dahulu ager bisa langsung muncul kecamatan nya pada kolom kecamatan

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>smart_mhs/kabupaten_c",
            data: {
                cbox_ortu: true,
                value_propinsi: value_propinsi,
                value_kabupaten: value_kabupaten,
                propinsi_cbo: propinsi_cbo,
                negara_cbo: negara_cbo
            },
            success: function(data) {
                $("#kabupaten_ortu_cbo").html(data);
            }
        });
    };

    function select_kecamatan() {
        var negara_cbo = $("#negara_cbo").val();

        var kabupaten_cbo = $("#kabupaten_cbo").val();
        var value_kabupaten = $("#value_kabupaten").val();
        var value_kecamatan = $("#value_kecamatan").val();
        //select kecamatan juga dipanggil pada fungsi ini karena ketika terjadi perubahan pada kabupaten, dan kabupaten sudah terisi terlebih dahulu ager bisa langsung muncul kecamatan nya pada kolom kecamatan
        //select_kecamatan();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>smart_mhs/kecamatan_c",
            data: {

                value_kabupaten: value_kabupaten,
                value_kecamatan: value_kecamatan,
                kabupaten_cbo: kabupaten_cbo,
                negara_cbo: negara_cbo
            },
            success: function(data) {
                $("#kecamatan_cbo").html(data);
            }
        });
    };

    //toast notifikasi
    <?php
    if ($this->session->flashdata('pesan') == 'update_bio_mhs_success') {
    ?>
        $("#toast_for_update_bio_success").toast("show");
    <?php
    } else if ($this->session->flashdata('pesan') == 'update_bio_mhs_failed') {
    ?>
        $("#toast_for_update_bio_failed").toast("show");
    <?php
    }
    ?>
</script>