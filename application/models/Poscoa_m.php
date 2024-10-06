<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Poscoa_m extends CI_Model
{

    protected $table = 'customer';
    protected $primary = 'id_cs';

    public function getAllData()
    {
        $this->db->select("*");
        $this->db->from('tbl_anggota');
        $this->db->where('aktif', "Y");
        $this->db->order_by('id', 'ASC');
        return $this->db->get()->result_array();
    }

    function GetCoa() {
        $this->db->select("CoaId,vcCOACode,vcCOAName,vcGroupName,vcCOABalanceType,itCOAType,itCOALevel");
        $this->db->from('tbl_coa');
        $this->db->join('tbl_groupcoa','tbl_coa.vcGroupCode = tbl_groupcoa.vcGroupCode');
        $this->db->where('itActive', "0");
        return $this->db->get();
    }

    public function Save($data)
    {
        $this->db->where('id_toko',$this->session->id);
        $this->db->update('profil_perusahaan',$data);
    }

    //model baru
    function Coa() {
        $this->db->select("*");
        $this->db->from('tbl_coa');
        return $this->db->get();
    }
}
