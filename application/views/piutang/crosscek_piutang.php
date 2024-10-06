<div class="right_col" role="main">
    <h3><?php echo $title; ?></h3>
    <div class="text-primary h6">Total record : <?php echo count($piutang_penjualan); ?></div>
    <div class="table_responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Invoice</th>
                    <th>Method</th>
                    <th>Kasir</th>
                    <th>Nama Customer</th>
                    <th>Tanggal Piutang</th>
                    <th>Jumlah Piutang</th>
                    <th>Status Bayar</th>
                    <th>Jumlah Bayar</th>
                    <th>Sisa Piutang</th>
                    <th style="background:#faf1be;">Kode Jual</th>
                    <th style="background:#faf1be;">Total Penjualan </th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($piutang_penjualan) && count($piutang_penjualan) > 0) {
                    $no = 1;
                    foreach ($piutang_penjualan as $pu) {
                        $warna = $pu->jml_piutang != $pu->total_penjualan ? '#ffeae8' : '#f2fcf4';
                        echo '<tr style="background:' . $warna . '">';
                        echo '<td>' . $no . '</td>';
                        echo '<td>' . $pu->invoice . '</td>';
                        echo '<td>' . $pu->method . '</td>';
                        echo '<td>' . $pu->nama_user . '</td>';
                        echo '<td>' . $pu->nama . '</td>';
                        echo '<td>' . $pu->tgl_piutang . '</td>';
                        echo '<td class="text-right">' . number_format($pu->jml_piutang, 0, '.', ',') . '</td>';
                        echo '<td>' . $pu->status . '</td>';
                        echo '<td class="text-right">' . number_format($pu->bayar, 0, '.', ',') . '</td>';
                        echo '<td class="text-right">' . number_format($pu->sisa, 0, '.', ',') . '</td>';
                        echo '<td style="background:#fff9d9;">' . $pu->kode_jual . '</td>';
                        echo '<td class="text-right" style="background:#fff9d9;">' . number_format($pu->total_penjualan, 0, '.', ',') . '</td>';
                        echo '</tr>';
                        $no++;
                    }
                } else {
                    echo '<tr><td colspan="12">Tidak ada data!</td></tr>';
                }

                ?>
            </tbody>
        </table>

    </div>
</div>