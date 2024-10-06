<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan_m extends CI_Model
{

    protected $table = 'penjualan';
    protected $primary = 'id_jual';

    public function getAllData()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function getDetilJual()
    {
        $sql = "SELECT a.id_detil_jual, b.barcode, b.nama_barang, a.harga_item as harga_jual, a.qty_jual, a.diskon, a.subtotal FROM detil_penjualan a, barang b WHERE b.id_barang = a.id_barang AND a.id_jual IS NULL AND a.id_user = " . $this->session->id;
        //echo $sql;
        //die;
        return $this->db->query($sql)->result_array();
    }

    public function getDetilService()
    {
        $sql = "SELECT a.id_detil_jual, b.kode, b.nama_servis, a.harga_item, a.subtotal, a.qty_jual, c.nama_karyawan
        FROM detil_penjualan a, servis b, karyawan c WHERE b.id_servis = a.id_servis AND a.id_karyawan = c.id_karyawan AND a.id_jual IS NULL and a.id_user=" . $this->session->id;
        return $this->db->query($sql)->result_array();
    }

    public function addItem($id, $qty, $subtotal, $harga, $jenis, $pegawai, $operator,$hpp=0)
    {
        $this->db->select("RIGHT (detil_penjualan.kode_detil_jual, 7) as kode_detil_jual", false);
        $this->db->order_by("kode_detil_jual", "DESC");
        $this->db->limit(1);
        $query = $this->db->get('detil_penjualan');

        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode_detil_jual) + 1;
        } else {
            $kode = 1;
        }
        $kodedetil = str_pad($kode, 7, "0", STR_PAD_LEFT);
        $detiljual = "DJ-" . $kodedetil;
        if ($jenis == "Produk") {
            $data = array(
                'id_barang'           => $id,
                'id_servis'           => null,
                'id_karyawan'         => null,
                'kode_detil_jual'     => $detiljual,
                'diskon'              => 0,
                'harga_item'          => $harga,
                'qty_jual'            => $qty,
                'subtotal'            => $subtotal,
                'id_user'             => $operator,
                'hpp'                 => $hpp  

            );
            $this->db->insert('detil_penjualan', $data);
        } else if ($jenis == "Servis") {
            $data = array(
                'id_barang'           => null,
                'id_servis'           => $id,
                'id_karyawan'         => $pegawai,
                'kode_detil_jual'     => $detiljual,
                'diskon'              => 0,
                'harga_item'          => $harga,
                'qty_jual'            => $qty,
                'subtotal'            => $subtotal,

            );
            $this->db->insert('detil_penjualan', $data);
        }

        $sql = "SELECT sum(subtotal) as subtotal FROM detil_penjualan WHERE id_jual IS NULL and id_user=" . $this->session->id;
        $data = $this->db->query($sql)->row_array();
        echo json_encode($data);
    }

    public function editDetailPenjualan($id, $diskon, $qty, $hakhir, $hpp=0)
    {
        $data = array(
            'diskon'     => $diskon,
            'qty_jual'   => $qty,
            'subtotal'   => $hakhir,
            'hpp'       => $hpp,
        );
        return $this->db->set($data)->where('id_detil_jual', $id)->update('detil_penjualan');
    }

    public function hapusDetail($id)
    {
        $getDetil = $this->db->get_where('detil_penjualan', ['id_detil_jual' => $id])->row_array();
        $qty = $getDetil['qty_jual'];
        $idBrg = $getDetil['id_barang'];

        // if ($idBrg != NULL) {

        //     $getBrg = $this->db->get_where('barang', ['id_barang' => $idBrg])->row_array();
        //     $stokBrg = $getBrg['stok'];
        //     $stok = $qty + $stokBrg;
        //     $updateStok = $this->db->set(array('stok' => $stok))->where('id_barang', $idBrg)->update('barang');
        // }
        $sql = "delete from detil_penjualan where id_detil_jual = '$id'";
        $this->db->query($sql);

        $subtotal = "SELECT sum(subtotal) as subtotal FROM detil_penjualan WHERE id_jual IS NULL";
        $data = $this->db->query($subtotal)->row_array();
        echo json_encode($data);
    }

    public function simpanPenjualan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $kodeinvoice = "POS" . date('YmdHis');
        $this->db->select("RIGHT (penjualan.kode_jual, 7) as kode_jual", false);
        $this->db->order_by("kode_jual", "DESC");
        $this->db->limit(1);
        $query = $this->db->get('penjualan');
        // Check if there are any results
        // if ($query->num_rows() > 0) {
        //     $result = $query->row();  // Fetch the first row as an object
        //     die(print_r($result, true));  // Output the result for debugging
        // } else {
        //     die('No data found');
        // }

        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode_jual) + 1;
        } else {
            $kode = 1;
        }
        
        $kodejual = str_pad($kode, 7, "0", STR_PAD_LEFT);
        // die($kodejual);

        $kodepenjualan = "KJ-" . $kodejual;
        $kembalian = $this->input->post('kembali');
        $bayar = $this->input->post('bayar');
        $metode = $this->input->post('metode');
        $total = $bayar - $kembalian;
        $coaCash = $this->input->post('coa_cash');
        $coaKredit = $this->input->post('coa_kredit');
        $coaTransfer = $this->input->post('coa_transfer');
        if ($metode == 'Cash') {
            $coaD = $coaCash;
        } elseif ($metode == 'Transfer') {
            $coaD = $coaTransfer;
        } else {
            $coaD = $coaKredit;
        }
        if ($kembalian < 0) {
            $kembalian = 0;
        }
        // die(var_dump($this->input->post()));
        // log_message('debug', 'POST Data: ' . print_r($this->input->post(), true));
        $data = array(
            'id_user'     => $this->input->post('kasir'),
            'id_cs'       => $this->input->post('cus'),
            'kode_jual'   => $kodepenjualan,
            'invoice'     => $kodeinvoice,
            'method'      => $metode,
            'bayar'       => $bayar,
            'kembali'     => $kembalian,
            'ppn'         => $this->input->post('nominal_ppn'),
            'tgl'         => date('Y-m-d H:i:s'),
            'is_active'   => 1,
            'cabang'      => $this->session->cabang
        );
        // die(var_dump($data));
        $this->db->insert('penjualan', $data);
        $idjual= $this->db->insert_id();
        // die("Error");
        // die(var_dump($idjual));
        //insert ke table kas
        $this->db->select("RIGHT (kas.kode_kas, 7) as kode_kas", false);
        $this->db->order_by("kode_kas", "DESC");
        $this->db->limit(1);
        $query = $this->db->get('kas');
        // die(var_dump($query));
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode_kas) + 1;
        } else {
            $kode = 1;
        }
        $kodeks = str_pad($kode, 7, "0", STR_PAD_LEFT);
        $kodekas = "KS-" . $kodeks;
        $nominal = $bayar - $kembalian;
        $kas = array(
            'id_user'     => $this->input->post('kasir'),
            'kode_kas'    => $kodekas,
            'tanggal'     => date('Y-m-d H:i:s'),
            'jenis'       => 'Pemasukan',
            'keterangan'  => 'Penjualan',
            'nominal'     => $nominal,
            'cabang'      => $this->session->cabang,
            'kode_trans'  =>   $kodepenjualan,
        );
        $this->db->insert('kas', $kas);
        
        

        //---------------- insert ke jurnal umum debet-----------------------
        // $journal = array(
        //     'vcIDJournal'       => $kodepenjualan,
        //     'dtJournal'         => date('Y-m-d H:i:s'),
        //     'vcCOAJournal'      => $coaD,
        //     'cuJournalDebet'    => $total,
        //     'cuJournalCredit'   => '0',
        //     'vcJournalDesc'     => 'Transaksi Penjualan',
        //     'itPostJournal'     =>  '1',
        //     'vcUserID'          => $this->session->username,
        // );
        // $this->db->insert('tbl_journal', $journal);

        //-------------------------------------------------------------

        if ($this->input->post('nominal_ppn') != 0) {

            $this->db->select("RIGHT (pajak_ppn.kode_pajak, 7) as kode_pajak", false);
            $this->db->order_by("kode_pajak", "DESC");
            $this->db->limit(1);
            $query = $this->db->get('pajak_ppn');
            $pajak_ppn = $this->input->post('nominal_ppn');

            if ($query->num_rows() <> 0) {
                $data = $query->row();
                $kode = intval($data->kode_pajak) + 1;
            } else {
                $kode = 1;
            }
            $kodeppn = str_pad($kode, 7, "0", STR_PAD_LEFT);
            $kode_pajak = "PPN-" . $kodeppn;
            $ppn = array(
                'kode_pajak' => $kode_pajak,
                'jenis'      => 'PPN Keluaran',
                'nominal'    => $pajak_ppn,
                'tanggal'    => date('Y-m-d H:i:s'),
                'keterangan' => 'Penjualan',
                'id_user'    => $this->input->post('kasir'),
            );

            $this->db->insert('pajak_ppn', $ppn);
        }


        //------------------update stok
        $itemJual = $this->db->query("select id_barang,qty_jual from detil_penjualan where id_jual is null and id_user = " . $this->session->id)->result();
        $sqlstok = '';
        foreach ($itemJual as $ds) {
            $sqlstok = "update barang set stok = stok - " . $ds->qty_jual . " where id_barang = '" . $ds->id_barang . "'; ";
            $this->db->query($sqlstok);
        }


        //-----------------------------

        $sql = "update detil_penjualan set id_jual = '$idjual' where id_jual is null and id_user = " . $this->session->id;
        $this->db->query($sql);
        $kembali = $this->input->post('kembali');

        //--------------------jurnal kredit-----------
        // $sql = "select detil_penjualan.id_detil_jual,detil_penjualan.subtotal,detil_penjualan.qty_jual,detil_penjualan.id_barang, kategori.coa_persediaan, kategori.coa_penjualan, kategori.coa_hpp, detil_penjualan.hpp from detil_penjualan inner join barang on barang.id_barang=detil_penjualan.id_barang inner join kategori on kategori.id_kategori=barang.id_kategori where detil_penjualan.id_jual='$idjual'";
        // $brg = $this->db->query($sql)->result();
        // foreach ($brg as $b) {
            // $journal = array(
            //     'vcIDJournal'       => $kodepenjualan,
            //     'dtJournal'         => date('Y-m-d H:i:s'),
            //     'vcCOAJournal'      => $b->coa_penjualan,
            //     'cuJournalDebet'    => '0',
            //     'cuJournalCredit'   => $b->subtotal,
            //     'vcJournalDesc'     => 'Transaksi Penjualan',
            //     'itPostJournal'     =>  '1',
            //     'vcUserID'          => $this->session->username,
            // );
            // $this->db->insert('tbl_journal', $journal);
            //----------------------------- get hpp-------------------
            // $vhpp = $b->hpp;

            // $journal = array(
            //     'vcIDJournal'       => $kodepenjualan,
            //     'dtJournal'         => date('Y-m-d H:i:s'),
            //     'vcCOAJournal'      => $b->coa_hpp,
            //     'cuJournalDebet'    => $vhpp * $b->qty_jual,
            //     'cuJournalCredit'   => '0',
            //     'vcJournalDesc'     => 'Transaksi Penjualan',
            //     'itPostJournal'     =>  '1',
            //     'vcUserID'          => $this->session->username,
            // );
            // $this->db->insert('tbl_journal', $journal);
            // $journal = array(
            //     'vcIDJournal'       => $kodepenjualan,
            //     'dtJournal'         => date('Y-m-d H:i:s'),
            //     'vcCOAJournal'      => $b->coa_persediaan,
            //     'cuJournalDebet'    => '0',
            //     'cuJournalCredit'   => $vhpp * $b->qty_jual,
            //     'vcJournalDesc'     => 'Transaksi Penjualan',
            //     'itPostJournal'     =>  '1',
            //     'vcUserID'          => $this->session->username,
            // );
            // $this->db->insert('tbl_journal', $journal);

        //}

        if ($kembali < 0 || $metode == "Kredit") {
            $jml_piutang = abs($kembali);
            $piutang = array(
                'id_jual'        => $idjual,
                'tgl_piutang'    => date('Y-m-d H:i:s'),
                'jml_piutang'    => $jml_piutang,
                'bayar'          => 0,
                'sisa'           => $jml_piutang,
                'status'         => 'Belum Lunas',
                'jatuh_tempo'    => $this->input->post('tempo'),
                'cabang'         => $this->session->userdata('cabang')
            );
            $this->db->insert('piutang', $piutang);
        }
    }

    function  fixinghpp()
    {
        $dt = $this->db->query('SELECT penjualan.kode_jual, penjualan.method, detil_penjualan.id_barang, detil_penjualan.id_detil_jual, detil_penjualan.harga_item, detil_penjualan.qty_jual, detil_penjualan.subtotal, detil_penjualan.hpp from penjualan inner join detil_penjualan on penjualan.id_jual = detil_penjualan.id_jual where hpp=0')->result();
        if (count($dt) > 0) {
            $i = 1;
            foreach ($dt as $rs) {
                if ($i < 50) {
                    $this->db->query("delete from tbl_journal where vcIDJournal ='" . $rs->kode_jual . "' and vcCOAJournal in ('11310-000','41210-000')");
                    //get hpp
                    //----------------------------- get hpp-------------------
                    $sql = "SELECT SUM(subtotal)/ SUM(qty_beli) as hpp FROM detil_pembelian WHERE id_barang=" . $rs->id_barang;
                    $hpp = $this->db->query($sql)->row();
                    $vhpp = 0;
                    if (isset($hpp->hpp)) {
                        if ($hpp->hpp != '') {
                            $vhpp = $hpp->hpp;
                        } else {
                            $hpp = $this->db->query('select harga_beli from barang where id_barang=' . $rs->id_barang)->row();
                            $vhpp = $hpp->harga_beli;
                        }
                    } else {
                        $hpp = $this->db->query('select harga_beli from barang where id_barang=' . $rs->id_barang)->row();
                        $vhpp = $hpp->harga_beli;
                    }

                    // $journal = array(
                    //     'vcIDJournal'       => $rs->kode_jual,
                    //     'dtJournal'         => date('Y-m-d H:i:s'),
                    //     'vcCOAJournal'      => '41210-000',
                    //     'cuJournalDebet'    => $vhpp * $rs->qty_jual,
                    //     'cuJournalCredit'   => '0',
                    //     'vcJournalDesc'     => 'Transaksi Penjualan',
                    //     'itPostJournal'     =>  '1',
                    //     'vcUserID'          => $this->session->username,
                    // );
                    // $this->db->insert('tbl_journal', $journal);
                    // $journal = array(
                    //     'vcIDJournal'       => $rs->kode_jual,
                    //     'dtJournal'         => date('Y-m-d H:i:s'),
                    //     'vcCOAJournal'      => '11310-000',
                    //     'cuJournalDebet'    => '0',
                    //     'cuJournalCredit'   => $vhpp * $rs->qty_jual,
                    //     'vcJournalDesc'     => 'Transaksi Penjualan',
                    //     'itPostJournal'     =>  '1',
                    //     'vcUserID'          => $this->session->username,
                    // );
                    // $this->db->insert('tbl_journal', $journal);

                    $this->db->where('id_detil_jual', $rs->id_detil_jual);
                    $this->db->update('detil_penjualan', array('hpp' => $vhpp));
                }
                $i++;
            }
        }
    }
    public function detilItemJual($id)
    {
        $sql = "SELECT a.id_detil_jual, b.barcode, b.id_barang, b.nama_barang, b.harga_jual, a.qty_jual, a.diskon, 
		a.subtotal, a.hpp FROM detil_penjualan a, barang b WHERE b.id_barang = a.id_barang AND a.id_detil_jual = '$id'";
        $data = $this->model->General($sql)->row_array();
        echo json_encode($data);
    }
    public function detilServisJual($id)
    {
        $sql = "SELECT a.id_detil_jual, b.kode, b.id_servis, b.nama_servis, a.harga_item, a.qty_jual, 
		a.subtotal FROM detil_penjualan a, servis b WHERE b.id_servis = a.id_servis AND a.id_detil_jual = '$id'";
        $data = $this->model->General($sql)->row_array();
        echo json_encode($data);
    }

    public function editServisJual($id, $harga, $subtotal)
    {
        $data = array(
            'harga_item' => $harga,
            'subtotal'   => $subtotal,
        );
        return $this->db->set($data)->where('id_detil_jual', $id)->update('detil_penjualan');
    }

    function GetItemPenjualan($id, $operator)
    {
        $this->db->select('id_detil_jual,harga_item,qty_jual,subtotal');
        $this->db->from('detil_penjualan');
        $this->db->where('id_barang', $id);
        $this->db->where('id_user', $operator);
        $this->db->where('id_jual is NULL');
        return $this->db->get();
    }

    function UpdateDetail($data, $id)
    {
        $this->db->where('id_detil_jual', $id);
        $this->db->update('detil_penjualan', $data);
        //echo $this->db->last_query();
        //die;
    }

    public function Peg_kasir($cabang)
    {

        $this->db->select("*");
        $this->db->from('user');
        $this->db->where('cabang', $cabang);
        $this->db->order_by('nama_lengkap');
        return $this->db->get();
    }

    public function Daftar_penjualan($bln="",$thn="")
    {
        if ($bln == "") {$bln = date('n');}
        if ($thn == "") {$thn = date('Y');}
        $this->db->select("tbl_anggota.nama,user.nama_lengkap,penjualan.id_jual,penjualan.kode_jual,invoice,method,sum(qty_jual) as qty,sum(diskon) as diskon,sum(subtotal) as total, tgl");
        $this->db->from('penjualan');
        $this->db->where('month(tgl)',$bln);
        $this->db->where('year(tgl)',$thn);        
        $this->db->join('detil_penjualan', 'penjualan.id_jual=detil_penjualan.id_jual');
        $this->db->join('user', 'user.id_user=penjualan.id_user');
        $this->db->join('tbl_anggota', 'tbl_anggota.id = penjualan.id_cs', 'LEFT');
        $this->db->order_by('tgl', 'DESC');
        $this->db->group_by('tbl_anggota.nama,user.nama_lengkap,penjualan.id_jual,invoice,method,tgl,penjualan.kode_jual');
        return $this->db->get();
    }

    public function Daftar_penjualan_id($id)
    {

        $this->db->select("*");
        $this->db->from('penjualan');
        $this->db->where('id_jual', $id);
        $this->db->order_by('invoice', 'DESC');
        return $this->db->get();
    }

    public function Daftar_penjualan_tanggal_kasir($tgl_awal, $tgl_akhir, $kasir, $method='Cash')
    {

        $akh =  date('Y-m-d', strtotime($tgl_akhir . ' +1 days'));
        $this->db->select("*");
        $this->db->from('penjualan');
        $this->db->where('tgl >=', $tgl_awal);
        $this->db->where('tgl <=', $akh);
        $this->db->where('id_user', $kasir);
        $this->db->where('method',$method);
        $this->db->order_by('tgl', 'DESC');
        return $this->db->get();
    }

    public function Daftar_penjualan_tanggal($tgl_awal, $tgl_akhir, $method='Cash')
    {

        $akh =  date('Y-m-d', strtotime($tgl_akhir . ' +1 days'));
        $this->db->select("*");
        $this->db->from('penjualan');
        $this->db->where('tgl >=', $tgl_awal);
        $this->db->where('tgl <=', $akh);
        $this->db->where('method',$method);
        $this->db->order_by('tgl', 'DESC');
        return $this->db->get();
    }

    public function Daftar_pegawai($id)
    {

        $this->db->select("*");
        $this->db->from('tbl_anggota');
        $this->db->where('id', $id);
        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }

    public function Peg_kasir_id($id)
    {

        $this->db->select("*");
        $this->db->from('user');
        $this->db->where('id_user', $id);
        $this->db->order_by('id_user');
        return $this->db->get();
    }

    public function Detail_penjualan($id,$idbarang="")
    {
        //  $this->db->select(' b.nama_barang');
        // $this->db->from('detil_penjualan a, barang b');
        // $this->db->where('a.id_jual', $id);
        // $this->db->where('a.id_barang = b.id_barang');

        $this->db->select("*");
        $this->db->from('detil_penjualan a, barang b');
        $this->db->where('a.id_jual', $id);
        $this->db->where('a.id_barang = b.id_barang');
        if ($idbarang != "") {
            $this->db->where('id_barang', $idbarang);
        }
        $this->db->order_by('id_jual');
        return $this->db->get();
    }

    public function Detail_penjualan_by_tgl($id, $awal, $akhir)
    {

        $this->db->select("*");
        $this->db->from('view_detil_penjualan');
        $this->db->where('id_jual', $id);
        $this->db->order_by('id_jual');
        return $this->db->get();
    }

    public function Detail_penjualan_barang_by_tgl($id, $awal, $akhir)
    {

        $this->db->select("*");
        $this->db->from('view_detil_penjualan');
        $this->db->where('id_barang', $id);
        $this->db->where('tgl >=', $awal);
        $this->db->where('tgl <=', $akhir);
        $this->db->order_by('id_jual');
        return $this->db->get();
    }

    public function Detail_penjualan2($id)
    {

        $this->db->select("barang.nama_barang,detil_penjualan.*");
        $this->db->from('detil_penjualan');
        $this->db->join('barang', 'barang.id_barang=detil_penjualan.id_barang', 'LEFT');
        $this->db->where('id_jual', $id);
        $this->db->order_by('id_jual');
        return $this->db->get();
    }

    public function Report_penjualan_id($id, $awal, $akhir)
    {

        $this->db->select("*");
        $this->db->from('detil_penjualan');
        $this->db->where('id_kategori', $id);
        $this->db->where('tgl >=', $awal);
        $this->db->where('tgl <=', $akhir);
        $this->db->order_by('tgl');
        return $this->db->get();
    }

    public function Report_penjualan_all($awal, $akhir)
    {

        $this->db->select("*");
        $this->db->from('detil_penjualan');
        $this->db->where('tgl >=', $awal);
        $this->db->where('tgl <=', $akhir);
        $this->db->order_by('tgl');
        return $this->db->get();
    }

    public function Detail_namabarang($id)
    {
        // SELECT b.nama_barang FROM detil_penjualan a, barang b WHERE a.id_jual = '43192' AND a.id_barang = b.id_barang
        $this->db->select(' b.nama_barang');
        $this->db->from('detil_penjualan a, barang b');
        $this->db->where('a.id_jual', $id);
        $this->db->where('a.id_barang = b.id_barang');
        return $this->db->get();
    }

    public function Detail_barang($id)
    {

        $this->db->select("*");
        $this->db->from('barang');
        $this->db->where('id_barang', $id);
        $this->db->order_by('id_barang');
        return $this->db->get();
    }

    public function Barang_all()
    {

        $this->db->select("*");
        $this->db->from('barang');
        $this->db->order_by('id_barang');
        return $this->db->get();
    }

    public function Satuan_item($id)
    {

        $this->db->select('*');
        $this->db->from('satuan');
        $this->db->where('id_satuan', $id);
        return $this->db->get();
    }

    public function Retur_jual($id)
    {

        $this->db->select("*");
        $this->db->from('detil_penjualan');
        $this->db->where('id_jual', $id);
        $this->db->order_by('id_detil_jual');
        return $this->db->get();
    }

    public function Detail_retur($id)
    {

        $this->db->select("*");
        $this->db->from('tbl_retur');
        $this->db->where('id_jual', $id);
        //$this->db->where('status=',0);

        return $this->db->get();
    }

    public function View_retur($id)
    {

        $this->db->select("*");
        $this->db->from('view_retur_penjualan');
        $this->db->where('id_jual', $id);
        $this->db->where('status', 0);
        return $this->db->get();
    }

    public function nota_toko($id)
    {

        $this->db->select("*");
        $this->db->from('penjualan');
        $this->db->where('id_jual', $id);
        return $this->db->get();
    }

    public function Jumlah_penjualan($id, $brg)
    {

        $this->db->select("*");
        $this->db->from('detil_penjualan');
        $this->db->where('id_jual', $id);
        $this->db->where('id_barang', $brg);
        $this->db->order_by('id_jual');
        return $this->db->get();
    }

    public function Jumlah_item_tgl($id, $tgl)
    {

        $this->db->select('sum(qty_jual) as qty_jual');
        $this->db->from('detil_penjualan');
        $this->db->where('id_barang', $id);
        $this->db->where('tgl <=', $tgl);
        return $this->db->get();
    }

    public function Piutang_jual($id)
    {
        $this->db->select("*");
        $this->db->from('piutang');
        $this->db->where('id_jual', $id);
        return $this->db->get();
    }

    public function total_itemjual($id)
    {
        $this->db->select("sum(subtotal) as jml");
        $this->db->from('detil_penjualan');
        $this->db->where('id_jual', $id);
        return $this->db->get();
    }

    public function Kategori($id)
    {

        $this->db->select("*");
        $this->db->from('kategori');
        $this->db->where('id_kategori', $id);
        return $this->db->get();
    }

    public function Insert_retur($data)
    {
        $this->db->insert('tbl_retur', $data);
        return $this->db->insert_id();   
    }

    public function Delete_retur($id_r)
    {
        $this->db->where('id_retur', $id_r);
        $this->db->Delete('tbl_retur');
    }

    public function Update_retur($id, $data)
    {
        $this->db->where('id_retur', $id);
        $this->db->update('tbl_retur', $data);
    }

    public function Update_stok_retur($id, $data)
    {
        $this->db->where('id_barang', $id);
        $this->db->update('barang', $data);
    }

    public function Update_detail_jual($id, $data)
    {
        $this->db->where('id_detil_jual', $id);
        $this->db->update('detil_penjualan', $data);
    }

    public function Insert_jurnal_retur($data)
    {
        $this->db->insert('tbl_journal', $data);
    }

    public function Update_piutang_jual($id, $data)
    {
        $this->db->where('id_jual', $id);
        $this->db->update('piutang', $data);
    }

    public function ReplaceKas($kode,$jml) {
        $data['nominal'] = $jml;
        $this->db->where('kode_trans',$kode);
        $this->db->update('kas',$data);
    }
}
