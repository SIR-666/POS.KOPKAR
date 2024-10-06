<?php //cek_user() ?>
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
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!------------------------identitas supplier---------------------------------------------------->
                        <?php
                        $nota = $this->Pembelian_m->nota_toko($id_beli)->row();
                        $pegawai = $this->Pembelian_m->Daftar_supplier_id($nota->id_supplier)->row();
                        ?>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <b>
                                        <?php echo $nota->faktur_beli; ?>
                                    </b>
                                </div>
                                <div class="col-md-4">
                                    <b>
                                        <?php 
                                            if(isset($pegawai->nama_supplier))
                                            {
                                                echo $pegawai->nama_supplier;
                                            }
                                            else
                                            {
                                                echo "UMUM";
                                            }
                                        ?>
                                    </b>
                                </div>
                                <div class="col-md-4">
                                    <b>
                                        <?php echo date("d F Y", strtotime($nota->tgl_faktur)); ?>
                                    </b>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <b>ITEM PEMBELIAN</b>
                                    </div>
                                    <div class="x_content">
                                        <?php $barang = $this->Pembelian_m-> Detil_pembelian($id_beli)->result(); ?>
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
                                                <?php
                                                foreach ($barang as $brg) {
                                                  
                                                ?>
                                                    <form method="post" action="<?= site_url() . '/Dpembelian/Simpan_retur' ?>">
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" name="id_beli" value="<?php echo $id_beli; ?>">
                                                                <input type="hidden" name="id_supplier" value="<?php echo $pegawai->id_supplier; ?>">
                                                                <input type="hidden" name="invoice" value="<?php echo  $nota->faktur_beli; ?>">
                                                                <input type="hidden" name="barang" value="<?php echo  $brg->id_barang; ?>">
                                                                <?php   $item = $this->Pembelian_m->Daftar_barang_id($brg->id_barang)->row();?>
                                                                <?= $item->nama_barang ?>
                                                            </td>
                                                            <td>
                                                                <?= $brg->qty_beli ?>
                                                            </td>
                                                            <td><?= number_format($brg->hrg_beli, 0) ?></td>
                                                            <td><?= number_format($brg->subtotal, 0) ?></td>
                                                            <td>
                                                                <select name="qretur" class="form-control">
                                                                    <?php
                                                                    for ($x = 1; $x <= $brg->qty_beli; $x++) {
                                                                        echo "<option value='" . $x . "'>" . $x . "</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="ket">
                                                            </td>
                                                            <td>
                                                                <?php if ($brg->qty_beli > 0) { ?>
                                                                    <button type="submit" class="btn btn-sm btn-warning">Retur <i class="fa fa-arrow-right"></i></button>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    </form>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <b>ITEM RETUR</b>
                                    </div>
                                    <div class="x_content">
                                        <?php 
                                        $retur = $this->Pembelian_m->Detail_retur($id_beli)->result();?>
                                    
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

                                                foreach ($retur as $data_retur) {
                                                ?>
                                                    <tr>
                                                        <?php
                                                        $brg = $this->Pembelian_m->Detail_retur($data_retur->id_barang)->row();
                                                        $item = $this->Pembelian_m->Daftar_barang_id($data_retur->id_barang)->row();
                                                        ?>
                                                        <td><?php echo $item->nama_barang; ?></td>
                                                        <td><?php echo $data_retur->qty_retur; ?></td>
                                                        <td><?php echo number_format($data_retur->harga_item,0); ?></td>
                                                        <?php
                                                        //hitung Total Retur
                                                        $total = $data_retur->harga_item * $data_retur->qty_retur;
                                                        ?>
                                                        <td><?php echo number_format($total,0); ?></td>
                                                        <td><?php echo $data_retur->ket; ?></td>
                                                        <td>
                                                            <?php if ($data_retur->status == 0) { ?>
                                                                <a href="<?php echo site_url() . 'Dpembelian/Hapus_retur/' ?><?php echo $data_retur->id_retur; ?>/<?php echo $id_beli; ?>" title="Hapus Retur Penjualan" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                                            <?php } ?>
                                                        </td>
                                                        <?php
                                                        //itung total retur
                                                        $t_retur = $t_retur + $total;
                                                        ?>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!----------------------------------------tabel--------------------------------------------------->

                        <table class="table table-striped">
                            <tr>
                                <td width="50%">
                                    
                                </td>
                                <td> <h3>Total Retur</h3></td>
                                <td>
                                    <h3><?php echo number_format($t_retur,0) ?></h3>
                                </td>
                            </tr>
                        </table>
                        <div class="modal-footer">
                            <a href="<?php echo site_url() . 'Dpembelian/Kembalikan_barang/' . $id_beli; ?>" class="btn btn-info">Simpan Retur</a>
                            <a href="<?php echo site_url() . 'Dpembelian'; ?>" class="btn btn-primary">Batal</a>
                        </div>

                    <!----------------------------------------akhir Tabel---------------------------------------------->
                </div>
            </div>
        </div>
    </div>
</div>