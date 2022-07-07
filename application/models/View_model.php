<?php

defined('BASEPATH') or exit('No direct script access allowed');

class View_model extends CI_Model
{
    function list_app_smart()
    {
        $this->db = $this->load->database('default', TRUE);
        $this->db->select('a.AppName,a.redirect_uri,a.kategori,a.description_app');
        $this->db->from('oauth_clients as a');
        if ($this->session->userdata('user_is_login') == TRUE) {
            if ($this->session->userdata('tipe_akun') == 'sispt') {
                $this->db->join('oauth_access as b', 'a.client_id = b.access_client_id', 'inner');
                $this->db->where('b.access_user_id', $this->session->userdata('username'));
            } else {
                $this->db->where('a.mhs_app', 'Y');
            }
        }

        $query =  $this->db->get()->result_array();
        return $query;
    }

    function list_kateg_smart()
    {
        $this->db = $this->load->database('default', TRUE);
        $this->db->select('A.id_kategori,A.nama_kategori,B.kategori');
        $this->db->from('oauth_kategori AS A');
        if ($this->session->userdata('user_is_login') == TRUE) {
            if ($this->session->userdata('tipe_akun') == 'sispt') {
                $this->db->join('oauth_clients AS B', 'A.id_kategori = B.kategori', 'left');
                $this->db->join('oauth_access as C', 'B.client_id = C.access_client_id', 'left');
                $this->db->where('C.access_user_id', $this->session->userdata('username'));
                $this->db->group_by('A.id_kategori');
            } else {
                $this->db->join('oauth_clients AS B', 'A.id_kategori = B.kategori', 'left');
                $this->db->where('B.mhs_app="Y"');
                $this->db->group_by('A.id_kategori');
            }
        }else{
            $this->db->join('oauth_clients AS B', 'A.id_kategori = B.kategori', 'left');
            $this->db->where('B.kategori IS NOT NULL');
            $this->db->group_by('A.id_kategori');
        }
        $query =  $this->db->get()->result_array();
        return $query;
    }

    function get_pengumuman($limit, $start, $key, $action)
    {
        //$key = "buku";
        $this->db = $this->load->database('siakad', TRUE);
        $this->db->select('DATE_FORMAT(tanggal, "%d %b %Y") as tanggal_ind,judul,idpengumuman');
        $this->db->from('trpengumuman AS A');
        if ($key != "" || $key != null) {
            $this->db->like("judul", $key);
            $this->db->or_like("deskripsi", $key);
           // $this->db->or_where("judul", $key);
        }

        if ($action == 1) {
            $this->db->order_by('tanggal', 'desc');
            $this->db->limit($limit, $start);
            $query =  $this->db->get()->result();
        } else if ($action == 2) {
            $query =  $this->db->get()->num_rows();
        }
        return $query;
    }
}
