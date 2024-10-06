<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dpenjualan extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    cek_login();
    $this->load->model('Penjualan_m');
  }
  public function index($bln = "", $thn = "")
  {
    if ($bln == "") {
      $bln = date('n');
    }
    if ($thn == "") {
      $thn = date('Y');
    }
    $data = array(
      'title'    => 'Daftar Penjualan',
      'user'     => infoLogin(),
      'toko'     => $this->db->get('profil_perusahaan')->row(),
      'penjualan' => $this->Penjualan_m->Daftar_penjualan($bln, $thn)->result(),
      'content'  => 'daftarpenjualan/jual',
      'bln'      => $bln,
      'thn'     => $thn,
    );
    $this->load->view('templates/main', $data);
  }

  public function retur($id)
  {
    $data = array(
      'title'    => 'Retur Penjualan',
      'user'     => infoLogin(),
      'toko'     => $this->db->get('profil_perusahaan')->row(),
      'penjualan' => $this->Penjualan_m->Retur_jual($id)->result(),
      'id_jual'  => $id,
      'content'  => 'daftarpenjualan/retur2',
      'nama_barang' => $this->Penjualan_m->Detail_namabarang($id)->result()
    );
    // die(var_dump($data['nama_barang']));
    $this->load->view('templates/main', $data);
  }

  public function Simpan_retur()
  {

    //simpan data
    $entri['id_jual']   = $this->input->post('id_jual');
    $entri['id_cs']     = $this->input->post('id_cs');
    $entri['invoice']   = $this->input->post('invoice');
    $entri['id_barang'] = $this->input->post('barang');
    $entri['ket'] = $this->input->post('ket');
    //$barang=$this->Penjualan_m->Detail_barang($this->input->post('barang'))->row();
    $barang = $this->Penjualan_m->Detail_penjualan($entri['id_jual'], $entri['id_barang'])->row();
    if ($this->input->post('qretur') > $barang->qty_jual) {
      $entri['qty_retur'] = $barang->qty_jual;
    } else {
      $entri['qty_retur'] = $this->input->post('qretur');
    }
    $entri['harga_item'] = $barang->harga_item;
    $entri['hpp'] = $barang->hpp;
    $entri['subtotal'] = $entri['qty_retur'] * $entri['harga_item'];

    //insert ke table retur
    $hasil = 0;
    $hasil = $this->Penjualan_m->Insert_retur($entri);
    if ($hasil > 0) {
      //update item penjulan dikurangi qty nya sesuai return
      $item['qty_jual'] = $barang->qty_jual - $entri['qty_retur'];
      $item['subtotal'] = $item['qty_jual'] * $barang->harga_item;
      $upd['id_jual'] = $entri['id_jual'];
      $upd['id_barang'] = $entri['id_barang'];
      $this->db->update('detil_penjualan', $item, $upd);
    }
    redirect(site_url() . 'Dpenjualan/retur/' . $entri['id_jual']);
  }

  public function Hapus_retur($id, $jual)
  {
    $dt = $this->db->get_where('tbl_retur', array('id_retur' => $id, 'id_jual' => $jual))->row();
    $item = $this->db->get_where('detil_penjualan', array('id_barang' => $dt->id_barang, 'id_jual' => $jual))->row();
    //kembalikan dulu retur ke detail penjualan
    $detil['qty_jual'] = $item->qty_jual + $dt->qty_retur;
    $detil['subtotal'] = $detil['qty_jual'] * $item->harga_item;
    $this->db->update('detil_penjualan', $detil, array('id_barang' => $dt->id_barang, 'id_jual' => $jual));
    //hapus data
    $hasil = $this->Penjualan_m->Delete_retur($id);
    redirect(site_url() . 'Dpenjualan/retur/' . $jual);
  }

  public function Kembalikan_barang($id)
  {

    //cek data dari tbl_retur
    $item = $this->Penjualan_m->View_retur($id)->result();

    $method = "Cash";
    $gretur = 0;
    foreach ($item as $rs) {
      $kj = explode('-', $rs->kode_jual);
      //update status table retur
      $entri['status'] = 1;
      $entri['kode_retur'] = "RT-" . $kj[1] . '-' . $rs->id_retur;
      $this->Penjualan_m->Update_retur($rs->id_retur, $entri);
      $method = $rs->method;
      $gretur = $gretur + $rs->subtotal;
      //update kembalikan stok barang di table barang
      $this->db->query('update barang set stok = stok + ' . $rs->qty_retur . ' where id_barang=' . $rs->id_barang);

      //update data detil penjualan, kurangi qty sesuai jumlah retur
      //$this->db->query('update detil_penjualan set qty_jual = qty_jual -' . $rs->qty_retur . ',subtotal = qty_jual * harga_item where id_jual=' . $rs->id_jual . ' and id_barang = ' . $rs->id_barang);

      //echo 'update detil_penjualan set qty_jual = qty_jual -' . $rs->qty_retur . ',subtotal = (qty_jual -' . $rs->qty_retur . ')*harga_item where id_jual=' . $rs->id_jual . ' and id_barang = ' . $rs->id_barang;
      //tulis jurnal pembalik transaksi penjualan

      //Jurnal balik PErsediaan TOKO
      // $Jual_toko['vcIDJournal']   = $entri['kode_retur'];
      // $Jual_toko['dtJournal']     = date("Y-m-d H:i:s");
      // $Jual_toko['vcCOAJournal']  = $rs->coa_persediaan;
      // $Jual_toko['cuJournalDebet'] = $rs->qty_retur * $rs->hpp;
      // $Jual_toko['cuJournalCredit'] = 0;
      // $Jual_toko['vcJournalDesc'] = 'Retur Penjualan ' . $rs->kode_jual;
      // $Jual_toko['itPostJournal']  = '1';
      // $Jual_toko['vcUserID']  = 'admin';
      // $this->Penjualan_m->Insert_jurnal_retur($Jual_toko);

      //jurnal balik hpp
      // $Jual_toko['vcIDJournal']   = $entri['kode_retur'];
      // $Jual_toko['dtJournal']     = date("Y-m-d H:i:s");
      // $Jual_toko['vcCOAJournal']  = $rs->coa_hpp;
      // $Jual_toko['cuJournalCredit'] = $rs->qty_retur * $rs->hpp;
      // $Jual_toko['cuJournalDebet'] = 0;
      // $Jual_toko['vcJournalDesc'] = 'Retur Penjualan ' . $rs->kode_jual;
      // $Jual_toko['itPostJournal']  = '1';
      // $Jual_toko['vcUserID']  = 'admin';
      // $this->Penjualan_m->Insert_jurnal_retur($Jual_toko);

      //Jurnal balik PENJUALAN TOKO
      // $Jual_toko['vcIDJournal']   = $entri['kode_retur'];
      // $Jual_toko['dtJournal']     = date("Y-m-d H:i:s");
      // $Jual_toko['vcCOAJournal']  = $rs->coa_penjualan;
      // $Jual_toko['cuJournalDebet'] = $rs->subtotal;
      // $Jual_toko['cuJournalCredit'] = 0;
      // $Jual_toko['vcJournalDesc'] = 'Retur Penjualan ' . $rs->kode_jual;
      // $Jual_toko['itPostJournal']  = '1';
      // $Jual_toko['vcUserID']  = 'admin';
      // $this->Penjualan_m->Insert_jurnal_retur($Jual_toko);
    }
    //print_r($item);

    //jurnal balik kas
    // $Jual_toko['vcIDJournal']   = $entri['kode_retur'];
    // $Jual_toko['dtJournal']     = date("Y-m-d H:i:s");
    // if ($method == "Cash") {
    //   $Jual_toko['vcCOAJournal']  = '11110-000';
    // } else {
    //   $Jual_toko['vcCOAJournal']  = '11210-000';
    // }
    // $Jual_toko['cuJournalCredit'] = $gretur;
    // $Jual_toko['cuJournalDebet'] = 0;
    // $Jual_toko['vcJournalDesc'] = 'Retur Penjualan ' . $rs->kode_jual;
    // $Jual_toko['itPostJournal']  = '1';
    // $Jual_toko['vcUserID']  = 'admin';
    // $this->Penjualan_m->Insert_jurnal_retur($Jual_toko);

    //Update Piutang
    $piutang = $this->Penjualan_m->Piutang_jual($id)->result();

    //$penjualan = $this->Penjualan_m->total_itemjual($id)->row(); 
    $penjualan = $this->db->query("select * from detil_penjualan where id_jual=".$id)->row();
    //print_r($penjualan);
    // echo "test.";
    // die;
    if (count($piutang) > 0) {
      $bayar = $piutang[0]->bayar;
      $piutang_baru = $penjualan->jml;
      $sisa = $piutang_baru - $bayar;

      
      $data_piutang['sisa'] = $sisa;
      $data_piutang['jml_piutang'] = $piutang_baru;
      if ($sisa <= 0) {
        $data_piutang['status'] = 'Lunas';
      }
      $update_hutang = $this->Penjualan_m->Update_piutang_jual($id, $data_piutang);
    }


    if ($method != "Kredit") {
      //update table kas 
      $jmlkas =  $this->db->query('select sum(subtotal) as jml, penjualan.kode_jual from detil_penjualan inner join penjualan on penjualan.id_jual = detil_penjualan.id_jual where penjualan.id_jual=' . $id)->row();
      if (isset($jmlkas)) {
        $this->Penjualan_m->ReplaceKas($jmlkas->kode_jual, $jmlkas->jml);
      }
    }
    redirect(site_url() . 'Dpenjualan');
  }
}
