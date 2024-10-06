<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dpembelian extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    cek_login();
    $this->load->model('Pembelian_m');
  }
  public function index($bln="",$thn="")
  {
    if ($bln == "") {$bln = date('n');}
    if ($thn == "") {$thn = date('Y');}
    $data = array(
      'title'    => 'Daftar Pembelian',
      'user'     => infoLogin(),
      'toko'     => $this->db->get('profil_perusahaan')->row(),
      'pembelian'=> $this->Pembelian_m->Daftar_pembelian($bln,$thn)->result(),
      'content'  => 'daftarpembelian/beli',
      'bln'      => $bln,
      'thn'     => $thn,
    );
    $this->load->view('templates/main', $data);
  }

  public function retur($id)
  {
    $data = array(
      'title'    => 'Retur Pembelian',
      'user'     => infoLogin(),
      'toko'     => $this->db->get('profil_perusahaan')->row(),
      'pembelian'=> $this->Pembelian_m->Retur_beli($id)->result(),
      'id_beli'  => $id,
      'content'  => 'daftarpembelian/retur2'
    );
    $this->load->view('templates/main', $data);
  }

  public function LoadData()
  {
    $sql = "SELECT b.id_beli, b.kode_beli, b.faktur_beli, b.tgl_faktur, c.nama_supplier, SUM(a.qty_beli) AS qty_beli, b.total, b.diskon, b.method FROM detil_pembelian a, pembelian b, supplier c WHERE b.id_beli = a.id_beli AND c.id_supplier = b.id_supplier AND b.is_active = 1 GROUP BY a.id_beli";

    $json = array(
      "aaData"  => $this->model->General($sql)->result_array()
    );
    echo json_encode($json);
  }
  public function detilPembelian($id = '')
  {
    $sql = "SELECT a.kode_detil_beli, c.barcode, c.nama_barang, c.harga_beli, c.harga_jual, a.qty_beli, a.subtotal FROM detil_pembelian a, pembelian b, barang c WHERE b.id_beli = a.id_beli AND c.id_barang = a.id_barang AND a.id_beli = '$id'";

    $data = $this->model->General($sql)->result_array();
    echo json_encode($data);
  }
  public function Simpan_retur(){
        
    //simpan data
    $entri['id_beli']   = $this->input->post('id_beli');  
    $entri['id_supplier']     = $this->input->post('id_supplier');
    $entri['faktur_beli']   = $this->input->post('invoice');
    $entri['id_barang'] = $this->input->post('barang');
    $entri['ket'] = $this->input->post('ket');
    //$barang=$this->Pembelian_m->Detail_barang($this->input->post('barang'))->row();
    $barang=$this->Pembelian_m->Detail_v_pembelian($entri['id_beli'],$entri['id_barang'])->row();
    $jbarang=$this->Pembelian_m->Jumlah_pembelian($entri['id_beli'],$entri['id_barang'])->row();   
    if ($this->input->post('qretur') > $jbarang->qty_beli) {
      $entri['qty_retur'] = $barang->qty_beli;
    } else {
      $entri['qty_retur'] = $this->input->post('qretur');
    } 
    $entri['harga_item'] = $barang->hrg_beli;
    $entri['subtotal'] = $entri['qty_retur']*$entri['harga_item'];
    $entri['kode_retur']=
    //echo  $entri['qty_retur'].' '.$entri['harga_item']. ' '.$entri['subtotal'] ;
    //echo $entri['id_jual']. ' ' . $entri['id_cs']. ' ' .$entri['invoice']. ' ' .
    $hasil=$this->Pembelian_m->Insert_retur($entri);
    //update detail pembelian
    $ubeli=$this->Pembelian_m->Jumlah_pembelian($entri['id_beli'], $entri['id_barang'])->row();
    $up['qty_beli']=$ubeli->qty_beli-$entri['qty_retur'];
    $ubah=$this->Pembelian_m->Update_barang_pembelian($entri['id_beli'], $entri['id_barang'],$up);
    // Mengurangi stok dari table barang
    // Memanggil stored procedure untuk mengurangi stok
    $result = $this->db->query("CALL UpdateStockAfterReturn(?, ?)", array($entri['id_barang'], $entri['qty_retur']));
    // die($result);
    if (!$result) {
        // Handle error if the stored procedure fails
        $error = $this->db->error();
        die('Error updating stock: ' . $error['message']);
    }

    redirect(site_url().'Dpembelian/retur/'.$entri['id_beli']);
  }

  public function Hapus_retur($id,$jual){
        
    //update detail pembelian
    $uretur=$this->Pembelian_m->Detail_data_retur($id,$jual)->row();
    //jumlah retur
    $retur=$uretur->qty_retur;
    //kode barang
    $barang=$uretur->id_barang;
    $ubeli=$this->Pembelian_m->Jumlah_pembelian($jual, $barang)->row();
    //jumlah beli
    $beli=$ubeli->qty_beli;
    $tbeli=$beli+$retur;
    $up['qty_beli']=$tbeli;
    $ubah=$this->Pembelian_m->Update_barang_pembelian($jual, $barang,$up);
    //hapus data
    $hasil=$this->Pembelian_m->Delete_retur($id);
    redirect(site_url().'Dpembelian/retur/'.$jual);

  }

  public function Kembalikan_barang($id){
        
    //cek data retur
    $item=$this->Pembelian_m->Detail_retur_nol($id)->result();
    $kode=$this->Pembelian_m->Daftar_pembelian_id($id)->row();
    $kj=explode('-',$kode->kode_beli);
    $gretur=0;
    $tobeli=0;
    foreach($item as $data_item)
    {
      $id_item=$data_item->id_retur;
      $id_brg=$data_item->id_barang;
      $qty=$data_item->qty_retur;
      //echo $qty;
      
      //UPDATE STATUS TABEL RETUR      
      $entri['status'] = 1;
      $entri['kode_retur'] = "RB-".$kj[1];
      $hasil=$this->Pembelian_m->Update_retur($id_item,$entri);

      //UPDATE JUMLAH BARANG
      $data_barang=$this->Pembelian_m->Daftar_barang_id($id_brg)->row();
      $stok_awal=$data_barang->stok;
      $stok_akhir=$stok_awal- $qty;
      $kategori=$data_barang->id_kategori;
      $brg_stok['stok'] = $stok_akhir;
      
      //$this->Pembelian_m->Update_stok_retur($id_brg,$brg_stok);

      //UPDATE JUMLAH PEMBELIAN BARANG
      $detil_pembelian=$this->Pembelian_m->Jumlah_pembelian($id,$id_brg)->row();
     // $jumlah_pembelian=$detil_pembelian->qty_beli;
    //$jumlah_pembelian_akhir=$jumlah_pembelian-$qty;
      if ($jumlah_pembelian_akhir <= 0) {
        $jumlah_pembelian_akhir = 0;
      }
      $d_beli['qty_beli']= $detil_pembelian->qty_beli;
      $d_beli['subtotal']= $detil_pembelian->qty_beli*$detil_pembelian->hrg_beli;
      $this->Pembelian_m->Update_detail_beli($detil_pembelian->id_detil_beli,$d_beli);
      $gretur=$gretur+($qty*$detil_pembelian->hrg_beli);
      $tobeli=$tobeli+$d_beli['subtotal'];
      //Jurnal PERSEDIAAN TOKO
      // $Sedia_toko['vcIDJournal']=$entri['kode_retur'];
      // $Sedia_toko['dtJournal']=date("Y-m-d H:i:s");
      // if($kategori==9)
      // {
      //   $Sedia_toko['vcCOAJournal']='11310-000';
      //   $Sedia_toko['cuJournalCredit']=$gretur;
      // }
      // else
      // {
      //   $Sedia_toko['vcCOAJournal']='11311-000';
      //   $Sedia_toko['cuJournalCredit']=$gretur;
      // }
      // $Sedia_toko['vcJournalDesc']='Retur Penjualan';
      // $Sedia_toko['itPostJournal']='1';
      // $Sedia_toko['vcUserID']='admin';
      // $jurnal_SediaT=$this->Pembelian_m->Insert_jurnal_retur($Sedia_toko);
    }
    $db['total']=$tobeli;
    $gg=$this->Pembelian_m->Update_beli($id,$db);
    
    // jurnal kas retur
    // $kas['vcIDJournal']=$entri['kode_retur'];
    // $kas['dtJournal']=date("Y-m-d H:i:s");
    // if($kode->method=="Cash")
    // {
    //  $kas['vcCOAJournal']='11110-000';
    // }
    // else
    // {
    //  $kas['vcCOAJournal']='21111-000';
    // }
    // $kas['cuJournalDebet']=$gretur;
    // $kas['vcJournalDesc']='Retur Pembelian';
    // $kas['itPostJournal']='1';
    // $kas['vcUserID']='admin';
    //echo $kode->method;
    // $jurnal_kas=$this->Pembelian_m->Insert_jurnal_retur($kas);
    
     //Update Piutang
     if ($kode->method == "Kredit") {
      $Piutang_awal=$this->Pembelian_m->Hutang_beli($id)->row();
      $Piutang_akhir=$Piutang_awal->sisa-$gretur;
      $data_piutang['sisa']=$Piutang_akhir; 
      $data_piutang['jml_hutang']=$Piutang_akhir; 
      $update_piutang=$this->Pembelian_m->Update_hutang_beli($id,$data_piutang);
    } else {
      //update table kas
      $jmlkas =  $this->db->query('select sum(subtotal) as jml, pembelian.kode_beli from detil_pembelian inner join pembelian on pembelian.id_beli = detil_pembelian.id_beli where pembelian.id_beli=' . $id)->row();
      if (isset($jmlkas)) {
        $this->Pembelian_m->ReplaceKas($jmlkas->kode_beli,$jmlkas->jml);
      }      
    }
    redirect(site_url().'Dpembelian');
  }
  
}
