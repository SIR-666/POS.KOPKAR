<?php
$data=$this->Penjualan_m->Kategori($kategori)->row();
include 'report_header.php';
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 5, 'LAPORAN DATA PENJUALAN '. $data->kategori, 0, 1, 'C');
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 7, 'Periode :' . date("d-m-Y", strtotime($awal)) . ' s/d ' . date("d-m-Y", strtotime($akhir)), 0, 1, 'C');
$pdf->Cell(30, 8, '', 0, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(50, 6, 'ANGGOTA', 1, 0, 'C');
$pdf->Cell(20, 6, 'TANGGAL', 1, 0, 'C');
$pdf->Cell(50, 6, 'BARANG', 1, 0, 'C');
$pdf->Cell(20, 6, 'JUMLAH', 1, 0, 'C');
$pdf->Cell(25, 6, 'HARGA', 1, 0, 'C');
$pdf->Cell(25, 6, 'TOTAL', 1, 1, 'C');
//CONTENT
$takhir=date('Y-m-d', strtotime($akhir. ' +1 days'));
if($this->data['kategori']=="Semua")
{
	$report=$this->Penjualan_m->Report_penjualan_all($awal,$takhir)->result();	
}
else
{
	$report=$this->Penjualan_m->Report_penjualan_id($this->data['kategori'],$awal,$takhir)->result();
}
//data
$gt=0;
foreach($report as $data_report)
{
    $pdf->Cell(50, 6, $data_report->nama, 1, 0, 'L');
    $pdf->Cell(20, 6, date("d-m-Y", strtotime($data_report->tgl)), 1, 0, 'L');
    $pdf->Cell(50, 6, $data_report->nama_barang, 1, 0, 'L');
    $pdf->Cell(20, 6, $data_report->qty_jual, 1, 0, 'R');
    $pdf->Cell(25, 6, 'Rp. ' . number_format($data_report->harga_item, '0', '.', '.') . ',-', 1, 0, 'R');
    $pdf->Cell(25, 6, 'Rp. ' . number_format($data_report->subtotal, '0', '.', '.') . ',-', 1, 1, 'R');
    $gt=$gt+$data_report->subtotal;
}
//footer
$pdf->Cell(118, 2, '', 0, 1, 'R');
$pdf->Cell(118, 6, '', 0, 1, 'R');
$pdf->SetFont('Times', 'B', 10);
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(103, 6, '',0 ,0 , 'R');
$pdf->Cell(50, 6, 'Total penjualan', 1, 0, 'L');
$pdf->Cell(37, 6, 'Rp. ' . number_format($gt, '0', '.', '.') . ',-', 1, 1, 'R');
$pdf->Cell(118, 6, '', 0, 0, 'R');
$pdf->Output('laporan_penjualan.pdf', 'I');
?>