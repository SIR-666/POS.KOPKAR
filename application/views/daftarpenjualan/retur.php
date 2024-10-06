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
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
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
                                <div class="col-md-4">
                                    <b>
                                        <?php echo $nota->invoice; ?>
                                    </b>
                                </div>
                                <div class="col-md-4">
                                    <b>
                                        <?php echo $pegawai->nama; ?>
                                    </b>
                                </div>
                                <div class="col-md-4">
                                    <b>
                                        <?php echo date("d F Y H:i:s", strtotime($nota->tgl)); ?>
                                    </b>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <form class="form-horizontal" method="post" action="<?php echo site_url() . 'Dpenjualan/Simpan_retur'; ?>">
                                <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="hidden" class="form-control" id="id_jual" name="id_jual" autocomplete="off" value="<?php echo $id_jual; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="hidden" class="form-control" id="id_cs" name="id_cs" autocomplete="off" value="<?php echo $nota->id_cs; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="hidden" class="form-control" id="invoice" name="invoice" autocomplete="off" value="<?php echo $nota->invoice; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Barang Retur</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <select class="form-control" name="barang" id="barang" required>
                                            <?php
                                            $barang = $this->Penjualan_m->Detail_penjualan($id_jual)->result();
                                            foreach ($barang as $data_barang) {
                                                if ($data_barang->qty_jual > 0) {
                                            ?>
                                                    <option value="<?php echo $data_barang->id_barang; ?>"><?php echo $data_barang->nama_barang; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Retur</label>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <input type="number" class="form-control" id="qretur" name="qretur" autocomplete="off" value='1'>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" class="form-control" id="ket" name="ket" autocomplete="off">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Tambah Retur</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!----------------------------------------tabel--------------------------------------------------->
                    <form>
                        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Retur</th>
                                    <th>Harga Barang</th>
                                    <th>Subtotal</th>
                                    <th>Keterangan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $t_retur = 0;
                                $retur = $this->Penjualan_m->Detail_retur($id_jual)->result();
                                foreach ($retur as $data_retur) {
                                ?>
                                    <tr>
                                        <td><?php echo $data_retur->invoice; ?></td>
                                        <?php
                                        $brg = $this->Penjualan_m->Detail_barang($data_retur->id_barang)->row();
                                        ?>
                                        <td><?php echo $brg->nama_barang; ?></td>
                                        <td><?php echo $data_retur->qty_retur; ?></td>
                                        <td><?php echo $data_retur->harga_item; ?></td>
                                        <?php
                                        //hitung Total Retur
                                        $total = $data_retur->harga_item * $data_retur->qty_retur;
                                        ?>
                                        <td><?php echo $total; ?></td>
                                        <td><?php echo $data_retur->ket; ?></td>
                                        <td>
                                            <?php if ($data_retur->status == 0) { ?>
                                            <a href="<?php echo site_url() . 'Dpenjualan/Hapus_retur/' ?><?php echo $data_retur->id_retur; ?>/<?php echo $id_jual; ?>" title="Hapus Retur Penjualan" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
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
                        <table class="table table-striped">
                            <tr>
                                <td>
                                    <h3>Total Retur</h3>
                                </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td>
                                    <h3><?php echo $t_retur ?></h3>
                                </td>
                            </tr>
                        </table>
                        <div class="modal-footer">
                            <a href="<?php echo site_url() . 'Dpenjualan/Kembalikan_barang/' . $id_jual; ?>" class="btn btn-info">Simpan Retur</a>
                            <a href="<?php echo site_url() . 'Dpenjualan'; ?>" class="btn btn-primary">Batal</a>
                        </div>
                    </form>
                    <!----------------------------------------akhir Tabel---------------------------------------------->
                </div>
            </div>
        </div>
    </div>
</div>