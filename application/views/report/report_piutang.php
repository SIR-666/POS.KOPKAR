<?php
include 'report_header.php';
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 5, 'LAPORAN DATA PIUTANG', 0, 1, 'C');
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 7, 'Periode :' . date("d-m-Y", strtotime($awal)) . ' s/d ' . date("d-m-Y", strtotime($akhir)), 0, 1, 'C');


$sql = "SELECT tbl_anggota.nama AS nama, SUM(subtotal) AS total_beli,piutang.bayar AS bayar,
        SUM(subtotal) - piutang.bayar  AS sisa, piutang.status AS status ";
$sql = $sql . " FROM piutang JOIN penjualan ON piutang.id_jual = penjualan.id_jual 
                JOIN tbl_anggota ON tbl_anggota.id = penjualan.id_cs 
                JOIN detil_penjualan ON penjualan.id_jual = detil_penjualan.id_jual ";
$sql = $sql . " WHERE penjualan.method = 'Kredit' AND penjualan.tgl >= '" . date("Y-m-d", strtotime($awal)) . "' and penjualan.tgl <= '" . date("Y-m-d", strtotime($akhir. ' +1 days')) . "' ";


if ($customer != "Semua") {
    $sql = $sql . " and penjualan.id_cs = " . $customer;
}
$sql = $sql . " GROUP BY tbl_anggota.nama,piutang.bayar,piutang.status";
$data = $this->db->query($sql)->result_array();

//$pdf->Cell(0, 7, $sql,0,1,'C');

$pdf->Cell(30, 8, '', 0, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(30, 6, ' ', 0, 0, 'C');
$pdf->Cell(10, 6, 'NO', 1, 0, 'C');
$pdf->Cell(40, 6, 'ANGGOTA', 1, 0, 'C');
$pdf->Cell(25, 6, 'JUMLAH', 1, 0, 'C');
$pdf->Cell(25, 6, 'BAYAR', 1, 0, 'C');
$pdf->Cell(25, 6, 'SISA', 1, 0, 'C');
$pdf->Cell(20, 6, 'STATUS', 1, 1, 'C');

$count=0;
$total = 0;
$sisa = 0;
$bayar = 0;
foreach ($data as $d) {
    $count=$count+1;
    $pdf->SetFont('Times', '', 9);
    $pdf->Cell(30, 6, ' ', 0, 0, 'C');
$pdf->Cell(10, 6, $count, 1, 0, 'C');
    //$member=$this->db->query($ang)->row_array();
    if (strlen($d['nama']) > 20) {
        $pdf->Cell(40, 6, substr($d['nama'],0,17) . "...", 1, 0);
    } else {
        $pdf->Cell(40, 6, $d['nama'], 1, 0);
    }
    $pdf->Cell(25, 6, 'Rp. ' . number_format($d['total_beli'], '0', '.', '.'), 1, 0);
    $pdf->Cell(25, 6, 'Rp. ' . number_format($d['bayar'], '0', '.', '.'), 1, 0);
    $pdf->Cell(25, 6, 'Rp. ' . number_format($d['sisa'], '0', '.', '.'), 1, 0);
    $pdf->Cell(20, 6, $d['status'], 1, 1);
    $total = $total + $d['total_beli'];
    $bayar = $bayar + $d['bayar'];
}
$sisa = $total - $bayar;



$pdf->Cell(98, 2, '', 0, 1, 'R');
$pdf->Cell(98, 6, '', 0, 0, 'R');
$pdf->SetFont('Times', 'B', 10);
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(40, 6, 'Total Piutang', 1, 0, 'L');
$pdf->Cell(37, 6, 'Rp. ' . number_format($total, '0', '.', '.') . ',-', 1, 1, 'L');
$pdf->Cell(98, 6, '', 0, 0, 'R');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(40, 6, 'Piutang Dibayarkan', 1, 0, 'L');
$pdf->Cell(37, 6, 'Rp. ' . number_format($bayar, '0', '.', '.') . ',-', 1, 1, 'L');
$pdf->Cell(98, 6, '', 0, 0, 'R');
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(40, 6, 'Sisa Piutang', 1, 0, 'L');
$pdf->Cell(37, 6, 'Rp. ' . number_format($sisa, '0', '.', '.') . ',-', 1, 0, 'L');

$pdf->Output('laporan_piutang.pdf', 'I');
