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
                        $nota = $this->Pembelian_m->Daftar_pembelian_id($id_beli)->row();
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
                                        <?php echo $pegawai->nama_supplier; ?>
                                    </b>
                                </div>
                                <div class="col-md-4">
                                    <b>
                                        <?php echo date("d F Y H:i:s", strtotime($nota->tgl_faktur)); ?>
                                    </b>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                        <form class="form-horizontal" method="post" action="<?php echo site_url() . 'Dpembelian/Simpan_retur'; ?>">
                                <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="hidden" class="form-control" id="id_beli" name="id_beli" autocomplete="off" value="<?php echo $id_beli; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="hidden" class="form-control" id="id_supplier" name="id_supplier" autocomplete="off" value="<?php echo $nota->id_supplier; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="hidden" class="form-control" id="invoice" name="invoice" autocomplete="off" value="<?php echo $nota->faktur_beli; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Barang Retur</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <select class="form-control" name="barang" id="barang" required>
                                            <?php
                                            $barang = $this->Pembelian_m->Detail_v_pembelian($id_beli)->result();
                                            foreach ($barang as $data_barang) {
                                                if ($data_barang->qty_beli > 0) {
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
                                $retur = $this->Pembelian_m->Detail_retur($id_beli)->result();
                                foreach ($retur as $data_retur) {
                                ?>
                                    <tr>
                                        <td><?php echo $data_retur->faktur_beli; ?></td>
                                        <?php
                                        $brg = $this->Pembelian_m->Daftar_barang_id($data_retur->id_barang)->row();
                                        ?>
                                        <td><?php echo $brg->nama_barang; ?></td>
                                        <td><?php echo $data_retur->qty_retur; ?></td>
                                        <td><?php echo $data_retur->harga_item; ?></td>
                                        <?php
                                        //hitung Total Retur
                                        //$total = $brg->harga_jual * $data_retur->qty_retur;
                                        ?>
                                        <td><?php echo $data_retur->subtotal; ?></td>
                                        <td><?php echo $data_retur->ket; ?></td>
                                        <td>
                                            <?php if ($data_retur->status == 0) { ?>
                                            <a href="<?php echo site_url() . 'Dpembelian/Hapus_retur/' ?><?php echo $data_retur->id_retur; ?>/<?php echo $id_beli; ?>" title="Hapus Retur Penjualan" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                            <?php } ?>
                                        </td>
                                        <?php
                                        //itung total retur
                                        $t_retur = $t_retur + $data_retur->subtotal;
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
                            <a href="<?php echo site_url() . 'Dpembelian/Kembalikan_barang/' . $id_beli; ?>" class="btn btn-info">Simpan Retur</a>
                            <a href="<?php echo site_url() . 'Dpembelian'; ?>" class="btn btn-primary">Batal</a>
                        </div>
                    </form>
                    <!----------------------------------------akhir Tabel---------------------------------------------->
                </div>
            </div>
        </div>
    </div>
</div>