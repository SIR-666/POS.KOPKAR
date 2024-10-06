<?php
include 'report_header.php';
$pdf->SetFont('Times', 'B', 14);

//judul laporan
foreach ($jual as $j) {
$user=$this->Penjualan_m->Peg_kasir_id($j->id_user)->row();
}
$pdf->Cell(0, 5, 'LAPORAN REKAP PENJUALAN '. strtoupper($method), 0, 1, 'C');
$pdf->SetFont('Times', 'B', 11);

//tanggal laporan
$pdf->Cell(0, 7, 'Periode :' . date("d-m-Y", strtotime($awal)) . ' s/d ' . date("d-m-Y", strtotime($akhir)), 0, 1, 'C');
//Kasir
$pdf->Cell(0, 5, 'Kasir : '.$nama_kasir->nama_lengkap, 0, 1, 'C');
//header data laporan
//nilai total Seluruh penjualan

$sql = "SELECT nama,metode_pembayaran,SUM(subtotal) AS subtotal FROM view_detil_penjualan where tgl >= '" . date("Y-m-d", strtotime($awal)) . "' and tgl <= '" . date("Y-m-d", strtotime($akhir . ' +1 days')) . "' and  id_user='$kasir' and metode_pembayaran='$method' group by nama, metode_pembayaran order by nama";
//echo $sql;
//die;
$data = $this->db->query($sql)->result_array();
$ts=0;
$i=0;
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(7, 6, ' ', 0, 1, 'C');
//tengah
$pdf->Cell(20, 6, ' ', 0, 0, 'C');
//header
$pdf->Cell(7, 6, 'NO', 1, 0, 'C');
$pdf->Cell(68, 6, 'CUSTOMER', 1, 0, 'C');
$pdf->Cell(40, 6, 'PAYMENT METHOD', 1, 0, 'C');
$pdf->Cell(25, 6, 'TOTAL', 1, 1, 'C');
//data
foreach($data as $d){
    $i=$i+1;
    //tengah
    $pdf->Cell(20, 6, ' ', 0, 0, 'C');
    $pdf->Cell(7, 6, $i, 1, 0, 'C');
    if(empty($d['nama'])){
        $pdf->Cell(68, 6, "UMUM", 1, 0, 'L');
    }
    else
    {
        $pdf->Cell(68, 6, $d['nama'], 1, 0, 'L');
    }
    $pdf->Cell(40, 6, $d['metode_pembayaran'], 1, 0, 'L');
    $pdf->Cell(25, 6,'Rp. ' . number_format($d['subtotal'], '0', '.', '.') . ',-', 1, 1, 'R');
    $gt=$gt+$d['subtotal'];
}
$pdf->Cell(95, 6, '', 0, 0, 'L');
$pdf->Cell(40, 6, 'Total Penjualan', 1, 0, 'L');
$pdf->Cell(25, 6, 'Rp. ' . number_format($gt, '0', '.', '.') . ',-', 1, 0, 'R');

$pdf->Output('laporan_penjualan.pdf', 'I');
