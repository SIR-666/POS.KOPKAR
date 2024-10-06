<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hutang_m extends CI_Model
{

  protected $table = 'hutang';
  protected $primary = 'id_hutang';

  public function getAllData($sort = null)
  {
    // Menginisialisasi query dasar
    $sql = "SELECT a.id_hutang, b.kode_beli, c.nama_supplier, a.tgl_hutang, a.jml_hutang, a.jatuh_tempo, a.bayar, a.sisa, a.status 
            FROM hutang a 
            JOIN pembelian b ON a.id_beli = b.id_beli 
            JOIN supplier c ON c.id_supplier = b.id_supplier";

    // // Menambahkan pengurutan jika ada parameter sort
    // if ($sort === 'tgl_hutang') {
    //     $sql .= " ORDER BY a.tgl_hutang DESC"; // Urutkan berdasarkan tgl_hutang
    // } elseif ($sort === 'status') {
    //     $sql .= " ORDER BY a.status DESC"; // Urutkan berdasarkan status
    // }
    // die($sql);
    return $this->db->query($sql)->result_array();
  }
  public function getDetailBeli($id)
  {
    $sql = "SELECT a.id_beli, b.nama_supplier, a.faktur_beli, a.tgl, a.tgl_faktur, a.total FROM pembelian a, supplier b WHERE a.id_supplier = b.id_supplier AND a.id_beli = '$id'";
    return $this->db->query($sql)->row_array();
  }

  // public function Save()
  // {
  //   $data = array(
  //     'id_beli'      => htmlspecialchars($this->input->post('id_pembelian'), true),
  //     'tgl_hutang'   => htmlspecialchars($this->input->post('tgl_hutang'), true),
  //     'jml_hutang'   => htmlspecialchars($this->input->post('jml_hutang'), true),
  //     'bayar'        => 0,
  //     'sisa'         => htmlspecialchars($this->input->post('jml_hutang'), true),
  //     'status'       => 'Belum Lunas',

  //   );
  //   return $this->db->insert($this->table, $data);
  // }

  public function hapusPembayaran($id)
  {
    $this->db->where('id_detil_hutang', $id);
    return $this->db->delete('detil_hutang');
  }

  public function getDetail($id)
  {
    $sql = "SELECT b.id_detil_hutang, c.nama_lengkap, b.nominal, b.tgl_bayar FROM hutang a, detil_hutang b, user c WHERE a.id_hutang = b.id_hutang AND c.id_user = b.id_user AND a.id_hutang = '$id'";
    return $this->db->query($sql)->result_array();
  }

  public function Bayar($id)
  {
    $user = infoLogin();
    $nominal = $this->input->post('nominal');
    $sisa    = $this->input->post('sisa');
    if($nominal>$sisa)
    {
      $nominal=$sisa;
    }
    $data = array(
      'tgl_bayar'   => date('Y-m-d H:i:s'),
      'nominal'     => $nominal,
      'id_user'     => $user['id_user'],
      'id_hutang'   => $id,
      'coakas'      => $this->input->post('idkas')
    );
    $this->db->insert('detil_hutang', $data);

    $idDetilHutang = $this->db->insert_id();

    //---insert ke jurnal
      // $djurnalK = array(
      //   'vcIDJOurnal'   => 'HG-' . $idDetilHutang,
      //   'dtJournal'     => date('Y-m-d H:i:s'),
      //   'vcCOAJournal'  => $this->input->post('idkas'),
      //   'cuJournalDebet' => 0,
      //   'cuJournalCredit' => $nominal,
      //   'vcJournalDesc' => 'pembayaran hutang toko',
      //   'itPostJournal' => '1',
      //   'vcUserID'  => $user['id_user']
      // );
      // $this->db->insert('tbl_journal',$djurnalK);

      // $djurnalD = array(
      //   'vcIDJOurnal'   => 'HG-' . $idDetilHutang,
      //   'dtJournal'     => date('Y-m-d H:i:s'),
      //   'vcCOAJournal'  => '21111-000',
      //   'cuJournalDebet' => $nominal,
      //   'cuJournalCredit' => 0,
      //   'vcJournalDesc' => 'pembayaran hutang toko',
      //   'itPostJournal' => '1',
      //   'vcUserID'  => $user['id_user']
      // );
      // $this->db->insert('tbl_journal',$djurnalD);
    //---insert ke jurnal

    $get_bayar = "SELECT SUM(nominal) AS nominal FROM detil_hutang WHERE id_hutang = '$id'";
    $get_jml_hutang = "SELECT jml_hutang FROM hutang WHERE id_hutang = '$id'";
    $bayar = implode($this->db->query($get_bayar)->row_array());
    $jml = implode($this->db->query($get_jml_hutang)->row_array());
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
      'id_user'    => $user['id_user'],
      'kode_kas'   => $kodekas,
      'tanggal'    => date('Y-m-d H:i:s'),
      'jenis'      => 'Pengeluaran',
      'keterangan' => 'Pembayaran Hutang',
      'nominal'    => $nominal,
    );

    $this->db->insert('kas', $kas);
  }

  public function delete_payment($id)
  {
    
    $user = infoLogin();
    $query_detil = "SELECT b.id_detil_hutang, a.id_hutang, b.nominal FROM hutang a, detil_hutang b WHERE a.id_hutang = b.id_hutang AND a.id_hutang = '$id'";
    $detail = $this->db->query($query_detil)->row_array();
    
    $id_hutang = $detail['id_hutang'];
    $id_detil_hutang = $detail['id_detil_hutang'];
    $query_hutang = "select bayar, sisa from hutang where id_hutang = '$id_hutang'";
    $hutang = $this->db->query($query_hutang)->row_array();
    
    $bayar = $hutang['bayar'] - $detail['nominal'];
    $sisa = $hutang['sisa'] + $detail['nominal'];
    $status = ($sisa > 0) ? 'Belum Lunas' : 'Lunas';

    $update = array(
      'bayar' => $bayar,
      'sisa'  => $sisa,
      'status' => $status  // Add the status logic here
    );
    $this->db->set($update)->where($this->primary, $id_hutang)->update($this->table);
    $this->db->where('id_detil_hutang', $id_detil_hutang)->delete('detil_hutang');

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
      'id_user'    => $user['id_user'],
      'kode_kas'   => $kodekas,
      'tanggal'    => date('Y-m-d H:i:s'),
      'jenis'      => 'Pemasukan',
      'keterangan' => 'Pembayaran Hutang Telah Dihapus',
      'nominal'    => $detail['nominal'],
    );

    $this->db->insert('kas', $kas);
    $this->db->where('vcIDJournal', 'HG-' . $id)->delete('tbl_journal');
  }
  function GetKas() {
    $this->db->select('vcCOACode,nama');
    $this->db->from('nama_kas_tbl');
    return $this->db->get();
  }
}
