<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
   public function __construct()
   {

      parent::__construct();
      cek_login();
      cek_user();
      $this->load->model('Penjualan_m');
      $this->load->model('Pembelian_m');
   }

   public function index()
	{
      echo 'test';
	}

   public function Laporan_kategori()
  {
    $data = array(
      'title'    => 'Laporan Penjualan Per Kategori',
      'user'     => infoLogin(),
      'kategori' => $this->db->get('kategori')->result_array(),
      'toko'     => $this->db->get_where('profil_perusahaan', array('id_toko' => $this->session->cabang))->row(),
      'content'  => 'penjualan/laporan_kategori'
    );
    $this->load->view('templates/main', $data);
  }


   public function barang()
   {
      $sql = "select * from supplier";
      $data = array(
         'title'    => 'Laporan Data Barang',
         'user'     => infoLogin(),
         'supplier' => $this->model->General($sql)->result_array(),
         'toko'     => $this->db->get('profil_perusahaan')->row(),
         'content'  => 'barang/item/laporan'
      );
      $this->load->view('templates/main', $data);
   }
   public function pembelian()
   {
      $data = array(
         'title'    => 'Laporan Pembelian',
         'user'     => infoLogin(),
         'toko'     => $this->db->get('profil_perusahaan')->row(),
         'supplier' => $this->Pembelian_m->Daftar_supplier()->result(),
         'content'  => 'pembelian/laporan'
      );
      $this->load->view('templates/main', $data);
   }
   public function penjualan()
   {
      $data = array(
         'title'    => 'Laporan Penjualan',
         'user'     => infoLogin(),
         'toko'     => $this->db->get('profil_perusahaan')->row(),
         'content'  => 'penjualan/laporan'
      );
      $this->load->view('templates/main', $data);
   }
   public function stokopname()
   {
      $data = array(
         'title'    => 'Laporan Stok Opname',
         'user'     => infoLogin(),
         'toko'     => $this->db->get('profil_perusahaan')->row(),
         'content'  => 'stokopname/laporan'
      );
      $this->load->view('templates/main', $data);
   }

   public function laba_rugi()
   {
      $data = array(
         'title'    => 'Laporan Laba Rugi',
         'user'     => infoLogin(),
         'toko'     => $this->db->get('profil_perusahaan')->row(),
         'content'  => 'penjualan/laba_rugi'
      );
      $this->load->view('templates/main', $data);
   }
   public function kas()
   {
      $data = array(
         'title'    => 'Laporan Kas',
         'user'     => infoLogin(),
         'toko'     => $this->db->get('profil_perusahaan')->row(),
         'content'  => 'kas/laporan'
      );
      $this->load->view('templates/main', $data);
   }
   public function kas_bank()
   {
      $data = array(
         'title'    => 'Laporan Kas Bank',
         'user'     => infoLogin(),
         'toko'     => $this->db->get('profil_perusahaan')->row(),
         'content'  => 'bank/laporan'
      );
      $this->load->view('templates/main', $data);
   }
   public function stok()
   {
      $data = array(
         'title'    => 'Laporan Stok In/Out',
         'user'     => infoLogin(),
         'toko'     => $this->db->get('profil_perusahaan')->row(),
         'content'  => 'stok/laporan'
      );
      $this->load->view('templates/main', $data);
   }

   public function hutang()
   {
      $data = array(
         'title'    => 'Laporan Hutang',
         'user'     => infoLogin(),
         'toko'     => $this->db->get('profil_perusahaan')->row(),
         'content'  => 'hutang/laporan',
         'supplier' => $this->db->get('supplier')->result_array()
      );
      $this->load->view('templates/main', $data);
   }
   public function piutang()
   {
      $data = array(
         'title'    => 'Laporan Piutang',
         'user'     => infoLogin(),
         'toko'     => $this->db->get('profil_perusahaan')->row(),
         'content'  => 'piutang/laporan',
         'customer' => $this->db->get('tbl_anggota')->result_array()
      );
      $this->load->view('templates/main', $data);
   }

   public function Rekap_penjualan()
   {
      $data = array(
         'title'    => 'Rekap Penjualan',
         'user'     => infoLogin(),
         'toko'     => $this->db->get('profil_perusahaan')->row(),
         'content'  => 'penjualan/laporan_rekap_penjualan'
      );
      $this->load->view('templates/main', $data);
   }
}
