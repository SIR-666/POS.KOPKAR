<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    cek_login();
    //cek_user();
    $this->load->model('Penjualan_m');
    $this->load->model('Barang_m');
  }
  public function index()
  {
    $data = array(
      'title'    => 'Penjualan',
      'user'     => infoLogin(),
      'customer' => $this->db->get_where('tbl_anggota',array('aktif' => 'Y'))->result_array(),
      'toko'     => $this->db->get_where('profil_perusahaan', array('id_toko' => $this->session->cabang))->row(),
      'content'  => 'penjualan/index',
      'pegawai'  => $this->db->get('karyawan')->result_array()
    );
    $this->load->view('templates/main', $data);
  }

  public function LoadData()
  {
    $json = array(
      "aaData"  => $this->Penjualan_m->getDetilJual()
    );
    echo json_encode($json);
  }

  public function LoadDataService()
  {
    $json = array(
      "aaData"  => $this->Penjualan_m->getDetilService()
    );
    echo json_encode($json);
  }

  public function tambahbarang($id, $qty, $subtotal, $harga, $jenis, $pegawai, $operator, $hpp)
  {
    // $id = id_barang
    // $qty = jml item yg dibeli
    // $harga = hrg barang
    // $jenis = jenis produk, value nya kalo gk  'Produk' ya 'Servis'
    // $pegawai = id pegawai yg melakukan service khusus jenis produk service
    // $operator = operator aplikasi yg sedang login
    // $hpp = harga hpp barang
    //-----------------
    // #1 cek apakah sudah ada item brg yg sama

    $dt = $this->Penjualan_m->GetItemPenjualan($id, $operator)->row();
    if (isset($dt)) {
      //jika sudah ada maka cukup edit item yg ada dg menambah qty nya

      $qty = $qty + $dt->qty_jual;
      //echo $dt->id_detil_jual;
      $subtotal = $harga * $qty;
      $upd['qty_jual'] = $qty;
      $upd['subtotal'] = $subtotal;
      $upd['hpp'] = $hpp;
      $this->Penjualan_m->UpdateDetail($upd, $dt->id_detil_jual);
      $sql = "SELECT sum(subtotal) as subtotal FROM detil_penjualan WHERE id_jual IS NULL and id_user=" . $operator;
      $data = $this->db->query($sql)->row_array();
      echo json_encode($data);
    } else {
      //echo 'test2';
      //jika belum ada baru diinsert satu row data komplit
      $this->Penjualan_m->addItem($id, $qty, $subtotal, $harga, $jenis, $pegawai, $operator, $hpp);
    }
  }

  public function tambahbarangbyscan($id, $qty, $subtotal, $harga, $jenis, $pegawai, $operator, $customer)
  {
    // $id = id_barang
    // $qty = jml item yg dibeli
    // $harga = hrg barang
    // $jenis = jenis produk, value nya kalo gk  'Produk' ya 'Servis'
    // $pegawai = id pegawai yg melakukan service khusus jenis produk service
    // $operator = operator aplikasi yg sedang login
    // $hpp = harga hpp barang
    //$customer = id customer yg beli
    //-----------------
    // #1 cari harga dan hpp
		$data = $this->Barang_m->Detail($id);
		$vhpp = 0;
        //----------------------------- get hpp-------------------
        $sql = "SELECT SUM(subtotal)/ SUM(qty_beli) as hpp FROM detil_pembelian WHERE id_barang=" . $id;
            $hpp = $this->db->query($sql)->row();
            if (isset($hpp->hpp)) {
                if ($hpp->hpp != '') {
                    $vhpp = $hpp->hpp;
                } else {
                    $hpp = $this->db->query('select harga_beli from barang where id_barang=' . $id)->row();
                    $vhpp = $hpp->harga_beli;
                }
            } else {
                $hpp = $this->db->query('select harga_beli from barang where id_barang=' . $id)->row();
                $vhpp = $hpp->harga_beli;
            }
			
    // #2 cari jenis customer untuk menentukan harga
      $harga = $data['harga_jual'];
      $cust = $this->db->get_where('tbl_anggota',array('id'=>$customer))->row();
      if (isset($cust)) {
        if ($cust->jenis_cs == "Pelanggan" || $cust->jenis_cs == "Anggota") {
          if ($data['harga_pelanggan'] != '0') {
            $harga = $data['harga_pelanggan'];
          } else {
            $harga = $data['harga_jual'];
          }
        } else {
          $harga = $data['harga_jual'];
        }
      } else {
        $harga = $data['harga_jual'];
      }

    // #1 cek apakah sudah ada item brg yg sama
    $dt = $this->Penjualan_m->GetItemPenjualan($id, $operator)->row();
    if (isset($dt)) {
      //jika sudah ada maka cukup edit item yg ada dg menambah qty nya

      $qty = $qty + $dt->qty_jual;
      //echo $dt->id_detil_jual;
      
      $subtotal = $harga * $qty;
      $upd['qty_jual'] = $qty;
      $upd['subtotal'] = $subtotal;
      $upd['harga_item'] = $harga;
      $upd['hpp'] = $vhpp;
      $this->Penjualan_m->UpdateDetail($upd, $dt->id_detil_jual);
      $sql = "SELECT sum(subtotal) as subtotal FROM detil_penjualan WHERE id_jual IS NULL and id_user=" . $operator;
      $data = $this->db->query($sql)->row_array();
      echo json_encode($data);
    } else {
      //echo 'test2';
      //jika belum ada baru diinsert satu row data komplit
      $subtotal = $harga * $qty;
      $this->Penjualan_m->addItem($id, $qty, $subtotal, $harga, $jenis, $pegawai, $operator, $vhpp);
      //$dt['subtotal'] = $harga;
      //echo json_encode($dt);
    }
  }

  public function detilitemjual($id = '')
  {
    $this->Penjualan_m->detilItemJual($id);
  }

  public function detilservisjual($id = '')
  {
    $this->Penjualan_m->detilServisJual($id);
  }

  public function editdetiljual($id, $diskon, $qty, $hakhir, $hpp=0)
  {
    $this->Penjualan_m->editDetailPenjualan($id, $diskon, $qty, $hakhir, $hpp);
  }

  public function editservisjual($id, $harga, $subtotal)
  {
    $this->Penjualan_m->editServisJual($id, $harga, $subtotal);
  }

  public function hapusdetil($id = '')
  {
    $this->Penjualan_m->hapusDetail($id);
  }

  public function simpanpenjualan()
  {
    
    $this->Penjualan_m->simpanPenjualan();
    // die('lewat');
    redirect('report/struk_penjualan');
  }

  public function kodeinvoice()
  {
    date_default_timezone_set('Asia/Jakarta');
    $kodeinvoice = "POS" . date('YmdHis');
    echo json_encode($kodeinvoice);
  }

  public function hargatotal()
  {
    $user_login = infoLogin();
    $sql = "SELECT SUM(subtotal) AS subtotal, SUM(diskon) as diskon FROM detil_penjualan WHERE id_jual IS NULL and id_user=" . $user_login['id_user'];
    $data = $this->model->General($sql)->row_array();
    echo json_encode($data);
  }

  public function cek_piutang($id) {
    $user_login = infoLogin();
    $data['total'] = 0;
    $data['belanja'] = 0;
    $sql = "SELECT SUM(subtotal) AS subtotal, SUM(diskon) as diskon FROM detil_penjualan WHERE id_jual IS NULL and id_user=" . $user_login['id_user'];
    $dt = $this->model->General($sql)->row();
    if (isset($dt)) {
     $data['belanja'] = $dt->subtotal - $dt->diskon;
    }
    $sql = "SELECT SUM(sisa) as piutang FROM piutang INNER JOIN penjualan ON piutang.id_jual = penjualan.id_jual WHERE id_cs = " . $id . " AND MONTH(tgl)=" . date('m') . " AND YEAR(tgl)=" . date('Y');
    $dtp = $this->model->General($sql)->row();
    if (isset($dtp)) {
      $data['total'] = $dtp->piutang;
    }
    echo json_encode($data);
  }

  public function detailJual($id = '')
  {
    $data = array(
      'title'    => 'Edit Penjualan',
      'user'     => infoLogin(),
      'customer' => $this->db->get('customer')->result_array(),
      'toko'     => $this->db->get('profil_perusahaan')->row(),
      'content'  => 'penjualan/edit'
    );
    $this->load->view('templates/main', $data);
  }

  // public function dataEdit($id = '')
  // {
  //   $sql = "SELECT b.id_jual, a.id_detil_jual, d.barcode, d.nama_barang, d.harga_jual, a.qty_jual, a.diskon, 
  //   a.subtotal, c.nama_cs FROM detil_penjualan a, penjualan b, customer c, barang d
  //   WHERE b.id_jual = a.id_jual AND c.id_cs = b.id_cs AND d.id_barang = a.id_barang AND b.is_active = 1 AND b.id_jual = '$id'";

  //   $data = $this->model->General($sql)->result_array();
  //   $json = array(
  //     "aaData"  => $data
  //   );
  //   echo json_encode($json);
  // }

  function fixinghpp() {
    $this->Penjualan_m->fixinghpp();
    echo "done";
  }
}
