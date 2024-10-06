<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gudang_m extends CI_Model
{

    protected $table = 'gudang';
    protected $primary = 'id_gudang';

    public function getAllData($id = null)
    {
        if ($id == null) {
            $sql = "SELECT a.id_barang, b.id_gudang, a.nama_barang, a.barcode, a.gambar, c.satuan, b.stok, a.stok as stok_toko FROM barang a LEFT JOIN gudang b ON a.id_barang = b.id_barang  INNER JOIN satuan c ON c.id_satuan = a.id_satuan";
            return $this->db->query($sql)->result_array();
        } else {
            $sql = "SELECT a.id_barang, b.id_gudang, a.nama_barang, a.barcode, a.gambar, c.satuan, b.stok, a.stok as stok_toko FROM barang a LEFT JOIN gudang b ON a.id_barang = b.id_barang  INNER JOIN satuan c ON c.id_satuan = a.id_satuan WHERE a.id_barang = '$id'";
            return $this->db->query($sql)->row_array();
        }
    }

    public function transferKeluar($id)
    {
        $ids = decrypt_url($id);
        $success = false;

        $getGudang = $this->db->get_where($this->table, ['id_barang' => $ids,'cabang'=>1])->row();
        $stokGudang = $this->input->post('stok_gudang');
        $stokToko = $this->input->post('stok_toko');
        $jumlahTransfer = $this->input->post('stok');

        if ($jumlahTransfer <= $stokGudang) {

            $hasilStokGudang = $stokGudang - $jumlahTransfer;
            $hasilStokToko = $stokToko + $jumlahTransfer;
            if (isset($getGudang)) {
                $this->db->set(['stok' => $hasilStokGudang])->where('id_barang', $ids)->update($this->table);
            } else {
                $this->db->insert('gudang',['id_barang'=>$ids,'stok'=>$hasilStokGudang,'cabang'=>1]);
            }
            

            $this->db->set(['stok' => $hasilStokToko])->where('id_barang', $ids)->update('barang');
            $success = true;
        }
        return $success;
    }
    public function transferMasuk($id)
    {
        $ids = decrypt_url($id);
        $success = false;

        $getGudang = $this->db->get_where($this->table, ['id_barang' => $ids,'cabang'=>1])->row();
        $stokGudang = $this->input->post('stok_gudang');
        $stokToko = $this->input->post('stok_toko');
        $jumlahTransfer = $this->input->post('stok');

        if ($jumlahTransfer <= $stokToko) {

            $hasilStokGudang = $stokGudang + $jumlahTransfer;
            $hasilStokToko = $stokToko - $jumlahTransfer;
            if (isset($getGudang)) {
                $this->db->set(['stok' => $hasilStokGudang])->where('id_barang', $ids)->update($this->table);
            } else {
                $this->db->insert('gudang',['id_barang'=>$ids,'stok'=>$hasilStokGudang,'cabang'=>1]);
            }
            
            $this->db->set(['stok' => $hasilStokToko])->where('id_barang', $ids)->update('barang');
            $success = true;
        }
        return $success;
    }
}
