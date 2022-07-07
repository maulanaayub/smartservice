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
        <a class="nav-link active ml-0" href="<?php echo base_url('Smart_sispt/profil')?>">Profil Akun</a>
        <a class="nav-link" href="<?php echo base_url('Smart_sispt/ganti_password_sispt')?>">Ganti Password</a>
    </nav>
    <hr class="mt-0 mb-4" />
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card">
                <div class="card-header">Gambar Profil</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <img class="img-account-profile img-fluid rounded-circle mb-2 NO-CACHE" id="uploaded_image" src="<?php echo $foto_profil ?>" alt="" />
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">JPG atau PNG dengan ukuran rekomendasi dibawah 2 MB</div>
                    <!-- Profile picture upload button-->
                    <button class="btn btn-primary" type="button" onclick="choosefile()">Upload profil baru</button>
                    <form method="post">
                        <input type="file" name="image" class="image" id="upload_image" style="display:none" onClick="this.form.reset()" />
                    </form>
                </div>
            </div>
            <div class="card mb-4 mt-3">
                <div class="card-header border-bottom-0"> Data Akun User </div>
                <div class="list-group list-group-flush small">
                    <table>
                        <tr>
                            <td>
                                <a class="list-group-item list-group-item-action" href="#!">
                                    <!-- <i class="fas fa-dollar-sign fa-fw text-blue mr-2"></i> -->
                                    No.Dosen
                                </a>
                            </td>
                            <td>
                                <a class="list-group-item list-group-item-action" href="#!">
                                    <!-- <i class="fas fa-dollar-sign fa-fw text-blue mr-2"></i> -->
                                    : <?= $get_dosen->NODOSMSDOS; ?>
                                </a>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <a class="list-group-item list-group-item-action" href="#!">
                                    <!-- <i class="fas fa-dollar-sign fa-fw text-blue mr-2"></i> -->
                                    User Id
                                </a>
                            </td>
                            <td>
                                <a class="list-group-item list-group-item-action" href="#!">
                                    <!-- <i class="fas fa-dollar-sign fa-fw text-blue mr-2"></i> -->
                                    : <?= $get_dosen->user_id; ?>
                                </a>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <a class="list-group-item list-group-item-action" href="#!">
                                    <!-- <i class="fas fa-dollar-sign fa-fw text-blue mr-2"></i> -->
                                    Nama
                                </a>
                            </td>
                            <td>
                                <a class="list-group-item list-group-item-action" href="#!">
                                    <!-- <i class="fas fa-dollar-sign fa-fw text-blue mr-2"></i> -->
                                    : <?= $get_dosen->NMDOSMSDOS; ?>
                                </a>
                            </td>

                        </tr>

                    </table>
                </div>
                <div class="card-footer border-top-0">
                    <a class="text-xs d-flex align-items-center justify-content-between" href="#!">
                    </a>
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

        <?php
        $alamat = $get_dosen->ALAMATDOSEN;
        $pecah_alamat = explode("\r", $alamat);
        $jalan_nomor = $pecah_alamat[0];
        $kelurahan = $pecah_alamat[1];
        ?>

        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Data Pribadi Dosen</div>
                <div class="card-body">
                    <form>
                        <!-- Form Group (username)-->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputUsername">No.KTP/SIM/ID</label>
                                <input class="form-control" id="inputUsername" type="text" placeholder="No.KTP/SIM/ID" value="<?= $get_dosen->NOKTPMSDOS; ?>" />
                            </div>
                            <!-- Form Group (first name)-->
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputFirstName">Tempat Lahir</label>
                                <input class="form-control" id="inputFirstName" type="text" placeholder="Tempat Lahir" value="<?= $get_dosen->TPLHRMSDOS; ?>" />
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputLastName">Tgl.Lahir</label>
                                <input class="form-control" id="inputLastName" type="text" placeholder="Tgl.Lahir" value="<?= $get_dosen->TGLHRMSDOS; ?>" />
                            </div>
                            <!-- Form Group (organization name)-->
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputOrgName">Email</label>
                                <input class="form-control" id="inputOrgName" type="text" placeholder="Email" value="<?= $get_dosen->EMAILDOSEN; ?>" />
                            </div>
                            <!-- Form Group (location)-->
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputLocation">Telp</label>
                                <input class="form-control" id="inputLocation" type="text" placeholder="Telp" value="<?= $get_dosen->TELPDOSEN; ?>" />
                            </div>
                            <!-- Form Group (phone number)-->
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputPhone">Jalan & Nomor</label>
                                <input class="form-control" id="inputPhone" type="text" placeholder="Jalan & Nomor" value="<?= $jalan_nomor; ?>" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputPhone">Desa atau Kelurahan & Kecamatan</label>
                                <input class="form-control" id="inputPhone" type="text" placeholder="Desa atau Kelurahan & Kecamatan" value="<?= $kelurahan; ?>" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputPhone">Kabupaten/Kota</label>
                                <input class="form-control" id="inputPhone" type="text" placeholder="Kabupaten/Kota" value="<?= $get_dosen->KOTADOSEN; ?>" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputPhone">Propinsi</label>
                                <input class="form-control" id="inputPhone" type="text" placeholder="Propinsi" value="<?= $get_dosen->PROPINSIDOSEN; ?>" />
                            </div>
                        </div>
                        <!-- Save changes button-->
                        <!-- <button class="btn btn-primary" type="button">Save changes</button>-->
                    </form>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Data Terkait Akademik</div>
                <div class="card-body">
                    <form>
                        <!-- Form Group (username)-->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputUsername">KODE DOSEN</label>
                                <input class="form-control" id="inputUsername" type="text" placeholder="KODE DOSEN" value="<?= $get_dosen->NODOSMSDOS; ?>" />
                            </div>
                            <!-- Form Group (first name)-->
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputFirstName">NIP PNS</label>
                                <input class="form-control" id="inputFirstName" type="text" placeholder="NIP PNS" value="<?= $get_dosen->NIPNSMSDOS; ?>" />
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputLastName">NIDN/NUPN</label>
                                <input class="form-control" id="inputLastName" type="text" placeholder="NIDN/NUPN" value="<?= $get_dosen->NODOSMSDOS; ?>" />
                            </div>
                            <!-- Form Group (organization name)-->
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputOrgName">Nama Dosen</label>
                                <input class="form-control" id="inputOrgName" type="text" placeholder="Nama Dosen" value="<?= $get_dosen->NMDOSMSDOS; ?>" />
                            </div>
                            <!-- Form Group (location)-->
                            <div class=" form-group col-md-6">
                                <label class="small mb-1" for="inputLocation">HomeBase Jenjang/Prodi</label>
                                <input class="form-control" id="inputLocation" type="text" placeholder="HomeBase Jenjang/Prodi" value="<?= $get_dosen->PTINDMSDOS; ?>" />
                            </div>
                            <!-- Form Group (phone number)-->
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputPhone">Gelar Dosen</label>
                                <input class="form-control" id="inputPhone" type="text" placeholder="Gelar Dosen" value="<?= $get_dosen->GELARMSDOS; ?>" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputPhone">Status Aktif</label>
                                <input class="form-control" id="inputPhone" type="text" placeholder="Status Aktif" value="<?= $status_aktif; ?>" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputPhone">Jenis Kelamin</label>
                                <input class="form-control" id="inputPhone" type="text" placeholder="Jenis Kelamin" value="<?= $jenis_kelamin; ?>" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputPhone">Pendidikan Tertinggi</label>
                                <input class="form-control" id="inputPhone" type="text" placeholder="Pendidikan Tertinggi" value="<?= $pendidikan_tertinggi ?>" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputPhone">Jabatan Akademik</label>
                                <input class="form-control" id="inputPhone" type="text" placeholder="Jabatan Akademik" value="<?= $jabatan_akademik; ?>" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="small mb-1" for="inputPhone">Ikatan Kerja</label>
                                <input class="form-control" id="inputPhone" type="text" placeholder="Ikatan Kerja" value="<?= $ikatan_kerja; ?>" />
                            </div>
                        </div>
                        <!-- Save changes button-->
                        <!-- <button class="btn btn-primary" type="button">Save changes</button>-->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/sb_admin_pro/resource_offline/iain_sispt_upload_profil.js" crossorigin="anonymous"></script>
