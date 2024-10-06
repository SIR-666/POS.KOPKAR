<?php
include 'report_header.php';

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 5, 'LAPORAN PEMBELIAN', 0, 1, 'C');
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 7, 'Periode :' . date("d-m-Y",strtotime($awal)) . ' s/d ' . date("d-m-Y",strtotime($akhir)), 0, 1, 'C');
$takhir=date('Y-m-d', strtotime($akhir. ' +1 days'));
// Initialize the total variables
$tbeli = 0; // Total Pembelian
$tdisk = 0; // Total Diskon
$at = 0; // Grand Total (Total Akhir)
$ad = 0; // Total Diskon dari semua transaksi

if($supplier=="Semua")
{
    $beli=$this->Pembelian_m->Report_pembelian_all($awal,$takhir)->result();
}
else
{
    $beli=$this->Pembelian_m->Report_pembelian_id($supplier,$awal,$takhir)->result();
    
    // die($supplier . ' / ' .$awal. ' - ' . $takhir);
    // die($takhir);
}
//CONTENT
foreach ($beli as $b) 
{
    $head=$this->Pembelian_m->Report_detail($b->id_beli)->row();
    // die(var_dump($head));
    $pdf->Cell(30, 17, '', 0, 1);
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(30, 6, 'NO. FAKTUR ', 0, 0, 'L');
    $pdf->Cell(2, 6, ': ', 0, 0, 'C');
    $pdf->Cell(65, 6, $b->faktur_beli, 0, 0, 'L');
    $pdf->Cell(27, 6, 'SUPPLIER ', 0, 0, 'L');
    $pdf->Cell(3, 6, ' : ', 0, 0, 'R');
    $pdf->Cell(50, 6, $head->nama_supplier, 0, 1, 'L');
    $pdf->Cell(30, 0, '', 0, 1);
    $pdf->Cell(30, 6, 'TGL. FAKTUR ', 0, 0, 'L');
    $pdf->Cell(3, 6, ': ', 0, 0, 'C');
    $pdf->Cell(64, 6, date("d-m-Y",strtotime($b->tgl_faktur)), 0, 0, 'L');
    $pdf->Cell(27, 6, 'PEMBAYARAN ', 0, 0, 'L');
    $pdf->Cell(3, 6, ' : ', 0, 0, 'R');
    $pdf->Cell(20, 6, $b->method, 0, 0, 'L');
    $pdf->Cell(30, 6, '', 0, 1);
    $pdf->SetFont('Times', 'B', 9); 
    //data
        $pdf->Cell(7, 6, 'NO', 1, 0, 'C');
        $pdf->Cell(68, 6, 'ITEM', 1, 0, 'C');
        $pdf->Cell(28, 6, 'HARGA BELI', 1, 0, 'C');
        $pdf->Cell(28, 6, 'HARGA JUAL', 1, 0, 'C');
        $pdf->Cell(28, 6, 'DISKON', 1, 0, 'C');
        $pdf->Cell(11, 6, 'QTY', 1, 0, 'C');
        $pdf->Cell(25, 6, 'SUBTOTAL', 1, 1, 'C');
        $i = 1;
    $detil=$this->Pembelian_m->Report_detail($b->id_beli)->result();
    // die(var_dump($detil));
    $gd=0;
    $gt=0;
    foreach($detil as $d)
    {    
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(7, 6, $i++, 1, 0);
        $pdf->Cell(68, 6, $d->nama_barang, 1, 0);
        $pdf->Cell(28, 6, 'Rp. ' . number_format($d->hrg_beli, '3', ',', '.'), 1, 0);
        $pdf->Cell(28, 6, 'Rp. ' . number_format($d->hrg_jual, '0', '.', '.'), 1, 0);
        $pdf->Cell(28, 6, 'Rp. ' . number_format($b->diskon, '0', '.', '.'), 1, 0);
        $pdf->Cell(11, 6, $d->qty_beli, 1, 0,'R');
        $pdf->Cell(25, 6, 'Rp. ' . number_format($d->subtotal, '3', ',', '.'), 1, 1);
        $gt=$gt+$d->subtotal;
        $gd=$gd+$b->diskon;
    }
    //footer
    $pdf->Cell(132, 2, '', 0, 1, 'R');
    $pdf->Cell(132, 6, '', 0, 0, 'R');
    $pdf->SetFont('Times', 'B', 10);
    $pdf->SetFont('Times', 'B', 10);
    $pdf->Cell(28, 6, 'Disc (Rp)', 1, 0, 'L');
    $tbeli=$tbeli+$d->subtotal;
    $tdisk=$tdisk+$b->diskon;    
    $pdf->Cell(37, 6, 'Rp. ' . number_format($gd, '2', '.', '.'), 1, 1, 'L');
    $pdf->Cell(132, 6, '', 0, 0, 'R');
    $pdf->Cell(28, 6, 'Grand Total', 1, 0, 'L');
    $pdf->Cell(37, 6, 'Rp. ' . number_format($gt, '2', ',', '.'), 1, 1, 'L');
    $tbel=0;
    $tdis=0;
    //total pembelian
    $pdf->Cell(132, 2, '', 0, 1, 'R');
    $pdf->Cell(132, 6, '', 0, 0, 'R');
    $pdf->SetFont('Times', 'B', 10);
    $pdf->SetFont('Times', 'B', 10);
    $at=$at+$gt;
    $ad=$ad+$gd;
}
$pdf->Cell(28, 6, 'Total Pembelian', 1, 0, 'L');
// $pdf->Cell(37, 6, 'Rp. ' . number_format($at-$ad, '2', ',', '.'), 1, 1, 'L');  
//Cetak
$pdf->SetFont('Times', '', 10);
$pdf->Output('laporan_pembelian.pdf', 'I');