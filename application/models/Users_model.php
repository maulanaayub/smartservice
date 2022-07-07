<?php

/**
 * @package     Country_model.php
 * @author      Aditya Nursyahbani
 * @link        http://www.aditya-nursyahbani.net/2016/10/tutorial-oauth2-dengan-codeigniter.html
 * @copyright   Copyright(c) 2016
 * @version     1.0.0
 **/

defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model
{

    function get_user_data_mhs($username)
    {
        $this->db = $this->load->database('siakad', TRUE);
        $this->db->select('*');
        $this->db->from('msmhs');
        $this->db->where('NIMHSMSMHS', $username);
        // $this->db->where('login_pass', $password);

        $query =  $this->db->get()->row();
        return $query;
        //return $this->db->get_where('oauth_users', array('username' => $username,'password'=>$password))->row_array();
    }

    function get_user_data_sispt($username)
    {
        $this->db = $this->load->database('siakad', TRUE);
        $this->db->select('*');
        $this->db->from('sispt_users');
        $this->db->where('user_id', $username);
        //$this->db->where('user_pass', $password);

        $query =  $this->db->get()->row();
        return $query;
        //return $this->db->get_where('oauth_users', array('username' => $username,'password'=>$password))->row_array();
    }

    function check_user_mhs($username, $password)
    {
        $this->db = $this->load->database('siakad', TRUE);
        $this->db->select('*');
        $this->db->from('msmhs');
        $this->db->where('NIMHSMSMHS', $username);
        $this->db->where("login_pass = password(" . $this->db->escape($password) . ")");
        $query = $this->db->get();
        return $query->row();

        // $sql = "SELECT * FROM msmhs WHERE NIMHSMSMHS = ? AND login_pass = password(?)";
        // $query = $this->db->query($sql, array($username, $password));
        // return $query->row();
    }

    function check_user_sispt($username, $password)
    {
        $this->db = $this->load->database('siakad', TRUE);
        $this->db->select('*');
        $this->db->from('sispt_users');
        $this->db->where('user_id', $username);
        $this->db->where('user_pass = password("' . $password . '")');
        $query = $this->db->get();
        return $query->row();
    }

    function get_role_data_mhs()
    {
        $this->db = $this->load->database('default', TRUE);
        $this->db->select('client_id as access_client_id');
        $this->db->from('oauth_clients');
        $this->db->where('mhs_app', 'Y');

        $query =  $this->db->get()->result_array();
        return $query;
    }
    function get_role_data_sispt($username)
    {
        $this->db = $this->load->database('default', TRUE);
        $this->db->select('access_client_id');
        $this->db->from('oauth_access');
        $this->db->where('access_user_id', $username);

        $query =  $this->db->get()->result_array();
        return $query;
    }

    function get_all()
    {
        $this->db = $this->load->database('default', TRUE);
        return $this->db->get('oauth_users')->result_array();
    }

    function get_user_mhs($username)
    {
        $this->db = $this->load->database('siakad', TRUE);
        $this->db->select('*');
        $this->db->from('msmhs');
        $this->db->where('NIMHSMSMHS', $username);
        $query = $this->db->get();
        return $query->row();
    }
    function get_user_sispt($username)
    {
        $this->db = $this->load->database('siakad', TRUE);
        $this->db->select('*');
        $this->db->from('sispt_users');
        $this->db->where('user_id', $username);
        $query = $this->db->get();
        return $query->row();
    }

    function get_data_mahasiswa($username, $smt_brjln)
    {
        $this->db = $this->load->database('siakad', TRUE);
        $this->db->select('a.*,c.NMPSTMSPST,d.NMFAKMSFAK,e.TGL as TGL_AKTIVASI,f.NMKODTBKOD as jenjang,g.NMKODTBKOD as status');
        $this->db->from('msmhs as a');
        $this->db->join('mspst as c ', 'a.KDPSTMSMHS = c.KDPSTMSPST ', 'left');
        $this->db->join('msfak as d ', 'c.KDFAKMSPST = d.KDFAKMSFAK ', 'left');
        $this->db->join('trregistrasi  as e', 'a.NIMHSMSMHS=e.NIMHS and e.THSMS=' . $smt_brjln, 'left');
        $this->db->join('(select * from tbkod where KDAPLTBKOD = 01) as f', 'a.KDJENMSMHS=f.KDKODTBKOD', 'left');
        $this->db->join('(select * from tbkod where KDAPLTBKOD = 05) as g', 'a.STMHSMSMHS=g.KDKODTBKOD', 'left');
        $this->db->where('a.NIMHSMSMHS', $username);
        $query = $this->db->get();
        return $query->row();
    }

    public function semester_berjalan()
    {
        $this->db = $this->load->database('siakad', TRUE);
        $this->db->select('conf_keyval as semester_aktif');
        $this->db->from('konfigurasi');
        $this->db->where('conf_key', 'thsms');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_country_mhs($isdropdown = null)
    {
        $this->db = $this->load->database('siakad', TRUE);
        $this->db->select('*');
        $this->db->from('feeder_data_negara');
        $this->db->order_by('a_ln,nm_negara', 'asc');
        $query = $this->db->get();
        if ($isdropdown == true) {
            $value_dropdown[''] = '-- Silahkan Pilih --';
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    // tentukan value (sebelah kiri) dan labelnya (sebelah kanan)
                    $value_dropdown[$row->id_negara] = $row->nm_negara;
                }
            }
            return $value_dropdown;
        } else {
            return $query;
        }
    }

    public function get_propinsi_mhs($negara)
    {
        $this->db2 = $this->load->database('siakad', TRUE);
        $this->db2->select('*');
        $this->db2->from('feeder_data_wilayah');
        $this->db2->where('id_level_wil', 1);
        $this->db2->where('id_negara', $negara);
        $this->db2->order_by('id_wil', 'asc');
        $query = $this->db2->get();
        return $query->result_array();
    }

    public function get_kab_mhs($propinsi, $negara)
    {
        $this->db2 = $this->load->database('siakad', TRUE);
        $this->db2->select('*');
        $this->db2->from('feeder_data_wilayah');
        $this->db2->where('id_level_wil', 2);
        $this->db2->where('id_negara', $negara);
        $this->db2->where('id_induk_wilayah', $propinsi);
        $this->db2->order_by('id_wil', 'asc');
        $query = $this->db2->get();
        return $query->result_array();
    }

    public function get_kec_mhs($kabupaten, $negara)
    {
        $this->db2 = $this->load->database('siakad', TRUE);
        $this->db2->select('*');
        $this->db2->from('feeder_data_wilayah');
        $this->db2->where('id_level_wil', 3);
        $this->db2->where('id_negara', $negara);
        $this->db2->where('id_induk_wilayah', $kabupaten);
        $this->db2->order_by('id_wil', 'asc');
        $query = $this->db2->get();
        return $query->result_array();
    }

    public function get_ph_pk_pd_ortu_mhs()
    {
        $this->db2 = $this->load->database('siakad', TRUE);
        $this->db2->select('*');
        $this->db2->from('tbkod');
        $this->db2->where('KDAPLTBKOD IN (301,302,303)');
        $this->db2->order_by('KDAPLTBKOD', 'asc');
        $query = $this->db2->get();
        return $query->result_array();
    }

    public function update_data_mahasiswa($nim, $param)
    {
        $this->db2 = $this->load->database('siakad', TRUE);
        //where harus diatas karena kalau dibawah perintah update tidak dieksekusi
        $this->db2->where('NIMHSMSMHS', $nim);
        $this->db2->update('msmhs', $param);
       

        if ($this->db2->affected_rows() >= 0) {
            return true; // your code
        } else {
            return false; // your code
        }
    }

    public function update_password_mahasiswa($nim, $password)
    {
        $this->db2 = $this->load->database('siakad', TRUE);
        // $this->db2->set("login_pass = PASSWORD('".$password."')");
        // $this->db2->where('NIMHSMSMHS',$nim);
        // $this->db2->update('msmhs');

        $this->db2->query('update msmhs set login_pass=PASSWORD("' . $password . '") where NIMHSMSMHS=' . $nim);


        if ($this->db2->affected_rows() >= 0) {
            return true; // your code
        } else {
            return false; // your code
        }
    }

    public function update_password_sispt($user, $password)
    {
        $this->db2 = $this->load->database('siakad', TRUE);
        // $this->db2->set("login_pass = PASSWORD('".$password."')");
        // $this->db2->where('NIMHSMSMHS',$nim);
        // $this->db2->update('msmhs');

        $this->db2->query('update sispt_users set user_pass=PASSWORD("' . $password . '") where user_id="' . $user . '"');


        if ($this->db2->affected_rows() >= 0) {
            return true; // your code
        } else {
            return false; // your code
        }
    }
}
