<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cabang_m extends CI_Model
{
    protected $table = 'profil_perusahaan';
    protected $primary = 'id_toko';

    public function getAllData()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function Select_cabang_byid($id_r)
    {
        $this->db->select("*");
        $this->db->from('profil_perusahaan');
        $this->db->where('id_toko', $id_r);
        $this->db->order_by('id_toko', 'DESC');
        return $this->db->get();
    }
    public function Insert_cabang($data)
    {
        $this->db->insert('profil_perusahaan', $data);
    }
    public function Update_cabang($data, $id)
    {
        $this->db->where('id_toko', $id);
        $this->db->update('profil_perusahaan', $data);
    }
    public function Delete_cabang($id_r)
    {
        $this->db->where('id_toko', $id_r);
        $this->db->Delete('profil_perusahaan');
    }
}
