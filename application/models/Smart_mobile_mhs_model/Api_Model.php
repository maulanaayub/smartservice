<?php
class Api_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        //$this->db = $this->load->database('siakad', TRUE);
        $this->siakad = $this->load->database('siakad_dummy', TRUE);
    }
    public function get_valid_login()
    {
        $this->db = $this->load->database('default', TRUE);
        $this->db->select("username,password");
        $this->db->from("api_user");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cek_old_password($decrypt_encnim, $decrypt_newpass)
    {
        $this->siakad->select('*');
        $this->siakad->from('trresetpassword');
        $this->siakad->where('NIMHS', $decrypt_encnim);
        $this->siakad->where("OLDPASS = password(" . $this->siakad->escape($decrypt_newpass) . ")");
        $query = $this->siakad->get()->row();
        if ($query != null) {
            return true;
        } else {
            return false;
        }
    }

    public function get_data_mhs($id = null)
    {
        $this->siakad->select("a.NIMHSMSMHS as nim,c.KDFAKMSFAK as kodefakultas,b.KDPSTMSPST as kodepst,a.KDJENMSMHS as kodejen,a.NMMHSMSMHS as nama,c.NMFAKMSFAK as fakultas, b.NMPSTMSPST as programstudi ,d.NLIPKTRAKM as ipkkumulatif,d.SKSTTTRAKM as skstempuh,a.SMAWLMSMHS as angkatan,a.TAHUNMSMHS as tahunms,e.NMKODTBKOD as jenjang,a.TELP as telp,a.STMHSMSMHS as status,d.THSMSTRAKM AS th_terakhir_trakm,
        case when a.EMAIL is null then 'false' when a.EMAIL='' then 'false' else 'true' end as ISADDEMAIL, case when f.ISVERIF = 1 then 'true' else 'false' end as EMAILVERIFICATION,a.EMAIL");
        $this->siakad->from("msmhs as a");
        $this->siakad->join("mspst as b", "on a.KDPSTMSMHS = b.KDPSTMSPST", "left");
        $this->siakad->join("msfak as c", "on b.KDFAKMSPST = c.KDFAKMSFAK", "left");
        $this->siakad->join("trakm as d", "on a.NIMHSMSMHS = d.NIMHSTRAKM", "left");
        $this->siakad->join("tbkod as e", "on a.KDJENMSMHS = e.KDKODTBKOD", "left");
        $this->siakad->join("(select ISVERIFIED as ISVERIF,NIMHS,EMAILMHS from tremailverifmhs where NIMHS='$id' order by id desc limit 1) as f", "on a.NIMHSMSMHS = f.NIMHS and a.EMAIL = f.EMAILMHS", "left");
        $this->siakad->where('a.NIMHSMSMHS', $id);
        //$this->siakad->where("a.STMHSMSMHS != 'L'");
        $this->siakad->where("e.KDAPLTBKOD", 04);
        $this->siakad->order_by("d.THSMSTRAKM", 'desc');
        $this->siakad->limit("1");
        $query = $this->siakad->get();
        return $query->row_array();
    }

    public function get_cuti_mhs($nim, $thsmt)
    {
        $this->siakad->select('THSMSTRLSM');
        $this->siakad->from("trlsm");
        $this->siakad->where('replace(trim(NIMHSTRLSM),"-","")', $nim);
        $this->siakad->where('THSMSTRLSM', $thsmt);
        $this->siakad->where('STMHSTRLSM', 'C');
        $query = $this->siakad->get()->num_rows();

        if ($query > 0) {
            return true;
        } else {
            return false;
        }
    }

    function cek_thsmt_akademik()
    {
        $this->siakad->select('conf_keyval as semester_aktif');
        $this->siakad->from('konfigurasi');
        $this->siakad->where('conf_key', 'thsms');
        $query = $this->siakad->get();

        return $query->row();
    }

    function cek_thsmt_inputmk()
    {

        $this->siakad->where('conf_key', 'minatmkthsms');
        $query = $this->siakad->get('konfigurasi');

        return $query->row_array();
    }

    public function cek_thsmt_keu()
    {
        $this->siakad->select('conf_keyval as semester_aktif');
        $this->siakad->from('keu_konfigurasi');
        $this->siakad->where('conf_key', 'wsinquiry');
        $query = $this->siakad->get();
        return $query->row();
    }

    function cek_tgl_input_mk($conf_key)
    {
        $this->siakad->where('conf_key', $conf_key);
        $query = $this->siakad->get('konfigurasi');

        return $query->row_array();
    }

    function get_sks_ipk_kumulatif($nim)
    {
        $this->siakad->select("sum(B.SKSMKTBKMK) as jumlah_sks,ROUND(sum(B.SKSMKTBKMK * A.BOBOTTRNLM)/sum(B.SKSMKTBKMK),2) as jumlah_ipk");
        $this->siakad->from("(select * from trnlm where NIMHSTRNLM = '$nim'  AND NLAKHTRNLM is not null AND NLAKHTRNLM !='' group by KDKMKTRNLM) as A");
        $this->siakad->join("tbkmk as B", "ON A.KDJENTRNLM = B.KDJENTBKMK AND A.KDPSTTRNLM=B.KDPSTTBKMK AND A.KDKMKTRNLM=B.KDKMKTBKMK AND A.THSMSTRNLM=B.THSMSTBKMK", "left");


        $query = $this->siakad->get()->row_array();
        return $query;
    }

    // function get_list_mk_input_mk($thsmt,$kdjen,$kdpst,$nim){
    //     $star_sub= strlen($kdjen.$kdpst)+1;

    //     $this->siakad->select("a.THSMSTBKMK,a.KDJENTBKMK,a.KDPSTTBKMK,a.KDKMKTBKMK,a.NAKMKTBKMK,a.SKSMKTBKMK,a.SEMESTBKMK,case when b.nimhs is not null THEN 'Y' else 'T' end as ket_sudah_input,b.tglinput,
    //                             case when c.nimhs is not null THEN concat('KHS TA : ',c.thsms) else null end as pernah_ambil_khs,substring(e.kdkmksyarat,$star_sub,20) as kdkmksyarat,e.nilaisyarat,f.NLAKHTRNLM,g.bobot_min_syarat,h.bobot_mk,
    //                             case when f.THSMSTRNLM IS NOT NULL then 'Y' when e.kdkmksyarat is null then null else 'T' end as sudah_ambil_mk_syarat,
    //                             case when e.kdkmksyarat is not null and ((f.NLAKHTRNLM is null or f.NLAKHTRNLM='') and f.THSMSTRNLM IS NOT NULL) then 'tms1' 
    //                             when e.kdkmksyarat is not null and (f.NLAKHTRNLM is null and f.THSMSTRNLM IS NULL) then 'tms2' 
    //                             when e.kdkmksyarat is not null and (g.bobot_min_syarat > h.bobot_mk) then 'tms3'
    //                             else 'ms' end as syarat,i.NAKMKTBKMK as nama_makul_syarat");
    //     $this->siakad->from('tbkmk as a');
    //     $this->siakad->join("(select * from tmpminatmk where nimhs='$nim' and thsms ='$thsmt' and kdjen='$kdjen' and kdpst='$kdpst') as b",'on a.THSMSTBKMK = b.thsms and a.KDJENTBKMK=b.kdjen and a.KDPSTTBKMK=b.kdpst and a.KDKMKTBKMK = b.kdkmk','left');
    //     $this->siakad->join("(select * from pesertamk where nimhs ='$nim' AND thsms < $thsmt) as c","on a.KDJENTBKMK=c.kdjen and a.KDPSTTBKMK=c.kdpst and a.KDKMKTBKMK = c.kdkmk","left");
    //     //$this->siakad->join("(select * from trnlm where nimhstrnlm ='$nim' and kdpsttrnlm='$kdpst' and kdjentrnlm='$kdjen') as d","on a.KDJENTBKMK = d.KDJENTRNLM and a.KDPSTTBKMK = d.KDPSTTRNLM and a.KDKMKTBKMK = d.KDKMKTRNLM","left");
    //     $this->siakad->join("(select * from tbkmk_syarat where kdkmk like '".$kdjen.$kdpst."%') as e","on e.kdkmk = concat(a.KDJENTBKMK,a.KDPSTTBKMK,a.KDKMKTBKMK)","left");
    //     $this->siakad->join("(select * from trnlm where nimhstrnlm ='$nim' and kdpsttrnlm ='$kdpst' and kdjentrnlm='$kdjen') as f","on e.kdkmksyarat = concat(f.KDJENTRNLM,f.KDPSTTRNLM,f.KDKMKTRNLM)","left");
    //     $this->siakad->join("(select NLAKHTBBNL,bobottbbnl as bobot_min_syarat from tbbnl where thsmstbbnl ='$thsmt' and kdjentbbnl ='$kdjen' and kdpsttbbnl='$kdpst') as g","on e.nilaisyarat=g.NLAKHTBBNL","left");
    //     $this->siakad->join("(select NLAKHTBBNL,bobottbbnl as bobot_mk from tbbnl where thsmstbbnl ='$thsmt' and kdjentbbnl ='$kdjen' and kdpsttbbnl='$kdpst') as h","on f.NLAKHTRNLM=h.NLAKHTBBNL","left");
    //     $this->siakad->join("(select * from tbkmk where kdjentbkmk='$kdjen' and kdpsttbkmk='$kdpst' group by kdkmktbkmk) as i",'on e.kdkmksyarat = concat(i.KDJENTBKMK,i.KDPSTTBKMK,i.KDKMKTBKMK)',"left");

    //     $this->siakad->where('a.THSMSTBKMK',$thsmt);
    //     $this->siakad->where('a.KDJENTBKMK',$kdjen);
    //     $this->siakad->where('a.KDPSTTBKMK',$kdpst);

    //     $this->siakad->group_by('a.KDKMKTBKMK');
    //     $this->siakad->order_by('a.SEMESTBKMK,a.NAKMKTBKMK','asc');

    //     $query = $this->siakad->get();
    //     return $query->result_array();

    //     //tms1 = sudah ambil mk prasyarat tapi nilai belum dikeluarkan
    //     //tms2 = belum ambil mk prasyarat
    //     //tms3 = nilai mk prasyarat kurang
    // }

    function get_list_mk_input_mk($thsmt, $kdjen, $kdpst, $nim, $sem)
    {

        $this->siakad->select("a.THSMSTBKMK,a.KDJENTBKMK,a.KDPSTTBKMK,a.KDKMKTBKMK,a.NAKMKTBKMK,a.SKSMKTBKMK,a.SEMESTBKMK,case when b.nimhs is not null THEN 'Y' else 'T' end as ket_sudah_input,b.tglinput,
                                case when c.nimhs is not null THEN concat('KHS TA : ',c.thsms) else null end as pernah_ambil_khs,e.kdkmksyarat");
        $this->siakad->from('tbkmk as a');
        $this->siakad->join("(select * from tmpminatmk where nimhs='$nim' and thsms ='$thsmt' and kdjen='$kdjen' and kdpst='$kdpst') as b", 'on a.THSMSTBKMK = b.thsms and a.KDJENTBKMK=b.kdjen and a.KDPSTTBKMK=b.kdpst and a.KDKMKTBKMK = b.kdkmk', 'left');
        $this->siakad->join("(select * from pesertamk where nimhs ='$nim' AND thsms < $thsmt) as c", "on a.KDJENTBKMK=c.kdjen and a.KDPSTTBKMK=c.kdpst and a.KDKMKTBKMK = c.kdkmk", "left");
        //$this->siakad->join("(select * from trnlm where nimhstrnlm ='$nim' and kdpsttrnlm='$kdpst' and kdjentrnlm='$kdjen') as d","on a.KDJENTBKMK = d.KDJENTRNLM and a.KDPSTTBKMK = d.KDPSTTRNLM and a.KDKMKTBKMK = d.KDKMKTRNLM","left");
        $this->siakad->join("(select * from tbkmk_syarat where kdkmk like '" . $kdjen . $kdpst . "%') as e", "on e.kdkmk = concat(a.KDJENTBKMK,a.KDPSTTBKMK,a.KDKMKTBKMK)", "left");

        $this->siakad->where('a.THSMSTBKMK', $thsmt);
        $this->siakad->where('a.KDJENTBKMK', $kdjen);
        $this->siakad->where('a.KDPSTTBKMK', $kdpst);

        if ($sem <= 2) {
            $this->siakad->where('a.SEMESTBKMK', $sem);
        }


        $this->siakad->group_by('a.KDKMKTBKMK');
        $this->siakad->order_by('a.SEMESTBKMK,a.NAKMKTBKMK', 'asc');

        $query = $this->siakad->get();
        return $query->result_array();
    }

    function get_riwayat_mk_input_mk($thsmt, $kdjen, $kdpst, $nim)
    {

        $this->siakad->select("a.THSMSTBKMK,a.KDJENTBKMK,a.KDPSTTBKMK,a.KDKMKTBKMK,a.NAKMKTBKMK,a.SKSMKTBKMK,a.SEMESTBKMK,b.tglinput,
        case when c.nimhs is not null THEN concat('KHS TA : ',c.thsms) else null end as pernah_ambil_khs");
        $this->siakad->from('tbkmk as a');
        $this->siakad->join("tmpminatmk as b", 'on a.THSMSTBKMK = b.thsms and a.KDJENTBKMK=b.kdjen and a.KDPSTTBKMK=b.kdpst and a.KDKMKTBKMK = b.kdkmk', 'left');
        $this->siakad->join("(select * from pesertamk where nimhs ='$nim' AND thsms < $thsmt) as c", "on a.KDJENTBKMK=c.kdjen and a.KDPSTTBKMK=c.kdpst and a.KDKMKTBKMK = c.kdkmk", "left");


        $this->siakad->where('b.thsms', $thsmt);
        $this->siakad->where('b.kdjen', $kdjen);
        $this->siakad->where('b.kdpst', $kdpst);
        $this->siakad->where('b.nimhs', $nim);




        $this->siakad->group_by('a.KDKMKTBKMK');
        $this->siakad->order_by('a.SEMESTBKMK,a.NAKMKTBKMK', 'asc');

        $query = $this->siakad->get();
        return $query->result_array();
    }

    function get_list_mk_krs($thsmt, $kdjen, $kdpst, $nim, $sem)
    {
        $this->siakad->select("c.KDKMKTBKMK as kode_mk,c.SKSMKTBKMK as sks_mk,c.NAKMKTBKMK as makul,c.SEMESTBKMK,(ifnull(g.peserta_sementara,0) + ifnull(h.peserta_acc,0)) as peserta_terdaftar,d.jml as kuota,e.NMDOSMSDOS as nama_dosen,b.jam,
        case 
        when b.hari = '1' then 'Senin'
        when b.hari = '2' then 'Selasa'
        when b.hari = '3' then 'Rabu'
        when b.hari = '4' then 'Kamis'
        when b.hari = '5' then 'Jumat' 
        when b.hari = '6' then 'Sabtu' else 'Tidak Dijadwalkan' end as hari,
        e.GELARMSDOS AS gelar_dosen, e.NODOSMSDOS AS nodos,
        case when f.nimhs is null and i.nimhs is null then 'T' else 'Y' end as selected, case when j.nimhs is null then 'T' else 'Y' end as isacc, b.hari as jadwal_hari, b.jam as jadwal_jam,b.KELASTRAKD as jadwal_kelas,b.ruang as jadwal_ruang,f.nimhs");
        //referensi mata kuliah berdasarkan input pmk di tbl tmpminatmk
        $this->siakad->from('tmpminatmk as a');
        //referenisi jadwal mata kuliah
        $this->siakad->join('trakd as b', 'a.thsms = b.THSMSTRAKD and a.kdpst = b.KDPSTTRAKD and a.kdjen = b.KDJENTRAKD and a.kdkmk = b.KDKMKTRAKD', 'left');
        //referensi detail mata kuliah
        $this->siakad->join('tbkmk as c', 'a.thsms = c.THSMSTBKMK and a.kdpst = c.KDPSTTBKMK and a.kdjen = c.KDJENTBKMK and a.kdkmk = c.KDKMKTBKMK', 'left');
        //referensi kuota mata kuliah
        $this->siakad->join('trquota as d', 'a.thsms = d.thsms and a.kdpst = d.kdpst and a.kdjen = d.kdjen and a.kdkmk = d.kdkmk and b.NODOSTRAKD = d.nodos and b.KELASTRAKD = d.kelas', 'left');
        //referensi data dosen
        $this->siakad->join('msdos as e', 'b.NODOSTRAKD = e.NODOSMSDOS', 'left');
        //referensi krs mata kuliah yang sudah di input belum di acc
        $this->siakad->join('(select * from tmpkrs where nimhs = "' . $nim . '") as f', 'b.THSMSTRAKD = f.thsms and b.KDPSTTRAKD = f.kdpst and b.KDJENTRAKD = f.kdjen and b.KDKMKTRAKD = f.kdkmk and b.NODOSTRAKD = f.nodos and b.KELASTRAKD = f.jadwal_kelas', 'LEFT');
        //referensi jmlh peserta dari tabel tmpkrs
        $this->siakad->join('(select thsms,kdjen,kdpst,kdkmk,nodos,jadwal_kelas,count(nimhs) as peserta_sementara from tmpkrs where thsms ="' . $thsmt . '" and kdjen="' . $kdjen . '" and kdpst="' . $kdpst . '" and nimhs !="' . $nim . '" group by kdkmk,nodos,jadwal_kelas) as g', 'b.THSMSTRAKD = g.thsms and b.KDPSTTRAKD = g.kdpst and b.KDJENTRAKD = g.kdjen and b.KDKMKTRAKD = g.kdkmk and b.NODOSTRAKD = g.nodos and b.KELASTRAKD = g.jadwal_kelas', 'LEFT');
        //referensi jmlh peserta dari tabel pesertamk
        $this->siakad->join('(select thsms,kdjen,kdpst,kdkmk,nodos,kelas,count(nimhs) as peserta_acc from pesertamk where thsms ="' . $thsmt . '" and kdjen="' . $kdjen . '" and kdpst="' . $kdpst . '" and nimhs !="' . $nim . '" group by kdkmk,nodos,kelas) as h', 'b.THSMSTRAKD = h.thsms and b.KDPSTTRAKD = h.kdpst and b.KDJENTRAKD = h.kdjen and b.KDKMKTRAKD = h.kdkmk and b.NODOSTRAKD = h.nodos and b.KELASTRAKD = h.kelas', 'LEFT');
        //referensi krs mata kuliah yang sudah di input dan sudah di acc untuk ceklist jadwal yang dipiliah
        $this->siakad->join('(select * from pesertamk where nimhs = "' . $nim . '" and thsms="' . $thsmt . '" and kdpst="' . $kdpst . '" and kdjen="' . $kdjen . '") as i', 'b.THSMSTRAKD = i.thsms and b.KDPSTTRAKD = i.kdpst and b.KDJENTRAKD = i.kdjen and b.KDKMKTRAKD = i.kdkmk and b.NODOSTRAKD = i.nodos and b.KELASTRAKD = i.kelas', 'LEFT');
        //referensi krs mata kuliah yang sudah di input dan sudah di acc untuk menampilkan badge acc di nama mata kuliah
        $this->siakad->join('(select * from pesertamk where nimhs = "' . $nim . '" and thsms="' . $thsmt . '" and kdpst="' . $kdpst . '" and kdjen="' . $kdjen . '") as j', 'b.THSMSTRAKD = j.thsms and b.KDPSTTRAKD = j.kdpst and b.KDJENTRAKD = j.kdjen and b.KDKMKTRAKD = j.kdkmk ', 'LEFT');
        $this->siakad->where('a.nimhs', $nim);
        $this->siakad->where('a.thsms', $thsmt);
        $this->siakad->where('a.kdjen', $kdjen);
        $this->siakad->where('a.kdpst', $kdpst);
        $this->siakad->where('b.hari is not null');

        $this->siakad->order_by('c.NAKMKTBKMK,b.hari,b.jam', "ASC");
        $query = $this->siakad->get();
        return $query->result_array();
    }


    function get_nilai_mk_syarat($var, $nim, $kode_jen, $kode_pst, $thsmt)
    {
        $star_sub = strlen($kode_jen . $kode_pst) + 1;

        $this->siakad->select("substring(e.kdkmksyarat,$star_sub,20) as kdkmksyarat,i.NAKMKTBKMK as nama_makul_syarat,e.nilaisyarat as nilai_syarat_min,f.NLAKHTRNLM as nilai_mk,g.bobot_min_syarat as bobot_min,h.bobot_mk,
        case when f.NLAKHTRNLM ='' then 'tms1' 
        when f.NLAKHTRNLM is null then 'tms2' 
        when g.bobot_min_syarat > h.bobot_mk then 'tms3'
        else 'ms' end as syarat
        ");
        $this->siakad->from('tbkmk_syarat as e');
        $this->siakad->join("(select * from trnlm where nimhstrnlm ='$nim' and kdpsttrnlm ='$kode_pst' and kdjentrnlm='$kode_jen') as f", "on e.kdkmksyarat = concat(f.KDJENTRNLM,f.KDPSTTRNLM,f.KDKMKTRNLM)", "left");
        $this->siakad->join("(select NLAKHTBBNL,bobottbbnl as bobot_min_syarat from tbbnl where thsmstbbnl ='$thsmt' and kdjentbbnl ='$kode_jen' and kdpsttbbnl='$kode_pst') as g", "on e.nilaisyarat=g.NLAKHTBBNL", "left");
        $this->siakad->join("(select NLAKHTBBNL,bobottbbnl as bobot_mk from tbbnl where thsmstbbnl ='$thsmt' and kdjentbbnl ='$kode_jen' and kdpsttbbnl='$kode_pst') as h", "on f.NLAKHTRNLM=h.NLAKHTBBNL", "left");
        $this->siakad->join("(select * from tbkmk where kdjentbkmk='$kode_jen' and kdpsttbkmk='$kode_pst' group by kdkmktbkmk) as i", 'on e.kdkmksyarat = concat(i.KDJENTBKMK,i.KDPSTTBKMK,i.KDKMKTBKMK)', "left");
        $this->siakad->where('e.kdkmk', $var);

        $query = $this->siakad->get();
        return $query->result_array();
    }



    function get_prodi_jatah_sks($kdjen, $kdpst)
    {
        $this->siakad->select('rentang1,rentang2,jatahsks');
        $this->siakad->from('tbjatahsks');
        $this->siakad->where('kdjen', $kdjen);
        $this->siakad->where('kdpst', $kdpst);
        $query = $this->siakad->get();

        return $query->result_array();
    }

    function get_ips_mhs($nim, $thsmt_min_1, $kode_jen, $kode_pst)
    {
        $this->siakad->select('(sum(BOBOTTRNLM)/COUNT(KDKMKTRNLM)) AS ips');
        $this->siakad->from('trnlm');
        $this->siakad->where('NIMHSTRNLM', $nim);
        $this->siakad->where('THSMSTRNLM', $thsmt_min_1);
        $this->siakad->where('KDJENTRNLM', $kode_jen);
        $this->siakad->where('KDPSTTRNLM', $kode_pst);
        $query = $this->siakad->get()->row();

        return $query->ips;
    }

    function cek_cuti_mhs($nim, $kdpst, $thsmt_min_1)
    {

        $this->siakad->select('STMHSTRLSM');
        $this->siakad->from('trlsm');
        $this->siakad->where('NIMHSTRLSM', $nim);
        $this->siakad->where('THSMSTRLSM', $thsmt_min_1);
        $this->siakad->where('KDPSTTRLSM', $kdpst);
        $this->siakad->where('STMHSTRLSM', 'C');

        $query = $this->siakad->get()->num_rows();
        return $query;
    }

    function cek_last_registrasi($nim, $thinputmk)
    {
        $this->siakad->select('max(THSMS) as thsms_aktif_terakhir');
        $this->siakad->from('trregistrasi');
        $this->siakad->where('NIMHS', $nim);
        $this->siakad->where('THSMS <', $thinputmk);
        $query = $this->siakad->get()->row_array();
        return $query;
    }


    function check_user_mhs($username, $password)
    {
        $this->siakad->select('*');
        $this->siakad->from('msmhs');
        $this->siakad->where('NIMHSMSMHS', $username);
        $this->siakad->where("login_pass = password(" . $this->siakad->escape($password) . ")");
        $query = $this->siakad->get();
        return $query->row();
    }





    public function get_angkatan($id = null)
    {
        $this->siakad->select("a.TAHUNMSMHS as angkatan");
        $this->siakad->from("msmhs as a");
        $this->siakad->where('a.NIMHSMSMHS', $id);
        $query = $this->siakad->get();
        return $query->row();
    }

    public function get_cuti($nim)
    {
        $this->siakad->select('THSMSTRLSM');
        $this->siakad->from("trlsm");
        $this->siakad->where('replace(trim(NIMHSTRLSM),"-","")', $nim);
        $this->siakad->where('STMHSTRLSM', 'C');
        $query = $this->siakad->get();
        return $query->result();
    }

    public function get_data_khs($thsmt_selected, $nim, $kdjen, $kdpst)
    {
        $this->siakad->select("c.NAKMKTBKMK as makul,c.SKSMKTBKMK as sks,a.kelas,case when b.NLAKHTRNLM is null then '-' when b.NLAKHTRNLM = '' THEN '-'  Else b.NLAKHTRNLM end as nilaihuruf,b.BOBOTTRNLM as nilaiangka");
        $this->siakad->from("pesertamk as a");
        $this->siakad->join("trnlm as b", "on a.thsms = b.thsmstrnlm and a.nimhs = b.nimhstrnlm and a.kdjen = b.kdjentrnlm and a.kdpst = b.kdpsttrnlm and a.kdkmk = b.kdkmktrnlm", "left");
        $this->siakad->join("tbkmk as c", "on a.thsms = c.thsmstbkmk and a.kdjen = c.kdjentbkmk and a.kdpst = c.kdpsttbkmk and a.kdkmk = c.kdkmktbkmk", "left");
        $this->siakad->where("a.thsms", $thsmt_selected);
        $this->siakad->where("a.kdpst", $kdpst);
        $this->siakad->where("a.kdjen", $kdjen);
        $this->siakad->where("a.nimhs", $nim);
        $query = $this->siakad->get();
        return $query->result_array();
    }

    public function get_data_krs($thsmt, $nim, $kdjen, $kdpst)
    {

        $this->siakad->select("c.nimhs,c.thsms,c.nodos,c.kelas,
        case 
        when c.pjadwal_hari = '1' then 'Senin'
        when c.pjadwal_hari = '2' then 'Selasa'
        when c.pjadwal_hari = '3' then 'Rabu'
        when c.pjadwal_hari = '4' then 'Kamis'
        when c.pjadwal_hari = '5' then 'Jumat' 
        when c.pjadwal_hari = '6' then 'Sabtu' 
        else 'Tidak Dijadwalkan' end as hari
        ,case when c.pjadwal_jam is null then '-' when c.pjadwal_jam='' then '-' else c.pjadwal_jam end as jam,
        case when c.pjadwal_ruang is null then '-' when c.pjadwal_ruang ='' then '-' else c.pjadwal_ruang end as ruang,d.NAKMKTBKMK as makul,d.SKSMKTBKMK as sks,c.kdkmk as kode_mk,e.GELARMSDOS as gelar,e.NMDOSMSDOS as dosen,c.kdjen,c.kdpst,d.SEMESTBKMK");
        $this->siakad->from('pesertamk as c');
        $this->siakad->join('tbkmk as d', 'c.kdpst = d.KDPSTTBKMK and c.kdkmk = d.KDKMKTBKMK and c.thsms = d.THSMSTBKMK', 'left');
        $this->siakad->join('msdos as e', 'c.nodos = e.NODOSMSDOS', 'left');
        $this->siakad->where('c.nimhs', $nim);
        $this->siakad->where('c.thsms', $thsmt);
        $this->siakad->where('c.kdjen', $kdjen);
        $this->siakad->where('c.kdpst', $kdpst);


        $this->siakad->order_by('pjadwal_hari,pjadwal_jam', 'asc');
        $query = $this->siakad->get();
        return $query->result_array();
    }

    public function get_data_pengumuman($prodi, $star_row, $limit, $search)
    {
        $this->siakad->select("a.judul,a.deskripsi as isi,a.tanggal,a.idpengumumanctg as kd_kategori, b.nmpengumumanctg as kategori, a.params");
        $this->siakad->from("trpengumuman as a");
        $this->siakad->join("mspengumumanctg as b", "on a.idpengumumanctg = b.idpengumumanctg", "left");
        $this->siakad->where_in("b.idpengumumanctg", array(1, 2, 3, 6, 8, 9, 10, 11, 12, 13, 14, 17, 18, 18));



        if ($search != null || $search != "") {
            $this->siakad->like("a.judul", $search);
            $this->siakad->limit(30);
            //$this->siakad->like('a.params', $prodi);
        } else {
            $this->siakad->or_like('a.params', $prodi);
            $this->siakad->limit($limit, $star_row);
        }
        $this->siakad->order_by("a.tanggal", 'desc');

        $query = $this->siakad->get();
        return $query->result_array();
    }

    public function get_data_params()
    {
        $this->siakad->select("a.params");
        $this->siakad->from("trpengumuman as a");
        $this->siakad->join("mspengumumanctg as b", "on a.idpengumumanctg = b.idpengumumanctg", "left");
        $this->siakad->order_by("a.tanggal", 'desc');
        $this->siakad->limit("10");
        $query = $this->siakad->get();
        return $query->result_array();
    }

    function cek_nim_siakad($nim)
    {

        $this->siakad->where('replace(trim(NIMHSMSMHS),"-","")', $nim);
        $this->siakad->or_where('replace(trim(NIMHSMSMHS),".","")', $nim);
        $this->siakad->or_where('trim(NIMHSMSMHS)', $nim);
        $query = $this->siakad->get('msmhs', 1);
        return $query->row_array();
    }

    function cek_nim_email_siakad($nim, $email)
    {
        $this->siakad->select("a.NIMHSMSMHS,a.EMAIL,b.EMAILMHS,b.ISVERIFIED");
        $this->siakad->from("msmhs as a");
        $this->siakad->join("(select * from tremailverifmhs where NIMHS = '$nim' order by ID desc limit 1) as b", "a.NIMHSMSMHS = b.NIMHS and a.EMAIL = b.EMAILMHS", "left");
        $this->siakad->where('replace(trim(a.NIMHSMSMHS),"-","")', $nim);
        $this->siakad->where('a.EMAIL', $email);
        $query = $this->siakad->get()->row_array();
        if ($query != null) {
            if (($query['EMAIL'] != null || $query['EMAIL'] != "") && $query['ISVERIFIED'] === '1') {
                return 1; // email sudah diverifikasi
            } else if (($query['EMAIL'] != null || $query['EMAIL'] != "") && ($query['ISVERIFIED'] === '0' && $query['EMAILMHS'] != null)) {
                return 2;
            } else {
                return 3;
            }
        } else {
            return 4;
        }
    }

    function get_old_pass_mhs($nim, $email)
    {
        $this->siakad->select("a.NIMHSMSMHS,a.EMAIL,a.login_pass");
        $this->siakad->from("msmhs as a");
        $this->siakad->where('replace(trim(a.NIMHSMSMHS),"-","")', $nim);
        $this->siakad->where('a.EMAIL', $email);

        return $this->siakad->get()->row_array();
    }

    function cek_status_aktif_mhs($thsmt, $nim)
    {
        $this->siakad->select('*');
        $this->siakad->from('trregistrasi');
        $this->siakad->where('THSMS', $thsmt);
        $this->siakad->where('NIMHS', $nim);
        $query = $this->siakad->get()->num_rows();

        if ($query > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function jadwal_kuliah_mhs_api_mobile($idmhs, $thsmt)
    {
        $this->siakad->select("c.nimhs,c.thsms,c.nodos,c.kelas,
        case 
        when c.pjadwal_hari = '1' then 'Senin'
        when c.pjadwal_hari = '2' then 'Selasa'
        when c.pjadwal_hari = '3' then 'Rabu'
        when c.pjadwal_hari = '4' then 'Kamis'
        when c.pjadwal_hari = '5' then 'Jumat' 
        when c.pjadwal_hari = '6' then 'Sabtu' 
        else 'Tidak Dijadwalkan' end as hari
        ,case when c.pjadwal_jam is null then '-' when c.pjadwal_jam='' then '-' else c.pjadwal_jam end as jam,
        case when c.pjadwal_ruang is null then '-' when c.pjadwal_ruang ='' then '-' else c.pjadwal_ruang end as ruang,d.NAKMKTBKMK as makul,d.SKSMKTBKMK as sks,c.kdkmk as kode_mk,e.GELARMSDOS as gelar,e.NMDOSMSDOS as dosen,c.kdjen,c.kdpst");
        $this->siakad->from('pesertamk as c');
        $this->siakad->join('tbkmk as d', 'c.kdpst = d.KDPSTTBKMK and c.kdkmk = d.KDKMKTBKMK and c.thsms = d.THSMSTBKMK', 'left');
        $this->siakad->join('msdos as e', 'c.nodos = e.NODOSMSDOS', 'left');
        $this->siakad->where('c.nimhs', $idmhs);
        $this->siakad->where('c.thsms', $thsmt);

        $this->siakad->order_by('pjadwal_hari,pjadwal_jam', 'asc');
        $query = $this->siakad->get();
        return $query->result_array();
    }

    function input_penawaran_mata_kuliah($nim, $kdjen, $kdpst, $thsms, $data)
    {

        $this->siakad->trans_begin();
        $this->siakad->where('nimhs', $nim);
        $this->siakad->where('kdjen', $kdjen);
        $this->siakad->where('kdpst', $kdpst);
        $this->siakad->where('thsms', $thsms);
        $this->siakad->delete('tmpminatmk');

        $this->siakad->insert_batch('tmpminatmk', $data);

        if ($this->siakad->trans_status() === false) {
            $this->siakad->trans_rollback();
            return false;
        } else {
            $this->siakad->trans_commit();
            return true;
        }
    }

    function input_krs_mata_kuliah($nim, $kdjen, $kdpst, $thsms, $data)
    {

        $this->siakad->trans_begin();
        $this->siakad->where('nimhs', $nim);
        $this->siakad->where('kdjen', $kdjen);
        $this->siakad->where('kdpst', $kdpst);
        $this->siakad->where('thsms', $thsms);
        $this->siakad->delete('tmpkrs');

        $this->siakad->insert_batch('tmpkrs', $data);

        if ($this->siakad->trans_status() === false) {
            $this->siakad->trans_rollback();
            return false;
        } else {
            $this->siakad->trans_commit();
            return true;
        }
    }

    function cek_sisa_kuota($kdjen, $kdpst, $thsmt, $array_kdkmk, $array_dosen, $array_kelas)
    {
        $this->siakad->select('a.kdkmk,a.nodos,a.kdpst,a.thsms,a.kelas,a.jml,(a.jml-(g.peserta_sementara+ h.peserta_acc)) as sisa_kuota');
        $this->siakad->from('trquota as a');
        $this->siakad->join('(select thsms,kdjen,kdpst,kdkmk,nodos,jadwal_kelas,count(nimhs) as peserta_sementara from tmpkrs where thsms ="' . $thsmt . '" and kdjen="' . $kdjen . '" and kdpst="' . $kdpst . '" group by kdkmk,nodos,jadwal_kelas) as g', 'a.thsms = g.thsms and a.kdpst = g.kdpst and a.kdjen = g.kdjen and a.kdkmk = g.kdkmk and a.nodos = g.nodos and a.kelas = g.jadwal_kelas', 'LEFT');
        $this->siakad->join('(select thsms,kdjen,kdpst,kdkmk,nodos,kelas,count(nimhs) as peserta_acc from pesertamk where thsms ="' . $thsmt . '" and kdjen="' . $kdjen . '" and kdpst="' . $kdpst . '" group by kdkmk,nodos,kelas) as h', 'a.thsms = h.thsms and a.kdpst = h.kdpst and a.kdjen = h.kdjen and a.kdkmk = h.kdkmk and a.nodos = h.nodos and a.kelas = h.kelas', 'LEFT');
        $this->siakad->where('a.kdjen', $kdjen);
        $this->siakad->where('a.kdpst', $kdpst);
        $this->siakad->where('a.thsms', $thsmt);
        $this->siakad->where_in('a.kdkmk', $array_kdkmk);
        $this->siakad->where_in('a.nodos', $array_dosen);
        $this->siakad->where_in('a.kelas', $array_kelas);

        $array_quota = $this->siakad->get()->result_array();

        return $array_quota;
    }

    public function get_rekap_bayar_tghn_mhs($nim, $kdjen, $kdpst)
    {
        $this->siakad->select('a.sem as semester,b.uraian as namatagihan,a.jumlah,a.tgl as tanggalbayar,a.userid as melalui,a.ket as keterangan');
        $this->siakad->from('keu_trans as a');
        $this->siakad->join("keu_coa as b", "on a.norek = b.norek and a.thsms = b.thsms", "left");
        $this->siakad->where("a.nimnoreg", $nim);
        //$this->siakad->where("a.kdpst",$kdpst);
        $this->siakad->where("a.kdjen", $kdjen);
        return $this->siakad->get()->result_array();
    }

    public function get_tagihan($nim, $semester_mhs, $param_smt_cuti = null)
    {
        $this->siakad->select("a.sem as semester,a.norek as kode_tagihan,c.uraian as namatagihan,a.jumlah");
        $this->siakad->from("keu_kombireg as a");
        $this->siakad->join("keu_trans as b", " on a.nimnoreg = b.nimnoreg and a.norek = b.norek and a.sem = b.sem", "left");
        $this->siakad->join("keu_coa as c", "on a.norek = c.norek and a.thsms = c.thsms", "left");
        $this->siakad->where('replace(trim(a.nimnoreg),"-","")', $nim);
        $this->siakad->where("b.jumlah IS NULL");

        if ($param_smt_cuti != null) {
            $this->siakad->where_not_in("a.sem", $param_smt_cuti);
        }

        $this->siakad->where("a.jumlah > 0");
        $this->siakad->where("a.sem > 1");
        $this->siakad->where("a.sem <=" . $semester_mhs);

        $query = $this->siakad->get();
        return $query->result_array();
    }

    public function change_email_mhs($nim, $kdpst, $dataupdate, $datainsert)
    {


        $this->siakad->trans_begin();


        $this->siakad->where('NIMHSMSMHS', $nim);
        $this->siakad->where('KDPSTMSMHS', $kdpst);
        $this->siakad->update('msmhs', $dataupdate);


        $this->siakad->insert('tremailverifmhs', $datainsert);

        if ($this->siakad->trans_status() === false) {
            $this->siakad->trans_rollback();
            return 0;
        } else {
            $id = $this->siakad->insert_id();
            $this->siakad->trans_commit();
            return $id;
        }
    }


    public function create_otp_reset_password_mhs($datainsert)
    {

        $this->siakad->insert('trresetpassword', $datainsert);

        if ($this->siakad->affected_rows() > 0) {
            $id = $this->siakad->insert_id();
            return $id;
        } else {
            return 0;
        }
    }


    public function cek_waktu_periksa_otp($unim)
    {
        $this->siakad->select('*');
        $this->siakad->from('tremailverifmhs');
        $this->siakad->where('NIMHS', $unim);
        $this->siakad->order_by('ID', 'DESC');
        $this->siakad->limit(1);

        $hasil = $this->siakad->get()->row_array();

        if ($hasil != null) {
            $sisa = $hasil['OTPVALIDUTIL'] - time();
            return $sisa;
        } else {
            return 0;
        }
    }

    public function cek_waktu_periksa_otp_reset_password($unim)
    {
        $this->siakad->select('*');
        $this->siakad->from('trresetpassword');
        $this->siakad->where('NIMHS', $unim);
        $this->siakad->order_by('ID', 'DESC');
        $this->siakad->limit(1);

        $hasil = $this->siakad->get()->row_array();

        if ($hasil != null) {
            $sisa = $hasil['OTPVALIDUTIL'] - time();
            return $sisa;
        } else {
            return 0;
        }
    }

    public function cek_otp_email($unim, $email, $otp_post)
    {
        $this->siakad->select('*');
        $this->siakad->from('tremailverifmhs');
        $this->siakad->where('NIMHS', $unim);
        $this->siakad->where('OTP', $otp_post);
        $this->siakad->where('EMAILMHS', $email);
        $this->siakad->where('ISVERIFIED', 0);
        $this->siakad->limit(1);

        $hasil = $this->siakad->get()->row_array();

        if ($hasil != null) {
            if (time() < $hasil['OTPVALIDUTIL']) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 0;
        }
    }

    public function cek_otp_reset_password($unim, $email, $otp_post, $isverified = 0)
    {
        $this->siakad->select('*');
        $this->siakad->from('trresetpassword');
        $this->siakad->where('NIMHS', $unim);
        $this->siakad->where('OTP', $otp_post);
        $this->siakad->where('EMAILMHS', $email);
        $this->siakad->where('ISVERIFIED', $isverified);
        $this->siakad->limit(1);

        $hasil = $this->siakad->get()->row_array();

        if ($hasil != null) {
            if (time() < $hasil['OTPVALIDUTIL']) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 0;
        }
    }

    public function cek_otp_when_try_to_change_password($unim, $email, $otp_post)
    {
        $this->siakad->select('*');
        $this->siakad->from('trresetpassword');
        $this->siakad->where('NIMHS', $unim);
        $this->siakad->where('EMAILMHS', $email);
        $this->siakad->where('ISVERIFIED', 1);


        $this->siakad->order_by('ID', 'DESC');
        $this->siakad->limit(1);

        $hasil = $this->siakad->get()->row_array();

        if ($hasil != null) {
            if ($hasil['OTP'] == $otp_post && $hasil['USETOCHANGEPASSWORD'] == 0) {
                return 2; //true
            } else {
                return 1; //false
            }
        } else {
            return 0; //false
        }
    }



    public function update_password_and_useotp_mahasiswa($nim, $password, $email, $otp)
    {

        $this->siakad->trans_begin();
        $this->siakad->query('update msmhs set login_pass=PASSWORD("' . $password . '") where NIMHSMSMHS="' . $nim . '" and EMAIL="' . $email . '"');
        $this->siakad->query('update trresetpassword set usetochangepassword = 1 where NIMHS="' . $nim . '" and OTP="' . $otp . '"');


        if ($this->siakad->trans_status() === false) {
            $this->siakad->trans_rollback();
            return false;
        } else {
            $this->siakad->trans_commit();
            return true;
        }




        if ($this->siakad->affected_rows() >= 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update_password_using_old_password($decrypt_encnim, $decrypt_newpass, $decrypt_email,$data_insert){
         $this->siakad->trans_begin();
        $this->siakad->query('update msmhs set login_pass=PASSWORD("' . $decrypt_newpass . '") where NIMHSMSMHS="' . $decrypt_encnim . '" and EMAIL="' . $decrypt_email . '"');
        $this->siakad->insert('trresetpassword', $data_insert);

        if ($this->siakad->trans_status() === false) {
            $this->siakad->trans_rollback();
            return false;
        } else {
            $this->siakad->trans_commit();
            return true;
        }




        if ($this->siakad->affected_rows() >= 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update_email_verified($unim, $email, $otp_post, $data_update_tremailverif)
    {

        $this->siakad->where('NIMHS', $unim);
        $this->siakad->where('EMAILMHS', $email);
        $this->siakad->where('OTP', $otp_post);
        $this->siakad->update('tremailverifmhs', $data_update_tremailverif);

        if ($this->siakad->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update_otp_res_pas_verified($unim, $email, $otp_post, $data_update_trresetpassword)
    {

        $this->siakad->where('NIMHS', $unim);
        $this->siakad->where('EMAILMHS', $email);
        $this->siakad->where('OTP', $otp_post);
        $this->siakad->update('trresetpassword', $data_update_trresetpassword);

        if ($this->siakad->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_otp($unim, $update_insert_id)
    {
        $this->siakad->where('NIMHS', $unim);
        $this->siakad->where('ID', $update_insert_id);
        $this->siakad->delete('tremailverifmhs');
    }

    public function delete_otp_reset_password($unim, $update_insert_id)
    {
        $this->siakad->where('NIMHS', $unim);
        $this->siakad->where('ID', $update_insert_id);
        $this->siakad->delete('trresetpassword');
    }


    public function cek_limit_verif_email($unim)
    {

        $this->siakad->select('count(NIMHS) as total_percobaan');
        $this->siakad->from('tremailverifmhs');
        $this->siakad->where('NIMHS', $unim);
        $this->siakad->where("TANGGALINPUT >=", 'CURDATE()', FALSE);
        $query = $this->siakad->get()->row_array();

        return $query['total_percobaan'];
    }

    public function cek_limit_reset_password($unim)
    {

        $this->siakad->select('count(NIMHS) as total_percobaan');
        $this->siakad->from('trresetpassword');
        $this->siakad->where('NIMHS', $unim);
        $this->siakad->where("TANGGALINPUT >=", 'CURDATE()', FALSE);
        $query = $this->siakad->get()->row_array();

        return $query['total_percobaan'];
    }

    public function cek_exist_email($email)
    {
        $this->siakad->select('*');
        $this->siakad->from('tremailverifmhs');
        $this->siakad->where('EMAILMHS', $email);
        $this->siakad->where('ISVERIFIED', 1);

        $query = $this->siakad->get()->row_array();

        if ($query != null) {
            return false;
        } else {
            return true;
        }
    }

    public function cek_perangkat_mhs($username, $iddevice)
    {
        //cek perangkat mhs terdaftar
        $this->siakad->select('*');
        $this->siakad->from('trdevicemhs');
        $this->siakad->where('NIMHS', $username);
        $this->siakad->where('AKTIFASI', 1);
        $this->siakad->order_by('TGLLOGIN', 'DESC');
        $query1 = $this->siakad->get()->row_array();

        //cek perangkat terdaftar di akun lain
        $this->siakad->select('*');
        $this->siakad->from('trdevicemhs');
        $this->siakad->where("NIMHS !='$username'");
        $this->siakad->where("DEVICEID", $iddevice);
        $this->siakad->where('AKTIFASI', 1);
        $this->siakad->order_by('TGLLOGIN', 'DESC');
        $query2 = $this->siakad->get()->row_array();

        //cek mhasiswa perangkat pertamakali atau sdh ada perangkat sebelumnya
        $this->siakad->select('*');
        $this->siakad->from('trdevicemhs');
        $this->siakad->where("NIMHS",$username);
        $this->siakad->where('AKTIFASI', 0);
        $query3 = $this->siakad->get()->result_array();


        if ($query2 != null) {
            return 1; // user berganti perangkat dan perangkat pernah digunakan user lain
        } else if ($query1 != null && $query1['DEVICEID'] != $iddevice) {
            return 2; // user berganti perangkat dan perangkat belum pernah digunakan user lain
        } else if ($query1 != null && $query1['DEVICEID'] === $iddevice) {
            return 3; // user login dengan perangkat sama dengan yang terdaftar
        } else if ($query3 != null) {
            return 4; // user pernah aktiv dengan perangkat lain sebelumnya
        } else {
            return 5; // user belum ada perangkat aktiv
        }
    }

    public function cek_waktu_blokir_device_and_mhs($nim, $iddevice)
    {
        //cek waktu blokir mhs
        $this->siakad->select('BATASBLOKIRDEVICEBARU');
        $this->siakad->from('trdevicemhs');
        $this->siakad->where('NIMHS', $nim);
        $this->siakad->order_by('TGLLOGIN', 'DESC');
        $query1 = $this->siakad->get()->row_array();

        //cek waktu blokir perangkat
        $this->siakad->select('NIMHS,BATASBLOKIRDEVICEBARU');
        $this->siakad->from('trdevicemhs');
        $this->siakad->where("DEVICEID", $iddevice);
        $this->siakad->order_by('TGLLOGIN', 'DESC');
        $query2 = $this->siakad->get()->row_array();

        if ($query1 != null || $query2!=null) {
            if ($query1['BATASBLOKIRDEVICEBARU'] > time()) {
                $data = array('kode' => 2, 'message' => 'Akun kamu tidak dapat berganti perangkat sampai ' . date("d F Y", $query1['BATASBLOKIRDEVICEBARU']) . ' ' . date("H:i", $query1['BATASBLOKIRDEVICEBARU']).', Untuk menghubungkan akunmu dengan perangkat lain silahkan tunggu sampai batas blokir selesai');
                
                return $data;
            } else {
                if ($query2 != null) {
                    if ($query2['BATASBLOKIRDEVICEBARU'] > time()) {
                        $hitungkaratker = strlen($query2['NIMHS']);
                        $jumlahkarakterdibintang = floor((0.40)* $hitungkaratker);
                        $jumlahkaraktertidakbintang = $hitungkaratker - $jumlahkarakterdibintang;

                        $stringtanpabintang = substr($query2['NIMHS'], 0, $jumlahkaraktertidakbintang);
                        $stringbintang = str_repeat('*',$jumlahkarakterdibintang);
                        
                        $bintangreplace = $stringtanpabintang.$stringbintang;
                        $data = array('kode' => 1, 'message' => 'Perangkat ini terkunci sampai ' . date("d F Y", $query2['BATASBLOKIRDEVICEBARU']) . ' ' . date("H:i", $query2['BATASBLOKIRDEVICEBARU']) . ', karena saat ini perangkat masih terhubung dengan akun ' . $bintangreplace. ', Untuk menghubungkan perangkat ini dengan akun lain silahkan tunggu sampai batas blokir selesai');
                        return $data;
                    } else {
                        $data = array('kode' => 3, 'message' => 'Perangkat dapat ditautkan');
                        return $data;
                    }
                } else {
                    $data = array('kode' => 3, 'message' => 'Perangkat dapat ditautkan');
                    return $data;
                }
            }
        }else{
            $data = array('kode' => 3, 'message' => 'Perangkat dapat ditautkan');
            return $data;
        }
    }

    public function insert_new_device_and_nonactiv_this_device_in_another_account($iddevice, $username, $data_update, $data_insert)
    {
        $this->siakad->trans_begin();

        $this->siakad->where("NIMHS='$username'");
        $this->siakad->or_where('DEVICEID', $iddevice);
        $this->siakad->update('trdevicemhs', $data_update);


        $this->siakad->insert('trdevicemhs', $data_insert);

        if ($this->siakad->trans_status() === false) {
            $this->siakad->trans_rollback();
            return false;
        } else {
            $this->siakad->trans_commit();
            return true;
        }
    }

    public function insert_new_device_and_update_old_device($username, $data_update, $data_insert)
    {
        $this->siakad->trans_begin();

        $this->siakad->where("NIMHS", $username);
        $this->siakad->update('trdevicemhs', $data_update);


        $this->siakad->insert('trdevicemhs', $data_insert);

        if ($this->siakad->trans_status() === false) {
            $this->siakad->trans_rollback();
            return false;
        } else {
            $this->siakad->trans_commit();
            return true;
        }
    }

    public function non_active_old_device($nim,$data_update){
        $this->siakad->where("NIMHS", $nim);
        $this->siakad->update('trdevicemhs', $data_update);

        if ($this->siakad->affected_rows() >= 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update_data_perangkat($username, $iddevice, $data_update)
    {
        $this->siakad->where("NIMHS", $username);
        $this->siakad->where("DEVICEID", $iddevice);
        $this->siakad->where("AKTIFASI", 1);
        $this->siakad->update('trdevicemhs', $data_update);

        if ($this->siakad->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function add_device_mhs($data)
    {
        $this->siakad->insert('trdevicemhs', $data);
        if ($this->siakad->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
