<?php //cek_user() 
?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3><?php echo $title ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!------------------------identitas pembeli---------------------------------------------------->
                        <?php
                        $nota = $this->Penjualan_m->nota_toko($id_jual)->row();
                        $pegawai = $this->Penjualan_m->Daftar_pegawai($nota->id_cs)->row();
                        ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <h5><strong><?php echo $nota->invoice; ?></strong></h5>
                                </div>
                                <div class="col-md-4 text-center">
                                    <h5><strong>
                                        <?php 
                                            echo isset($pegawai->nama) ? $pegawai->nama : "UMUM";
                                        ?>
                                    </strong></h5>
                                </div>
                                <div class="col-md-4 text-center">
                                    <h5><strong><?php echo date("d F Y H:i:s", strtotime($nota->tgl)); ?></strong></h5>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h4><strong>ITEM PENJUALAN</strong></h4>
                                    </div>
                                    <div class="x_content">
                                        <?php $barang = $this->Penjualan_m->Detail_penjualan($id_jual)->result(); ?>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Barang</th>
                                                    <th>Qty</th>
                                                    <th>Harga</th>
                                                    <th>Sub Total</th>
                                                    <th width="80px">Qty Retur</th>
                                                    <th>Alasan Retur</th>
                                                    <th>Retur</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($barang as $brg): ?>
                                                    <form method="post" action="<?= site_url('Dpenjualan/Simpan_retur') ?>">
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" name="id_jual" value="<?php echo $id_jual; ?>">
                                                                <input type="hidden" name="id_cs" value="<?php echo $nota->id_cs; ?>">
                                                                <input type="hidden" name="invoice" value="<?php echo  $nota->invoice; ?>">
                                                                <input type="hidden" name="barang" value="<?php echo  $brg->id_barang; ?>">
                                                                <?= $brg->nama_barang ?>
                                                            </td>
                                                            <td><?= $brg->qty_jual ?></td>
                                                            <td><?= number_format($brg->harga_item, 0) ?></td>
                                                            <td><?= number_format($brg->subtotal, 0) ?></td>
                                                            <td>
                                                                <select name="qretur" class="form-control">
                                                                    <?php for ($x = 1; $x <= $brg->qty_jual; $x++): ?>
                                                                        <option value="<?= $x ?>"><?= $x ?></option>
                                                                    <?php endfor; ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="ket" placeholder="Alasan retur">
                                                            </td>
                                                            <td>
                                                                <?php if ($brg->qty_jual > 0): ?>
                                                                    <button type="submit" class="btn btn-sm btn-warning">Retur <i class="fa fa-arrow-right"></i></button>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    </form>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h4><strong>ITEM RETUR</strong></h4>
                                    </div>
                                    <div class="x_content">
                                        <?php $retur = $this->Penjualan_m->Detail_retur($id_jual)->result(); ?>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama Barang</th>
                                                    <th>Qty Retur</th>
                                                    <th>Harga</th>
                                                    <th>Sub Total</th>
                                                    <th>Alasan Retur</th>
                                                    <th>Batalkan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $t_retur = 0;
                                                foreach ($retur as $data_retur):
                                                    ?>
                                                    <tr>
                                                        <?php $brg = $this->Penjualan_m->Detail_barang($data_retur->id_barang)->row(); ?>
                                                        <td><?php echo $brg->nama_barang; ?></td>
                                                        <td><?php echo $data_retur->qty_retur; ?></td>
                                                        <td><?php echo number_format($data_retur->harga_item, 0); ?></td>
                                                        <?php $total = $data_retur->harga_item * $data_retur->qty_retur; ?>
                                                        <td><?php echo number_format($total, 0); ?></td>
                                                        <td><?php echo $data_retur->ket; ?></td>
                                                        <td>
                                                            <?php if ($data_retur->status == 0): ?>
                                                                <a href="<?= site_url('Dpenjualan/Hapus_retur/' . $data_retur->id_retur . '/' . $id_jual) ?>" class="btn btn-danger btn-xs" title="Hapus Retur Penjualan"><i class="fa fa-trash"></i></a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $t_retur += $total;
                                                endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-striped">
                            <tr>
                                <td width="50%"></td>
                                <td><h4><strong>Total Retur</strong></h4></td>
                                <td><h4 class="text-danger"><strong><?php echo number_format($t_retur, 0) ?></strong></h4></td>
                            </tr>
                        </table>
                        <div class="modal-footer">
                            <a href="<?php echo site_url('Dpenjualan/Kembalikan_barang/' . $id_jual); ?>" class="btn btn-info">Simpan Retur</a>
                            <a href="<?php echo site_url('Dpenjualan'); ?>" class="btn btn-primary">Batal</a>
                        </div>

                        <!----------------------------------------akhir Tabel---------------------------------------------->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
