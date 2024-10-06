<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Piutang_m extends CI_Model
{

  protected $table = 'piutang';
  protected $primary = 'id_piutang';

  public function getAllData($bln="",$thn="")
  {
    if ($bln == "") {$bln = date('m');}
    if ($thn == "") {$thn = date('Y');}
    $sql = "SELECT b.id_piutang, a.invoice, c.nama, b.tgl_piutang, b.jml_piutang, b.bayar, b.jatuh_tempo, b.sisa, b.status FROM penjualan a inner join piutang b on b.id_jual  = a.id_jual inner join tbl_anggota c ON a.id_cs = c.id where month(b.tgl_piutang)=$bln and year(b.tgl_piutang)=$thn";
    return $this->db->query($sql)->result_array();
  }

  public function getDetail($id)
  {
    $sql = "SELECT b.id_detil_piutang, c.nama_lengkap, b.nominal, b.tgl_bayar FROM piutang a, detil_piutang b, user c WHERE a.id_piutang = b.id_piutang AND c.id_user = b.id_user AND a.id_piutang = '$id'";
    return $this->db->query($sql)->result_array();
  }

  public function Bayar($id)
  {
    $user = infoLogin();
    $nominal = $this->input->post('nominal');
    $data = array(
      'tgl_bayar'   => date('Y-m-d H:i:s'),
      'nominal'     => $nominal,
      'id_user'     => $user['id_user'],
      'id_piutang'  => $id,
      'coakas'      => $this->input->post('idkas'),
    );
    $this->db->insert('detil_piutang', $data);
    $idDetilPiutang = $this->db->insert_id();

    //---insert ke jurnal
      // $djurnalD = array(
      //   'vcIDJOurnal'   => 'PG-' . $idDetilPiutang,
      //   'dtJournal'     => date('Y-m-d H:i:s'),
      //   'vcCOAJournal'  => $this->input->post('idkas'),
      //   'cuJournalDebet' => $nominal,
      //   'cuJournalCredit' => 0,
      //   'vcJournalDesc' => 'pembayaran piutang toko',
      //   'itPostJournal' => '1',
      //   'vcUserID'  => $user['id_user']
      // );
      // $this->db->insert('tbl_journal',$djurnalD);

      // $djurnalK = array(
      //   'vcIDJOurnal'   => 'PG-' . $idDetilPiutang,
      //   'dtJournal'     => date('Y-m-d H:i:s'),
      //   'vcCOAJournal'  => '11210-000',
      //   'cuJournalDebet' => 0,
      //   'cuJournalCredit' => $nominal,
      //   'vcJournalDesc' => 'pembayaran piutang toko',
      //   'itPostJournal' => '1',
      //   'vcUserID'  => $user['id_user']
      // );
      // $this->db->insert('tbl_journal',$djurnalK);
    //---insert ke jurnal

    $get_bayar = "SELECT SUM(nominal) AS nominal FROM detil_piutang WHERE id_piutang = '$id'";
    $get_jml_piutang = "SELECT jml_piutang FROM piutang WHERE id_piutang = '$id'";
    $bayar = implode($this->db->query($get_bayar)->row_array());
    $jml = implode($this->db->query($get_jml_piutang)->row_array());
    $sisa = $jml - $bayar;
    $update = array(
      'bayar' => $bayar,
      'sisa'  => $sisa
    );
    $this->db->set($update);
    $this->db->where($this->primary, $id);
    $this->db->update($this->table);

    if ($sisa == 0) {
      $status = array(
        'status'  => 'Lunas'
      );
      $this->db->set($status);
      $this->db->where($this->primary, $id);
      $this->db->update($this->table);
    }

    $this->db->select("RIGHT (kas.kode_kas, 7) as kode_kas", false);
    $this->db->order_by("kode_kas", "DESC");
    $this->db->limit(1);
    $query = $this->db->get('kas');

    if ($query->num_rows() <> 0) {
      $data = $query->row();
      $kode = intval($data->kode_kas) + 1;
    } else {
      $kode = 1;
    }
    $kodeks = str_pad($kode, 7, "0", STR_PAD_LEFT);
    $kodekas = "KS-" . $kodeks;
    $kas = array(
      'id_user'   => $user['id_user'],
      'kode_kas'  => $kodekas,
      'tanggal'    => date('Y-m-d H:i:s'),
      'jenis'      => 'Pemasukan',
      'keterangan' => 'Pembayaran Piutang',
      'nominal'    => $nominal,
    );

    $this->db->insert('kas', $kas);
  }

  public function delete_payment($id)
  {
    $user = infoLogin();
    $query_detil = "select nominal, id_piutang from detil_piutang where id_detil_piutang = '$id'";
    $detail = $this->db->query($query_detil)->row_array();
    $id_piutang = $detail['id_piutang'];
    $query_piutang = "select bayar, sisa from piutang where id_piutang = '$id_piutang'";
    $piutang = $this->db->query($query_piutang)->row_array();

    $bayar = $piutang['bayar'] - $detail['nominal'];
    $sisa = $piutang['sisa'] + $detail['nominal'];

    $update = array(
      'bayar' => $bayar,
      'sisa'  => $sisa
    );
    $this->db->set($update)->where('id_piutang', $id_piutang)->update('piutang');
    $this->db->where('id_detil_piutang', $id)->delete('detil_piutang');

    $this->db->select("RIGHT (kas.kode_kas, 7) as kode_kas", false);
    $this->db->order_by("kode_kas", "DESC");
    $this->db->limit(1);
    $query = $this->db->get('kas');

    if ($query->num_rows() <> 0) {
      $data = $query->row();
      $kode = intval($data->kode_kas) + 1;
    } else {
      $kode = 1;
    }
    $kodeks = str_pad($kode, 7, "0", STR_PAD_LEFT);
    $kodekas = "KS-" . $kodeks;
    // $kas = array(
    //   'id_user'    => $user['id_user'],
    //   'kode_kas'   => $kodekas,
    //   'tanggal'    => date('Y-m-d H:i:s'),
    //   'jenis'      => 'Pengeluaran',
    //   'keterangan' => 'Pembayaran Piutang Telah Dihapus',
    //   'nominal'    => $detail['nominal'],
    // );

    // $this->db->insert('kas', $kas);
    // $this->db->where('vcIDJournal', 'PG-' . $id)->delete('tbl_journal');
  }

  function GetKas() {
    $this->db->select('vcCOACode,nama');
    $this->db->from('nama_kas_tbl');
    return $this->db->get();
  }
}
