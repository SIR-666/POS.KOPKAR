<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Posting_m extends CI_Model
{

    function GetProfile()
    {
        $this->db->where('id_toko', $this->session->cabang);
        return $this->db->get('profil_perusahaan');
    }

    function PenjualanDebet($bulan, $tahun)
    {
        $this->db->select('penjualan.method, SUM(detil_penjualan.subtotal) AS jml, tbl_anggota.`nama`, penjualan.`id_cs`');
        $this->db->from('penjualan');
        $this->db->join('detil_penjualan', 'penjualan.id_jual = detil_penjualan.id_jual');
        $this->db->join('tbl_anggota', 'penjualan.id_cs = tbl_anggota.`id`', "LEFT");
        $this->db->where('month(penjualan.tgl)', $bulan);
        $this->db->where('year(penjualan.tgl)', $tahun);
        $this->db->group_by('penjualan.method,tbl_anggota.`nama`, penjualan.`id_cs`');
        return $this->db->get();
    }

    function PenjualanKredit($bulan, $tahun)
    {
        $this->db->select('SUM(detil_penjualan.subtotal) AS jml, kategori.coa_penjualan, penjualan.method, kategori.`kategori` ,tbl_anggota.`nama`, penjualan.`id_cs`');
        $this->db->from('penjualan');
        $this->db->join('detil_penjualan', 'penjualan.id_jual = detil_penjualan.id_jual');
        $this->db->join('barang', 'barang.id_barang=detil_penjualan.id_barang');
        $this->db->join('kategori', 'kategori.id_kategori=barang.id_kategori');
        $this->db->join('tbl_anggota', 'penjualan.id_cs = tbl_anggota.`id`', "LEFT");
        $this->db->where('month(penjualan.tgl)', $bulan);
        $this->db->where('year(penjualan.tgl)', $tahun);
        $this->db->group_by('penjualan.method, kategori.coa_penjualan,kategori.`kategori` ,tbl_anggota.`nama`, penjualan.`id_cs`');
        return $this->db->get();
    }

    function PenjualanPersediaan($bulan, $tahun)
    {
        $this->db->select('SUM(detil_penjualan.hpp * detil_penjualan.`qty_jual`) AS jml, kategori.coa_hpp,kategori.coa_persediaan, kategori.`kategori`,barang.`nama_barang`,barang.`id_barang`');
        $this->db->from('detil_penjualan');
        $this->db->join('penjualan', 'penjualan.id_jual = detil_penjualan.id_jual');
        $this->db->join('barang', 'barang.id_barang=detil_penjualan.id_barang');
        $this->db->join('kategori', 'kategori.id_kategori=barang.id_kategori');
        $this->db->where('month(penjualan.tgl)', $bulan);
        $this->db->where('year(penjualan.tgl)', $tahun);
        $this->db->group_by('kategori.`kategori`,barang.`nama_barang`,barang.`id_barang`');
        return $this->db->get();
    }

    function BayarPiutang($bulan, $tahun)
    {
        $this->db->select('SUM(nominal) AS jml, coakas');
        $this->db->from('piutang');
        $this->db->join('detil_piutang', 'piutang.id_piutang = detil_piutang.`id_piutang`');
        $this->db->where('month(tgl_bayar)', $bulan);
        $this->db->where('year(tgl_bayar)', $tahun);
        $this->db->group_by('coakas');
        return $this->db->get();
    }

    function Pembelian($bulan, $tahun)
    {
        $this->db->select('SUM(detil_pembelian.subtotal) AS jml, kategori.coa_persediaan, kategori.`kategori`,barang.`nama_barang`,barang.`id_barang`,pembelian.coakas ');
        $this->db->from('detil_pembelian');
        $this->db->join('pembelian', 'pembelian.id_beli=detil_pembelian.id_beli');
        $this->db->join('barang', 'barang.id_barang = detil_pembelian.id_barang');
        $this->db->join('kategori', 'kategori.id_kategori=barang.id_kategori');
        $this->db->where('month(tgl)', $bulan);
        $this->db->where('year(tgl)', $tahun);
        $this->db->group_by('kategori.`kategori`,barang.`nama_barang`,barang.`id_barang`,kategori.`coa_persediaan`,pembelian.coakas');
        return $this->db->get();
    }

    function BayarHutang($bulan, $tahun)
    {
        $this->db->select('supplier.`nama_supplier`, supplier.`id_supplier`, sum(detil_hutang.`nominal`) as jml, detil_hutang.`coakas`');
        $this->db->from('hutang');
        $this->db->join('pembelian', 'hutang.`id_beli`=pembelian.`id_beli`');
        $this->db->join('detil_hutang', 'detil_hutang.id_hutang = hutang.`id_hutang`');
        $this->db->join('supplier', 'supplier.`id_supplier` = pembelian.`id_supplier`');
        $this->db->where('month(tgl_bayar)', $bulan);
        $this->db->where('year(tgl_bayar)', $tahun);
        $this->db->group_by('supplier.`nama_supplier`, supplier.`id_supplier`, detil_hutang.`coakas`');
        return $this->db->get();
    }

    function CekPosting($id,$coa)
    {
        $this->db->select('vcIDJournal,cuJournalDebet,cuJournalCredit');
        $this->db->from('tbl_journal');
        $this->db->where('vcIDJournal', $id);
        $this->db->where('vcCOAJournal', $coa);
        $hasil = $this->db->get();
        if ($hasil->num_rows() > 0) {
            foreach ($hasil->result() as $rs) {
                $res['id'] = $rs->vcIDJournal;
                if ($rs->cuJournalDebet > 0) {
                    $res['nominal'] = $rs->cuJournalDebet;
                }
                if ($rs->cuJournalCredit > 0) {
                    $res['nominal'] = $rs->cuJournalCredit;
                }
            }
        } else {
            $res['id'] = '';
            $res['nominal'] = 0;
        }
        return $res;
    }
}
