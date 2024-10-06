<?php
include 'report_header.php';
$pdf->SetFont('Times', 'B', 14);

//judul laporan
$pdf->Cell(0, 5, 'LAPORAN PENJUALAN', 0, 1, 'C');
$pdf->SetFont('Times', 'B', 11);

//tanggal laporan
$pdf->Cell(0, 7, 'Periode :' . date("d-m-Y", strtotime($awal)) . ' s/d ' . date("d-m-Y", strtotime($akhir)), 0, 1, 'C');

//header data laporan
//nilai total Seluruh penjualan
if($kasir=="all")
{
    $jual=$this->Penjualan_m->Daftar_penjualan_tanggal($awal,$akhir)->result();
}
else
{
    $jual=$this->Penjualan_m->Daftar_penjualan_tanggal_kasir($awal,$akhir,$kasir)->result();
}
$ts=0;
foreach ($jual as $j) {
    $pdf->Cell(30, 17, '', 0, 1);
    $pdf->SetFont('Times', '', 10);
    $pdf->Cell(20, 6, 'INVOICE', 0, 0, 'L');
    $pdf->Cell(2, 6, ': ', 0, 0, 'C');
    $pdf->Cell(65, 6, $j->invoice, 0, 0, 'L');
    $pdf->Cell(25, 6, 'KASIR', 0, 0, 'L');
    $pdf->Cell(3, 6, ': ', 0, 0, 'R');
    $user=$this->Penjualan_m->Peg_kasir_id($j->id_user)->row();
    $pdf->Cell(50, 6, $user->nama_lengkap, 0, 1, 'L');
    $pdf->Cell(30, 0, '', 0, 1);
    $pdf->Cell(20, 6, 'WAKTU', 0, 0, 'L');
    $pdf->Cell(3, 6, ': ', 0, 0, 'C');
    $pdf->Cell(64, 6, date("d-m-Y H:i:s", strtotime($j->tgl)), 0, 0, 'L');
    $pdf->Cell(25, 6, 'CUSTOMER', 0, 0, 'L');
    $pdf->Cell(3, 6, ': ', 0, 0, 'R');
    $cs=$this->Penjualan_m->Daftar_pegawai($j->id_cs)->row();
    $pdf->Cell(20, 6, $cs->nama . ' / ' . $j->method, 0, 0, 'L');
    $pdf->Cell(30, 6, '', 0, 1);
    
    //detail penjualan
    
    //variable nomor urut
    $i=1;
    $pdf->SetFont('Times', 'B', 9);
    $pdf->Cell(7, 6, 'NO', 1, 0, 'C');
    $pdf->Cell(68, 6, 'ITEM', 1, 0, 'C');
    $pdf->Cell(25, 6, 'HARGA', 1, 0, 'C');
    $pdf->Cell(17, 6, 'QTY', 1, 0, 'C');
    $pdf->Cell(25, 6, 'DISC (Rp.)', 1, 0, 'C');
    $pdf->Cell(25, 6, 'SUBTOTAL', 1, 1, 'C');
    $detil=$this->Penjualan_m->Detail_penjualan($j->id_jual)->result();
    $gt=0;
    foreach ($detil as $d) {
        // content Detail Penjualan
        $pdf->SetFont('Times', '', 9);
        $pdf->Cell(7, 6, $i++, 1, 0);
        $barang=$this->Penjualan_m->Detail_barang($d->id_barang)->row();
        $pdf->Cell(68, 6, $barang->nama_barang, 1, 0);
        $pdf->Cell(25, 6, number_format($d->harga_item, '0', '.', '.'), 1, 0,'R');
        $pdf->Cell(17, 6, $d->qty_jual, 1, 0,'R');
        $pdf->Cell(25, 6, number_format($d->diskon, '0', '.', '.'), 1, 0,'R');
        $pdf->Cell(25, 6, number_format($d->subtotal, '0', '.', '.'), 1, 1,'R');
        $gt=$gt+$d->subtotal;
    }
    // Grand Total
     $pdf->Cell(7, 6, '', 0, 0);
     $pdf->Cell(68, 6, '', 0, 0);
     $pdf->Cell(25, 6, '', 0, 0);
     $pdf->Cell(17, 6,'', 0, 0);
     $pdf->SetFont('Times', 'B', 9);
     $pdf->Cell(25, 6, 'Grand Total : ',0,0,'L');
     $pdf->Cell(25, 6, number_format($gt, '0', '.', '.'), 1, 1,'R');
     $ts=$ts+$gt;

    }
     $pdf->Cell(7, 6, '', 0, 0);
     $pdf->Cell(68, 6, '', 0, 0);
     $pdf->Cell(25, 6, '', 0, 0);
     $pdf->Cell(17, 6,'', 0, 0);
     $pdf->SetFont('Times', 'B', 9);
     $pdf->Cell(25, 6, 'Total Penjualan: ',0,0,'L');
     $pdf->Cell(25, 6, number_format($ts, '0', '.', '.'), 1, 1,'R');
    $pdf->Output('laporan_penjualan.pdf', 'I');
