<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Posting extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    cek_login();
    $this->load->model('Posting_m');
  }

  public function index($page = 0)
  {
    $list = array();
    $bulan = $this->session->filter_bulan;
    $tahun = $this->session->filter_tahun;
    if (isset($_POST['bulan'])) {

      $array = array(
        'filter_bulan' => $_POST['bulan'],
        'filter_tahun' => $_POST['tahun'],
      );

      $this->session->set_userdata($array);
      $bulan = $_POST['bulan'];
      $tahun = $_POST['tahun'];
    }

    //cari kode kas
    $coakas = $this->Posting_m->GetProfile()->row();
    // print_r($coakas);
    // die;
    //1. jurnal penjualan Debet
    $jurnal_debet = $this->Posting_m->PenjualanDebet($bulan, $tahun)->result();
    if (count($jurnal_debet) > 0) {
      foreach ($jurnal_debet as $jd) {
        $dt['vcIDJournal'] = "PJ" . $jd->id_cs . "-" . $tahun . $bulan;
        $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
        if ($jd->method == 'Cash') {
          $dt['vcCOAJournal'] = $coakas->coa_cash;
        } elseif ($jd->method == 'Kredit') {
          $dt['vcCOAJournal'] = $coakas->coa_kredit;
        } elseif ($jd->method == 'Transfer') {
          $dt['vcCOAJournal'] = $coakas->coa_transfer;
        } else {
          $dt['vcCOAJournal'] = $coakas->coa_cash;
        }
        $dt['cuJournalDebet'] = $jd->jml;
        $dt['cuJournalCredit'] = 0;
        $dt['vcJournalDesc'] = "Transaksi Penjualan " . $jd->method . " " . $jd->nama . " " . $bulan . "-" . $tahun;
        $dt['itPostJournal'] = 1;
        $dt['vcUserID'] = $this->session->username;
        array_push($list, $dt);
      }
    }
    // print_r($list);
    // die;
    //2. jurnal penjualan kredit
    $jurnal_kredit = $this->Posting_m->PenjualanKredit($bulan, $tahun)->result();
    if (count($jurnal_kredit) > 0) {
      foreach ($jurnal_kredit as $jd) {
        $dt['vcIDJournal'] = "PJ" . $jd->id_cs . "-" . $tahun . $bulan;
        $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
        $dt['vcCOAJournal'] = $jd->coa_penjualan;
        $dt['cuJournalDebet'] = 0;
        $dt['cuJournalCredit'] = $jd->jml;
        $dt['vcJournalDesc'] = "Transaksi Penjualan " . $jd->kategori . " " . $jd->method . " " . $jd->nama . " " . $bulan . "-" . $tahun;
        $dt['itPostJournal'] = 1;
        $dt['vcUserID'] = $this->session->username;
        array_push($list, $dt);
      }
    }

    //3. jurnal HPP
    $persediaan = $this->Posting_m->PenjualanPersediaan($bulan, $tahun)->result();
    if (count($persediaan) > 0) {
      foreach ($persediaan as $jd) {
        $dt['vcIDJournal'] = "PS" . $jd->id_barang . "-" . $tahun . $bulan;
        $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
        $dt['vcCOAJournal'] = $jd->coa_hpp;
        $dt['cuJournalDebet'] = $jd->jml;
        $dt['cuJournalCredit'] = 0;
        $dt['vcJournalDesc'] = "HPP " . $jd->kategori . " " . $jd->nama_barang . " " . $bulan . "-" . $tahun;
        $dt['itPostJournal'] = 1;
        $dt['vcUserID'] = $this->session->username;
        array_push($list, $dt);

        $dt['vcIDJournal'] = "PS" . $jd->id_barang . "-" . $tahun . $bulan;
        $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
        $dt['vcCOAJournal'] = $jd->coa_persediaan;
        $dt['cuJournalDebet'] = 0;
        $dt['cuJournalCredit'] = $jd->jml;
        $dt['vcJournalDesc'] = "Persediaan " . $jd->kategori . " " . $jd->nama_barang . " " . $bulan . "-" . $tahun;
        $dt['itPostJournal'] = 1;
        $dt['vcUserID'] = $this->session->username;
        array_push($list, $dt);
      }
    }
    //4. jurnal pembayaran piutang
    $piutang = $this->Posting_m->BayarPiutang($bulan, $tahun)->result();
    if (count($piutang) > 0) {
      foreach ($piutang as $jd) {
        $dt['vcIDJournal'] = "BPI" . "-" . $tahun . $bulan;
        $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
        $dt['vcCOAJournal'] = $jd->coakas;
        $dt['cuJournalDebet'] = $jd->jml;
        $dt['cuJournalCredit'] = 0;
        $dt['vcJournalDesc'] = "Pembayaran Piutang Toko " . $bulan . "-" . $tahun;
        $dt['itPostJournal'] = 1;
        $dt['vcUserID'] = $this->session->username;
        array_push($list, $dt);

        $dt['vcIDJournal'] = "BPI" . "-" . $tahun . $bulan;
        $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
        $dt['vcCOAJournal'] = '11210-000';
        $dt['cuJournalDebet'] = 0;
        $dt['cuJournalCredit'] = $jd->jml;
        $dt['vcJournalDesc'] = "Pembayaran Piutang Toko " . $bulan . "-" . $tahun;
        $dt['itPostJournal'] = 1;
        $dt['vcUserID'] = $this->session->username;
        array_push($list, $dt);
      }
    }

    //6. jurnal pembelian
    $beli = $this->Posting_m->Pembelian($bulan, $tahun)->result();
    if (count($beli) > 0) {
      foreach ($beli as $jd) {
        $dt['vcIDJournal'] = "PBS" . $jd->id_barang . "-" . $tahun . $bulan;
        $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
        $dt['vcCOAJournal'] = $jd->coa_persediaan;
        $dt['cuJournalDebet'] = $jd->jml;
        $dt['cuJournalCredit'] = 0;
        $dt['vcJournalDesc'] = "Pembelian " . $jd->nama_barang . " " . $bulan . "-" . $tahun;
        $dt['itPostJournal'] = 1;
        $dt['vcUserID'] = $this->session->username;
        array_push($list, $dt);

        $dt['vcIDJournal'] = "PBS" . $jd->id_barang . "-" . $tahun . $bulan;
        $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
        $dt['vcCOAJournal'] = $jd->coakas;
        $dt['cuJournalDebet'] = 0;
        $dt['cuJournalCredit'] = $jd->jml;
        $dt['vcJournalDesc'] = "Pembelian " . $jd->nama_barang . " " . $bulan . "-" . $tahun;
        $dt['itPostJournal'] = 1;
        $dt['vcUserID'] = $this->session->username;
        array_push($list, $dt);
      }
    }

    //8. jurnal pembayaran hutang
    $bayar = $this->Posting_m->BayarHutang($bulan, $tahun)->result();
    if (count($bayar) > 0) {
      foreach ($bayar as $jd) {
        $dt['vcIDJournal'] = "PHU" . $jd->id_supplier . "-" . $tahun . $bulan;
        $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
        $dt['vcCOAJournal'] = '21111-000';
        $dt['cuJournalDebet'] = $jd->jml;
        $dt['cuJournalCredit'] = 0;
        $dt['vcJournalDesc'] = "Pembayaran Hutang " . $jd->nama_supplier . " " . $bulan . "-" . $tahun;
        $dt['itPostJournal'] = 1;
        $dt['vcUserID'] = $this->session->username;
        array_push($list, $dt);

        $dt['vcIDJournal'] = "PHU" . $jd->id_supplier . "-" . $tahun . $bulan;
        $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
        $dt['vcCOAJournal'] = $jd->coakas;
        $dt['cuJournalDebet'] = 0;
        $dt['cuJournalCredit'] = $jd->jml;
        $dt['vcJournalDesc'] = "Pembayaran Hutang " . $jd->nama_supplier . " " . $bulan . "-" . $tahun;
        $dt['itPostJournal'] = 1;
        $dt['vcUserID'] = $this->session->username;
        array_push($list, $dt);
      }
    }

    $data = array(
      'title'    => 'Posting ke Jurnal',
      'user'     => infoLogin(),
      'list'    => $list,
      'content'  => 'posting/index',
      'filter_tahun' => $tahun,
      'filter_bulan' => $bulan,
      'toko'     => $this->db->get_where('profil_perusahaan', array('id_toko' => $this->session->cabang))->row(),
      'page' => $page
    );
    $this->load->view('templates/main', $data);
  }

  function CekPosting()
  {
    $id = $_POST['id'];
    $coa = $_POST['coa'];
    $res = $this->Posting_m->CekPosting($id, $coa);
    echo json_encode($res);
  }

  function Repost()
  {
    $ls['dtJournal'] = $_POST['tgl'];
    $ls['vcCOAJournal'] = $_POST['coa'];
    $ls['vcIDJournal'] = $_POST['id'];
    $ls['vcJournalDesc'] = $_POST['ket'];
    $ls['cuJournalDebet'] = str_replace(",", "", $_POST['debet']);
    $ls['cuJournalCredit'] = str_replace(",", "", $_POST['kredit']);
    $ls['vcUserID'] = $this->session->username;
    $ls['itPostJournal'] = 1;
    $this->db->delete('tbl_journal', array('vcIDJournal' => $_POST['id'], 'vcCOAJournal' => $_POST['coa'], 'vcJournalDesc' => $_POST['ket']));
    $this->db->insert('tbl_journal', $ls);
    $res['id'] =  $this->db->insert_id();
    echo json_encode($res);
  }

  public function Proses($trans = 0)
  {
    $list = array();
    $bulan = $this->session->filter_bulan;
    $tahun = $this->session->filter_tahun;

    if ($bulan == "") {
      $bulan = date("n");
    }
    if ($tahun == "") {
      $tahun = date('Y');
    }

    //cari profile perusahaan
    $coakas = $this->Posting_m->GetProfile()->row();

    if ($trans == 0) {
      $this->db->query("delete from tbl_journal where month(dtJournal)=$bulan and year(dtJournal)=$tahun and (vcIDJournal like 'PJ%' or vcIDJournal like 'PS%' or vcIDJournal like 'BPI%' or vcIDJournal like 'PBS%' or vcIDJournal like 'PHU%') ");
    }

    if ($trans == 1) {
      
      //1. jurnal penjualan Debet
      $jurnal_debet = $this->Posting_m->PenjualanDebet($bulan, $tahun)->result();
      if (count($jurnal_debet) > 0) {
        foreach ($jurnal_debet as $jd) {
          $dt['vcIDJournal'] = "PJ" . $jd->id_cs . "-" . $tahun . $bulan;
          $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
          if ($jd->method == 'Cash') {
            $dt['vcCOAJournal'] = $coakas->coa_cash;
          } elseif ($jd->method == 'Kredit') {
            $dt['vcCOAJournal'] = $coakas->coa_kredit;
          } elseif ($jd->method == 'Transfer') {
            $dt['vcCOAJournal'] = $coakas->coa_transfer;
          } else {
            $dt['vcCOAJournal'] = $coakas->coa_cash;
          }
          $dt['cuJournalDebet'] = $jd->jml;
          $dt['cuJournalCredit'] = 0;
          $dt['vcJournalDesc'] = "Transaksi Penjualan " . $jd->method . " " . $jd->nama . " " . $bulan . "-" . $tahun;
          $dt['itPostJournal'] = 1;
          $dt['vcUserID'] = $this->session->username;
          array_push($list, $dt);
        }
      }
    }
    if ($trans == 2) {
      //2. jurnal penjualan kredit
      $jurnal_kredit = $this->Posting_m->PenjualanKredit($bulan, $tahun)->result();
      if (count($jurnal_kredit) > 0) {
        foreach ($jurnal_kredit as $jd) {
          $dt['vcIDJournal'] = "PJ" . $jd->id_cs . "-" . $tahun . $bulan;
          $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
          $dt['vcCOAJournal'] = $jd->coa_penjualan;
          $dt['cuJournalDebet'] = 0;
          $dt['cuJournalCredit'] = $jd->jml;
          $dt['vcJournalDesc'] = "Transaksi Penjualan " . $jd->kategori . " " . $jd->method . " " . $jd->nama . " " . $bulan . "-" . $tahun;
          $dt['itPostJournal'] = 1;
          $dt['vcUserID'] = $this->session->username;
          array_push($list, $dt);
        }
      }
    }
    if ($trans == 3) {
      //3. jurnal HPP
      $persediaan = $this->Posting_m->PenjualanPersediaan($bulan, $tahun)->result();
      if (count($persediaan) > 0) {
        foreach ($persediaan as $jd) {
          $dt['vcIDJournal'] = "PS" . $jd->id_barang . "-" . $tahun . $bulan;
          $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
          $dt['vcCOAJournal'] = $jd->coa_hpp;
          $dt['cuJournalDebet'] = $jd->jml;
          $dt['cuJournalCredit'] = 0;
          $dt['vcJournalDesc'] = "HPP " . $jd->kategori . " " . $jd->nama_barang . " " . $bulan . "-" . $tahun;
          $dt['itPostJournal'] = 1;
          $dt['vcUserID'] = $this->session->username;
          array_push($list, $dt);

          $dt['vcIDJournal'] = "PS" . $jd->id_barang . "-" . $tahun . $bulan;
          $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
          $dt['vcCOAJournal'] = $jd->coa_persediaan;
          $dt['cuJournalDebet'] = 0;
          $dt['cuJournalCredit'] = $jd->jml;
          $dt['vcJournalDesc'] = "Persediaan " . $jd->kategori . " " . $jd->nama_barang . " " . $bulan . "-" . $tahun;
          $dt['itPostJournal'] = 1;
          $dt['vcUserID'] = $this->session->username;
          array_push($list, $dt);
        }
      }
    }
    if ($trans == 4) {
      //4. jurnal pembayaran piutang
      $piutang = $this->Posting_m->BayarPiutang($bulan, $tahun)->result();
      if (count($piutang) > 0) {
        foreach ($piutang as $jd) {
          $dt['vcIDJournal'] = "BPI" . "-" . $tahun . $bulan;
          $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
          $dt['vcCOAJournal'] = $jd->coakas;
          $dt['cuJournalDebet'] = $jd->jml;
          $dt['cuJournalCredit'] = 0;
          $dt['vcJournalDesc'] = "Pembayaran Piutang Toko " . $bulan . "-" . $tahun;
          $dt['itPostJournal'] = 1;
          $dt['vcUserID'] = $this->session->username;
          array_push($list, $dt);

          $dt['vcIDJournal'] = "BPI" . "-" . $tahun . $bulan;
          $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
          $dt['vcCOAJournal'] = '11210-000';
          $dt['cuJournalDebet'] = 0;
          $dt['cuJournalCredit'] = $jd->jml;
          $dt['vcJournalDesc'] = "Pembayaran Piutang Toko " . $bulan . "-" . $tahun;
          $dt['itPostJournal'] = 1;
          $dt['vcUserID'] = $this->session->username;
          array_push($list, $dt);
        }
      }
    }
    if ($trans == 5) {
      //5. jurnal pembelian
      $beli = $this->Posting_m->Pembelian($bulan, $tahun)->result();
      if (count($beli) > 0) {
        foreach ($beli as $jd) {
          $dt['vcIDJournal'] = "PBS" . $jd->id_barang . "-" . $tahun . $bulan;
          $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
          $dt['vcCOAJournal'] = $jd->coa_persediaan;
          $dt['cuJournalDebet'] = $jd->jml;
          $dt['cuJournalCredit'] = 0;
          $dt['vcJournalDesc'] = "Pembelian " . $jd->nama_barang . " " . $bulan . "-" . $tahun;
          $dt['itPostJournal'] = 1;
          $dt['vcUserID'] = $this->session->username;
          array_push($list, $dt);

          $dt['vcIDJournal'] = "PBS" . $jd->id_barang . "-" . $tahun . $bulan;
          $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
          $dt['vcCOAJournal'] = $jd->coakas;
          $dt['cuJournalDebet'] = 0;
          $dt['cuJournalCredit'] = $jd->jml;
          $dt['vcJournalDesc'] = "Pembelian " . $jd->nama_barang . " " . $bulan . "-" . $tahun;
          $dt['itPostJournal'] = 1;
          $dt['vcUserID'] = $this->session->username;
          array_push($list, $dt);
        }
      }
    }
    if ($trans == 6) {
      //6. jurnal pembayaran hutang
      $bayar = $this->Posting_m->BayarHutang($bulan, $tahun)->result();
      if (count($bayar) > 0) {
        foreach ($bayar as $jd) {
          $dt['vcIDJournal'] = "PHU" . $jd->id_supplier . "-" . $tahun . $bulan;
          $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
          $dt['vcCOAJournal'] = '21111-000';
          $dt['cuJournalDebet'] = $jd->jml;
          $dt['cuJournalCredit'] = 0;
          $dt['vcJournalDesc'] = "Pembayaran Hutang " . $jd->nama_supplier . " " . $bulan . "-" . $tahun;
          $dt['itPostJournal'] = 1;
          $dt['vcUserID'] = $this->session->username;
          array_push($list, $dt);

          $dt['vcIDJournal'] = "PHU" . $jd->id_supplier . "-" . $tahun . $bulan;
          $dt['dtJournal'] = $tahun . "-" . $bulan . "-28";
          $dt['vcCOAJournal'] = $jd->coakas;
          $dt['cuJournalDebet'] = 0;
          $dt['cuJournalCredit'] = $jd->jml;
          $dt['vcJournalDesc'] = "Pembayaran Hutang " . $jd->nama_supplier . " " . $bulan . "-" . $tahun;
          $dt['itPostJournal'] = 1;
          $dt['vcUserID'] = $this->session->username;
          array_push($list, $dt);
        }
      }
    }

    if (count($list) > 0) {
      foreach ($list as $ls) {
        $this->db->insert('tbl_journal', $ls);
      }
    }
    if ($trans >= 7) {
      redirect(site_url('posting'));
    } else {
      $data = array(
        'title'    => 'Posting ke Jurnal',
        'user'     => infoLogin(),
        'list'    => $list,
        'content'  => 'posting/loading',
        'filter_tahun' => $tahun,
        'filter_bulan' => $bulan,
        'toko' => $coakas,
        'page' => $trans
      );
      $this->load->view('templates/main', $data);
    }
  }
}
