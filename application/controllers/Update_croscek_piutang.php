<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Update_croscek_piutang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    
    /*** Update Piutang berdasarkan Total Penjualan */
    function index($b = "", $t = "")
    {
        $bulan = $b != "" ? $b : date('m');
        $tahun = $t != "" ? $t : date('Y');
        $sql = "
        SELECT b.id_jual,b.id_piutang, a.invoice, c.nama, b.tgl_piutang, b.jml_piutang, b.bayar, b.jatuh_tempo, b.sisa, b.status, a.method,a.kode_jual,d.nama_lengkap as nama_user, e.total_penjualan 
        FROM penjualan a 
        left join piutang b on b.id_jual = a.id_jual 
        left join tbl_anggota c ON a.id_cs = c.id 
        left join user d ON a.id_user = d.id_user 
        left join ( 
        select sum(subtotal) as total_penjualan, id_jual from detil_penjualan GROUP BY id_jual 
        ) as e ON a.id_jual=e.id_jual 
        
        WHERE b.status='Belum Lunas' 
        AND jml_piutang=0 
        AND a.method='Kredit' 
        AND e.total_penjualan > 0 
        ORDER BY b.tgl_piutang DESC
        LIMIT 1";

        $data = $this->db->query($sql)->row();

        $logs = array(
            'timestamps' => date('Y-m-d H:i:s'),
            'id_jual' => $data->id_jual,
            'id_piutang' => $data->id_piutang,
            'tgl_piutang' => $data->tgl_piutang,
            'nama_customer' => $data->nama,
            'status_transaksi' => $data->status,
            'metode_bayar' => $data->method,
            'invoice' => $data->invoice,
            'total_penjualan' => $data->total_penjualan,
            'jml_piutang_before' => 0,
            'jml_piutang_after' => $data->total_penjualan,
            'sisa_piutang' => $data->total_penjualan
        );

        $update_data = array(
            'jml_piutang' => $data->total_penjualan,
            'sisa' => $data->total_penjualan,
        );

        $this->db->where('id_piutang', $data->id_piutang);
        $this->db->where('id_jual', $data->id_jual);
        $update_submit = $this->db->update('piutang', $update_data);
        if ($update_submit) {
            $txt = json_encode($logs);
            $myfile = file_put_contents('logs_croscek_update.txt', $txt . PHP_EOL, FILE_APPEND | LOCK_EX);
        }
    }
}
