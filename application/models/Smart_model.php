<?php
class Smart_model extends CI_Model
{
    public function getlinklogout()
    {
        $this->db->select("logout_uri,AppName");
        $this->db->from("oauth_clients");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_list_app($username)
    {
        $this->db->select('c.AppName,c.client_id,c.redirect_uri,c.logout_uri,c.kategori,a.nama_kategori');
        $this->db->from('oauth_access as b');
        $this->db->join('oauth_clients as c', 'b.access_client_id = c.client_id');
        $this->db->join('oauth_kategori as a', 'c.kategori = a.id_kategori');
        $this->db->where("b.access_user_id", $username);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_kateg($username)
    {
        $this->db->select('a.*,k.*');
        $this->db->from('oauth_access as a');
        $this->db->join('oauth_clients as j', 'a.access_client_id = j.client_id');
        $this->db->join('oauth_kategori as k', 'j.kategori = k.id_kategori');
        $this->db->where("a.access_user_id", $username);
        $this->db->group_by('k.nama_kategori');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function list2($username)
    {
        $this->db->select('a.*,b.*,c.*');
        $this->db->from('oauth_access as a');
        $this->db->join('oauth_clients as b', 'a.access_client_id = b.client_id');
        $this->db->join('oauth_kategori as c', 'b.kategori = c.id_kategori');
        $this->db->where("a.access_user_id", $username);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_forbidden_name($cid){
        $this->db->select("AppName");
        $this->db->from("oauth_clients");
        $this->db->where("client_id", $cid);
        $query = $this->db->get();
        return $query->row();
    }

    public function cek_thsmt_siakad(){
		$this->db2 = $this->load->database('siakad', TRUE);
		$this->db2->where('conf_key', 'thsms');
		$sql_employees=$this->db2->get('konfigurasi');
		if($sql_employees->num_rows()>0){
			return $sql_employees->row_array();
		}
		
    }
    
    // public function cek_mhs_aktif($th_smt){
    //     $this->db2 = $this->load->database('siakad', TRUE);
	// 	$this->db2->select('COUNT(NIMHS) AS jumlah');
    //     $this->db2->from('trregistrasi');
    //     $this->db2->where('THSMS',$th_smt);
    //     $query = $this->db2->get();
    //     return $query->row();
    // }

    public function cek_mhs_aktif($th_smt_max,$th_smt_min){
        $this->db2 = $this->load->database('siakad', TRUE);
		$this->db2->select('a.thsmt, case when b.jumlah is null then 0 else b.jumlah end as jumlah',false);
        $this->db2->from('msthsmt_smart as a');
        $this->db2->join('( SELECT THSMS,COUNT(NIMHS) AS jumlah FROM trregistrasi as ab inner join msmhs as cd on ab.NIMHS = cd.NIMHSMSMHS where ab.THSMS <= '.$th_smt_max.' and ab.THSMS >= '.$th_smt_min.'  GROUP by THSMS) as b','a.thsmt = b.THSMS','left');
        $this->db2->where('a.thsmt <=',$th_smt_max);
        $this->db2->where('a.thsmt >=',$th_smt_min);
        $this->db2->order_by('a.thsmt','asc');//jangan hilangkan atau rubah order by karena data yang dimasukan pada chart berdasarkan urutan order by
        $query = $this->db2->get();
        return $query->result_array();
    }

    public function cek_mhs_aktif_per_fak($th_smt_max_per_fak,$th_smt_min_per_fak){
        $this->db2 = $this->load->database('siakad', TRUE);
        $this->db2->select('d.KDFAKMSFAK,count(a.NIMHS) as jumlah,a.THSMS');
        $this->db2->from('trregistrasi as a');
        $this->db2->join('msmhs as b ','a.NIMHS = b.NIMHSMSMHS ','inner');
        $this->db2->join('mspst as c ','b.KDPSTMSMHS = c.KDPSTMSPST ','inner');
        $this->db2->join('msfak as d ','c.KDFAKMSPST = d.KDFAKMSFAK ','inner');
        $this->db2->where('a.THSMS <=',$th_smt_max_per_fak);
        $this->db2->where('a.THSMS >=',$th_smt_min_per_fak);
        //$this->db2->where('d.NMFAKMSFAK is not null');
        $this->db2->group_by('a.THSMS,d.KDFAKMSFAK');
        $this->db2->order_by('d.NMFAKMSFAK,a.THSMS ','asc');//jangan hilangkan atau rubah order by karena data yang dimasukan pada chart berdasarkan urutan order by
        $query = $this->db2->get();
        return $query->result_array();
    }

    public function cek_mhs_aktif_per_prodi($th_smt_siakad){
        $this->db2 = $this->load->database('siakad', TRUE);
        $this->db2->select('d.KDFAKMSFAK,c.KDPSTMSPST,c.NMPSTMSPST,count(a.NIMHS) as jumlah,a.THSMS');
        $this->db2->from('trregistrasi as a');
        $this->db2->join('msmhs as b ','a.NIMHS = b.NIMHSMSMHS ','inner');
        $this->db2->join('mspst as c ','b.KDPSTMSMHS = c.KDPSTMSPST ','inner');
        $this->db2->join('msfak as d ','c.KDFAKMSPST = d.KDFAKMSFAK ','inner');
        $this->db2->where('a.THSMS =',$th_smt_siakad);
        $this->db2->where('c.KDPSTMSPST !=',114);
        $this->db2->group_by('c.KDPSTMSPST');
        $this->db2->order_by('d.NMFAKMSFAK asc ,jumlah desc');//jangan hilangkan atau rubah order by karena data yang dimasukan pada chart berdasarkan urutan order by
        $query = $this->db2->get();
        return $query->result_array();
    }

    public function get_kode_fakultas(){
        $this->db2 = $this->load->database('siakad', TRUE);
        $this->db2->select('KDFAKMSFAK	');
        $this->db2->from('msfak');
        $query = $this->db2->get();
        return $query->result_array();
    }

    public function get_rentang_smt($th_smt_max_per_fak,$th_smt_min_per_fak){
        $this->db2 = $this->load->database('siakad', TRUE);
        $this->db2->select('*');
        $this->db2->from('msthsmt_smart');
        $this->db2->where('thsmt <=',$th_smt_max_per_fak);
        $this->db2->where('thsmt >=',$th_smt_min_per_fak);
        $this->db2->order_by('thsmt','asc');//jangan hilangkan atau rubah order by karena data yang dimasukan pada chart berdasarkan urutan order by
        $query = $this->db2->get();
        return $query->result_array();
    }

    public function cek_jmlh_dosen_karyawan(){
        $this->db2 = $this->load->database('simpis', TRUE);
        $this->db2->select("CONCAT(b.nama_j_pendidik,' ',c.nama_j_pegawai) as jenis_pegawai,COUNT(a.id_pegawai) as jumlah");
        $this->db2->from('tbl_data_pegawai as a');
        $this->db2->join('tbl_master_jenis_pendidik as b ','a.j_pendidik = b.j_pendidik','inner');
        $this->db2->join('tbl_master_jenis_pegawai as c ','a.j_pegawai = c.j_pegawai','inner');
        $this->db2->group_by('b.j_pendidik,c.j_pegawai');
        $this->db2->order_by('b.j_pendidik','asc');//jangan hilangkan atau rubah order by karena data yang dimasukan pada chart berdasarkan urutan order by
        $query = $this->db2->get();
        return $query->result_array();
    }

    public function get_data_pribadi_dosen($session_user_id = null)
    {
        $this->db2 = $this->load->database('siakad', TRUE);
        $this->db2->select('*');
        $this->db2->from('sispt_userdosen as a');
        $this->db2->join('msdos as b', 'a.nodos = b.NODOSMSDOS', 'left');
        $this->db2->where('a.user_id', $session_user_id);
        $query = $this->db2->get();
        return $query->row();
    }
    public function get_data_pribadi_karyawan($session_user_id = null)
    {
        $this->db2 = $this->load->database('siakad', TRUE);
        $this->db2->select('a.*,m.*');
        $this->db2->from('sispt_users as a');
        $this->db2->join('sispt_modul as m', 'a.user_modul_id = m.id', 'left');
        $this->db2->where('a.user_id', $session_user_id);
        $query = $this->db2->get();
        return $query->row();
    }

    public function gd_dosen($session_user_id = null, $kode)
    {
        $set_kode = $kode;
        $this->db2 = $this->load->database('siakad', TRUE);
        $this->db2->select('*');
        $this->db2->from('sispt_userdosen as a');
        $this->db2->join('msdos as b', 'a.nodos = b.NODOSMSDOS', 'left');
        if ($set_kode == 15) {
            $this->db2->join('tbkod as k', 'b.STDOSMSDOS = k.KDKODTBKOD', 'left');
        } elseif ($set_kode == 01) {
            $this->db2->join('tbkod as k', 'b.KDPDAMSDOS = k.KDKODTBKOD', 'left');
        } elseif ($set_kode == 02) {
            $this->db2->join('tbkod as k', 'b.KDJANMSDOS = k.KDKODTBKOD', 'left');
        } elseif ($set_kode == 03) {
            $this->db2->join('tbkod as k', 'b.KDSTAMSDOS = k.KDKODTBKOD', 'left');
        } elseif ($set_kode == 8) {
            $this->db2->join('tbkod as k', 'b.KDJEKMSDOS = k.KDKODTBKOD', 'left');
        }
        $this->db2->where('a.user_id', $session_user_id);
        $this->db2->where('k.KDAPLTBKOD', $set_kode);
        $query = $this->db2->get();
        return $query->row_array();
    }

   
}
