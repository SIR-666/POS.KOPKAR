<?php
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 18);
$profil = $this->db->get('profil_perusahaan')->row_array();
$pdf->Image('./assets/img/profil/' . $profil['logo_toko'], 70, 5, 27, 24);
$pdf->Cell(25);
$pdf->SetFont('Times', 'B', 20);
$pdf->Cell(0, 5, $profil['nama_toko'], 0, 1, 'C');
$pdf->Cell(25);
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(0, 5, 'Website :' . $profil['website_toko'] . '/ E-Mail : ' . $profil['email_toko'], 0, 1, 'C');
$pdf->Cell(25);
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(0, 5, $profil['alamat_toko'] . ' Telp. / Fax : ' . $profil['telp_toko'] . ' / ' . $profil['fax_toko'], 0, 1, 'C');

$pdf->SetLineWidth(1);
$pdf->Line(10, 36, 285, 36);
$pdf->SetLineWidth(0);
$pdf->Line(10, 37, 285, 37);
$pdf->Cell(30, 17, '', 0, 1);

$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(0, 5, 'LAPORAN DATA BARANG', 0, 1, 'C');
$pdf->Cell(0, 5, 'SAMPAI DENGAN '. date('d F Y', strtotime($tgl)), 0, 1, 'C');
$pdf->SetFont('Times', 'B', 11);
$pdf->Cell(0, 7, $sup->nama_supplier, 0, 1, 'C');

//$sqldetil = "SELECT a.id_barang, a.nama_barang, a.barcode, a.harga_pelanggan, a.harga_toko, a.harga_sales, b.satuan, c.kategori, a.harga_beli,a.harga_jual, a.stok FROM barang a, satuan b, kategori c, supplier d WHERE c.id_kategori = a.id_kategori AND b.id_satuan = a.id_satuan AND a.is_active = 1 AND d.id_supplier = a.id_supplier AND a.id_supplier = '$id' ";
//$detil = $this->model->General($sqldetil)->result_array();
$brg=$this->Penjualan_m->Barang_all()->result();
//echo var_dump($data);
$pdf->Cell(30, 8, '', 0, 0);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(7, 6, 'NO', 1, 0, 'C');
$pdf->Cell(73, 6, 'NAMA ITEM', 1, 0, 'C');
$pdf->Cell(20, 6, 'SATUAN', 1, 0, 'C');
$pdf->Cell(25, 6, 'HARGA BELI', 1, 0, 'C');
$pdf->Cell(25, 6, 'HARGA TOKO', 1, 0, 'C');
$pdf->Cell(20, 6, 'STOK BELI', 1, 0, 'C');
$pdf->Cell(20, 6, 'STOK JUAL', 1, 1, 'C');
$i = 1;
//data
foreach($brg as $dt_brg)
{
    $pdf->Cell(30, 8, '', 0, 0);
    $pdf->SetFont('Times', '', 9);
    $pdf->Cell(7, 6, $i++, 1, 0);
    $pdf->Cell(73, 6, $dt_brg->nama_barang, 1, 0);
    $satuan=$this->Penjualan_m->Satuan_item($dt_brg->id_satuan)->row();
    $pdf->Cell(20, 6, $satuan->satuan , 1, 0);
    $pdf->Cell(25, 6, 'Rp. ' . number_format($dt_brg->harga_beli, '2', '.', '.'), 1, 0);
    $pdf->Cell(25, 6, 'Rp. ' . number_format($dt_brg->harga_jual, '0', '.', '.'), 1, 0);
    //set tanggal stok beli
    $tgl_f=date('Y-m-d', strtotime($tgl. ' +1 days'));
    $tgl_beli = $tgl_f.' '.'00:00:00';
    //cari sok beli
    $stok_beli=$this->Pembelian_m->Jumlah_item_tgl($dt_brg->id_barang,$tgl_beli)->row();
   if(empty($stok_beli->qty_beli))
   {
        $stok_b=0;
   }
   else
   {
        $stok_b=$stok_beli->qty_beli;
   }
   //cari stok jual
   $stok_jual=$this->Penjualan_m->Jumlah_item_tgl($dt_brg->id_barang,$tgl_beli)->row();
   if(empty($stok_jual->qty_jual))
   {
        $stok_j=0;
   }
   else
   {
        $stok_j=$stok_jual->qty_jual;
   }

    $pdf->Cell(20, 6, $stok_b , 1, 0);
    $pdf->Cell(20, 6, $stok_j , 1, 1);
 }
$pdf->SetFont('Times', '', 10);
$pdf->Output('Laporan Barang Per Tanggal.pdf', 'I');
