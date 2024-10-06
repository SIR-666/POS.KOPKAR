<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_m extends CI_Model
{

   protected $table = 'user';
   protected $primary = 'id_user';

   public function getAllData()
   {
      return $this->db->get_where($this->table, ['is_active' => 1])->result_array();
   }

   public function Save()
   {
      $data = array(
         'username'      => htmlspecialchars($this->input->post('username'), true),
         'nama_lengkap'  => htmlspecialchars($this->input->post('nama'), true),
         'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
         'tipe'          => htmlspecialchars($this->input->post('tipe'), true),
         'alamat_user'   => htmlspecialchars($this->input->post('alamat'), true),
         'telp_user'     => htmlspecialchars($this->input->post('telp'), true),
         'email_user'    => htmlspecialchars($this->input->post('email'), true),
         'is_active'       => 1,
         'cabang'        => htmlspecialchars($this->input->post('cabanguser'), true)

      );
      return $this->db->insert($this->table, $data);
   }

   public function Edit()
   {
      $id = $this->input->post('iduser');
      $data = array(
         'username'      => htmlspecialchars($this->input->post('editusername'), true),
         'nama_lengkap'  => htmlspecialchars($this->input->post('editnama'), true),
         'tipe'          => htmlspecialchars($this->input->post('edittipe'), true),
         'alamat_user'   => htmlspecialchars($this->input->post('editalamat'), true),
         'telp_user'     => htmlspecialchars($this->input->post('edittelp'), true),
         'email_user'    => htmlspecialchars($this->input->post('editemail'), true),
         'cabang'        => htmlspecialchars($this->input->post('cabanguser'), true)

      );
      return $this->db->set($data)->where($this->primary, $id)->update($this->table);
   }

   public function Delete($id)
   {
      return $this->db->set(array('is_active' => 0))->where($this->primary, $id)->update($this->table);
   }

   public function Detail($id)
   {
      return $this->db->get_where($this->table, [$this->primary => $id])->row_array();
   }


   public function getUserLogs()
   {
      $sql = "SELECT a.username, a.nama_lengkap, a.tipe, b.login, b.logout FROM user a, user_log b WHERE a.id_user = b.id_user ORDER BY b.logout ASC";
      return $this->db->query($sql)->result_array();
   }

   public function Select_user_byid($id_r)
   {
      $this->db->select("*");
      $this->db->from('user');
      $this->db->where('id_user', $id_r);
      $this->db->order_by('id_user', 'ASC');
      return $this->db->get();
   }

   public function Select_user_bycabang($c)
   {
      $this->db->select("*");
      $this->db->from('user');
      $this->db->where('cabang', $c);
      $this->db->order_by('id_user', 'ASC');
      return $this->db->get();
   }

   public function Update_user($data, $id)
   {
      $this->db->where('id_user', $id);
      $this->db->update('user', $data);
   }

   public function getAllDataCabang($idr)
   {
      return $this->db->get_where($this->table, ['cabang' => $idr])->result_array();
   }
}
