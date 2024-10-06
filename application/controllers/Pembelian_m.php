<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian_m extends CI_Model
{

    protected $table = 'pembelian';
    protected $primary = 'id_beli';

    public function getAllData()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function getDetilBeli()
    {
        $sql = "SELECT a.id_detil_beli, b.barcode, b.nama_barang, b.harga_beli, b.harga_jual, a.qty_beli, a.subtotal FROM detil_pembelian a, barang b WHERE b.id_barang = a.id_barang AND a.id_beli IS NULL order by id_detil_beli DESC";
        return $this->db->query($sql)->result_array();
    }

    public function addItem($id, $qty, $subtotal, $jual, $beli)
    {
        $this->db->select("RIGHT (detil_pembelian.kode_detil_beli, 7) as kode_detil_beli", false);
        $this->db->order_by("kode_detil_beli", "DESC");
        $this->db->limit(1);
        $query = $this->db->get('detil_pembelian');

        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode_detil_beli) + 1;
        } else {
            $kode = 1;
        }
        $kodebeli = str_pad($kode, 7, "0", STR_PAD_LEFT);
        $detilbeli = "DB-" . $kodebeli;
        $data = array(
            'id_barang'           => $id,
            'kode_detil_beli'     => $detilbeli,
            'hrg_beli'            => $beli,
            'hrg_jual'            => $jual,
            'qty_beli'            => $qty,
            'subtotal'            => $subtotal,

        );
        $this->db->insert('detil_pembelian', $data);
        // $sqlstok = "select stok from barang where id_barang = '$id'";
        $sqlstok = "select stok from gudang where id_barang = '$id'";
        $stok = implode($this->db->query($sqlstok)->row_array());
        $hasil = $stok + $qty;
        $barang = array(
            'harga_beli'  => $beli,
            'harga_jual'  => $jual,
            // 'stok'        => $hasil
        );
        $gudang = array(
            'stok' => $hasil
        );

        $this->db->set($barang)->where('id_barang', $id)->update('barang');
        $this->db->set($gudang)->where('id_barang', $id)->update('gudang');
        $sql = "SELECT sum(subtotal) as subtotal FROM detil_pembelian WHERE id_beli IS NULL";
        $data = $this->db->query($sql)->row_array();
        echo json_encode($data);
    }

    public function hapusDetail($id)
    {
        $getDetil = $this->db->get_where('detil_pembelian', ['id_detil_beli' => $id])->row_array();
        $qty = $getDetil['qty_beli'];
        $idBrg = $getDetil['id_barang'];
        // $getBrg = $this->db->get_where('barang', ['id_barang' => $idBrg])->row_array();
        $getBrg = $this->db->get_where('gudang', ['id_barang' => $idBrg])->row_array();
        $stokBrg = $getBrg['stok'];
        $stok = $stokBrg - $qty;
        // $updateStok = $this->db->set(array('stok' => $stok))->where('id_barang', $idBrg)->update('barang');
        $updateStok = $this->db->set(array('stok' => $stok))->where('id_barang', $idBrg)->update('gudang');

        $sql = "delete from detil_pembelian where id_detil_beli = '$id'";
        $this->db->query($sql);

        $totalbeli = "SELECT sum(subtotal) as subtotalbeli FROM detil_pembelian WHERE id_beli IS NULL";
        $data = $this->db->query($totalbeli)->row_array();
        echo json_encode($data);
    }

    public function simpanPembelian()
    {
        $this->db->select("RIGHT (pembelian.kode_beli, 7) as kode_beli", false);
        $this->db->order_by("kode_beli", "DESC");
        $this->db->limit(1);
        $query = $this->db->get('pembelian');

        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode_beli) + 1;
        } else {
            $kode = 1;
        }
        $kodebeli = str_pad($kode, 7, "0", STR_PAD_LEFT);
        $beli = "PB-" . $kodebeli;
        $kembalian = $this->input->post('kembali');
        $bayar = $this->input->post('bayar');
        if ($this->input->post('metode') == '21111-000') {
            $metode = 'Kredit';
        } else {
            $metode = 'Cash';
        }
        $total = $bayar - $kembalian;
        $coaD = $this->input->post('coad');
        $coaK = $this->input->post('coak');

        if ($kembalian < 0) {
            $kembalian = 0;
        }

        $data = array(
            'id_supplier'    => htmlspecialchars($this->input->post('sup'), true),
            'id_user'        => htmlspecialchars($this->input->post('kasir'), true),
            'kode_beli'      => $beli,
            'tgl_faktur'     => htmlspecialchars($this->input->post('tgl_faktur'), true),
            'faktur_beli'    => htmlspecialchars($this->input->post('no_faktur'), true),
            'diskon'         => htmlspecialchars($this->input->post('diskon1'), true),
            'method'         => $metode,
            'total'          => htmlspecialchars($this->input->post('grandtotal'), true),
            'bayar'          => htmlspecialchars($bayar, true),
            'kembali'        => htmlspecialchars($kembalian, true),
            'tgl'            => date('Y-m-d H:i:s'),
            'is_active'      => 1,
        );
        $this->db->insert('pembelian', $data);

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
        $nominal = $bayar - $kembalian;
        $kas = array(
            'id_user'     => htmlspecialchars($this->input->post('kasir'), true),
            'kode_kas'    => $kodekas,
            'tanggal'     => date('Y-m-d H:i:s'),
            'jenis'       => 'Pengeluaran',
            'keterangan'  => 'Pembelian',
            'nominal'     => $nominal,
        );
        $this->db->insert('kas', $kas);

        //-----------------insert data ke journal umum ------------------------------     


        $journal = array(
            'vcIDJournal'       => $beli,
            'dtJournal'         => date('Y-m-d H:i:s'),
            'vcCOAJournal'      => $this->input->post('metode'),
            'cuJournalDebet'    => '0',
            'cuJournalCredit'   => $total,
            'vcJournalDesc'     => 'Transaksi Pembelian',
            'itPostJournal'     =>  '1',
            'vcUserID'          => $this->session->username,
        );
        $this->db->insert('tbl_journal', $journal);

        //---------------------------------------------------------------------------

        $idbeli = "select max(id_beli) as id_beli from pembelian";
        $id = implode($this->db->query($idbeli)->row_array());
        $sql = "update detil_pembelian set id_beli = '$id' where id_beli is null";
        $this->db->query($sql);
        $kembali = $this->input->post('kembali');

        if ($kembali < 0 || $metode == "Kredit") {
            $jml_hutang = abs($kembali);
            $hutang = array(
                'id_beli'       => $id,
                'tgl_hutang'    => date('Y-m-d H:i:s'),
                'jml_hutang'    => $jml_hutang,
                'bayar'         => 0,
                'sisa'          => $jml_hutang,
                'status'        => 'Belum Lunas',
                'jatuh_tempo'   => $this->input->post('tempo'),
            );
            $this->db->insert('hutang', $hutang);
        }
        $this->db->select('sum(subtotal) as total, kategori.coa_persediaan, detil_pembelian.id_barang, qty_beli');
        $this->db->from('detil_pembelian');
        $this->db->join('barang', 'detil_pembelian.id_barang = barang.id_barang');
        $this->db->join('kategori', 'kategori.id_kategori = barang.id_kategori');
        $this->db->where('detil_pembelian.id_beli', $id);
        $this->db->group_by('kategori.coa_persediaan');
        $ds = $this->db->get()->result();

        foreach ($ds as $d) {
            $journal = array(
                'vcIDJournal'       => $beli,
                'dtJournal'         => date('Y-m-d H:i:s'),
                'vcCOAJournal'      => $d->coa_persediaan,
                'cuJournalDebet'    => $d->total,
                'cuJournalCredit'   => '0',
                'vcJournalDesc'     => 'Transaksi Pembelian',
                'itPostJournal'     =>  '1',
                'vcUserID'          => $this->session->username,
            );
            $this->db->insert('tbl_journal', $journal);
            $getGudang = $this->db->get_where('gudang',['id_barang'=>$d->id_barang])->result();
            if (count($getGudang) > 0) {
                $this->db->query('update gudang set stok = stok + ' . $d->qty_beli . " where id_barang = " . $d->id_barang);
            } else {
                $this->db->query('insert into gudang (id_barang,stok,cabang) values (' . $d->id_barang . ',' . $d->qty_beli . ",1)");
            }
        }
    }

    public function editDetail($id, $qty, $hakhir)
    {
        $data = array(
            'qty_beli'     => $qty,
            'subtotal'     => $hakhir,
        );
        return $this->db->set($data)->where('id_detil_beli', $id)->update('detil_pembelian');
    }

    public function Peg_kasir($cabang)
    {

        $this->db->select("*");
        $this->db->from('user');
        $this->db->where('cabang', $cabang);
        $this->db->order_by('nama_lengkap');
        return $this->db->get();
    }

    public function Daftar_pembelian(){
        
        $this->db->select("*");
		$this->db->from('pembelian');
		$this->db->order_by('kode_beli','DESC');
		return $this->db->get();
    }

    public function Daftar_pembelian_id($id){
        
        $this->db->select("*");
		$this->db->from('pembelian');
        $this->db->where('id_beli', $id);
		$this->db->order_by('kode_beli','DESC');
		return $this->db->get();
    }

    public function Daftar_supplier_id($id){
        
        $this->db->select("*");
		$this->db->from('supplier');
        $this->db->where('id_supplier', $id);
		return $this->db->get();
    }

    public function Daftar_supplier(){
        
        $this->db->select("*");
		$this->db->from('supplier');
        $this->db->order_by('nama_supplier');
       	return $this->db->get();
    }

    public function Jumlah_item_id($id){
        
        $this->db->select('sum(qty_beli) as qty_beli');
		$this->db->from('detil_pembelian');
        $this->db->where('id_beli', $id);
		return $this->db->get();
    }

    public function Detil_pembelian($id){
        
        $this->db->select("*");
		$this->db->from('detil_pembelian');
		$this->db->where('id_beli', $id);
		return $this->db->get();
    }

    public function Jumlah_pembelian($id,$brg){
        
        $this->db->select("*");
		$this->db->from('detil_pembelian');
		$this->db->where('id_beli',$id);
        $this->db->where('id_barang',$brg);
        $this->db->order_by('id_beli');
		return $this->db->get();
    }

    public function Daftar_barang(){
        
        $this->db->select("*");
		$this->db->from('barang');
		return $this->db->get();
    }

    public function Daftar_barang_id($id){
        
        $this->db->select("*");
		$this->db->from('barang');
        $this->db->where('id_barang', $id);
		return $this->db->get();
    }

    public function Retur_beli($id){
        
        $this->db->select("*");
		$this->db->from('detil_pembelian');
		$this->db->where('id_beli',$id);
        $this->db->order_by('id_detil_beli');
		return $this->db->get();
    }

    public function Detail_retur($id){
        
        $this->db->select("*");
		$this->db->from('tbl_retur_pembelian');
		$this->db->where('id_beli',$id);
        $this->db->where('status',0);
       	return $this->db->get();
    }

    public function Detail_v_pembelian($id){
        
        $this->db->select("*");
		$this->db->from('view_detil_pembelian');
		$this->db->where('id_beli',$id);
        $this->db->order_by('id_beli');
		return $this->db->get();
    }

    public function Report_pembelian_id($id,$awal,$akhir){
        
        $this->db->select("*");
		$this->db->from('pembelian');
		$this->db->where('id_supplier',$id);
        $this->db->where('tgl >=',$awal);
        $this->db->where('tgl <=',$akhir);
        $this->db->order_by('faktur_beli');
		return $this->db->get();
    }

    public function Report_pembelian_all($awal,$akhir){
        
        $this->db->select("*");
		$this->db->from('pembelian');
        $this->db->where('tgl >=',$awal);
        $this->db->where('tgl <=',$akhir);
        $this->db->order_by('faktur_beli');
		return $this->db->get();
    }

    public function Report_detail($beli_id){
        
        $this->db->select("*");
		$this->db->from('view_detil_pembelian');
        $this->db->where('id_beli',$beli_id) ;
        $this->db->order_by('tgl_pembelian','faktur_beli');
		return $this->db->get();
    }

    public function Insert_retur($data){
		$this->db->insert('tbl_retur_pembelian', $data);
	}

    public function Delete_retur($id_r) 
	{
		$this->db->where('id_retur', $id_r);
		$this->db->Delete('tbl_retur_pembelian'); 
	}
    
    public function Update_retur($id,$data)
	{
		$this->db->where('id_retur',$id);
		$this->db->update('tbl_retur_pembelian', $data);
	}

    public function Update_stok_retur($id,$data)
	{
		$this->db->where('id_barang',$id);
		$this->db->update('barang', $data);
	}

    public function Update_detail_beli($id,$data)
	{
		$this->db->where('id_detil_beli',$id);
		$this->db->update('detil_pembelian', $data);
	}

    public function Update_pembelian($id,$data)
	{
		$this->db->where('id_beli',$id);
		$this->db->update('detil_pembelian', $data);
	}

    public function Update_beli($id,$data)
	{
		$this->db->where('id_beli',$id);
		$this->db->update('pembelian', $data);
	}

    public function Insert_jurnal_retur($data){
        $this->db->insert('tbl_journal', $data);
    }

}
