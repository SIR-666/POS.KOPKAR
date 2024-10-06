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
				   <select style="width:150px;height:25px" id="bulan" name="bulan" onChange="RedirectData()">
              <option value="1" <?= $bln == '1' ? ' selected ' : '' ?>>Januari</option>
              <option value="2" <?= $bln =='2' ? ' selected ' : '' ?>>Februari</option>
              <option value="3" <?= $bln == '3' ? ' selected ' : '' ?>>Maret</option>
              <option value="4" <?= $bln == '4' ? ' selected ' : '' ?>>April</option>
              <option value="5" <?= $bln ==  '5' ? ' selected ' : '' ?>>Mei</option>
              <option value="6" <?= $bln == '6' ? ' selected ' : '' ?>>Juni</option>
              <option value="7" <?= $bln == '7' ? ' selected ' : '' ?>>Juli</option>
              <option value="8" <?= $bln == '8' ? ' selected ' : '' ?>>Agustus</option>
              <option value="9" <?= $bln == '9' ? ' selected ' : '' ?>>September</option>
              <option value="10" <?= $bln == '10' ? ' selected ' : '' ?>>Oktober</option>
              <option value="11" <?= $bln == '11' ? ' selected ' : '' ?>>November</option>
              <option value="12" <?= $bln == '12' ? ' selected ' : '' ?>>Desember</option>
            </select>
            <?php                 
                $cTh = intval(date('Y'));
                
            ?>
            <select style="width:70px;height:25px" id="tahun" name="tahun" onChange="RedirectData()">
              <?php
                for ($x = $cTh; $x >= 2022; $x--) {
                  if ($x == $thn) {
                    echo "<option value='" . $x . "' selected>".$x."</option>";
                  } else {
                    echo "<option value='" . $x . "' >".$x."</option>";
                  }
                  
                }   
              ?>
            </select> 					
                     <ul class="nav navbar-right panel_toolbox">
		               <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
		               </li>
		               <li><a class="close-link"><i class="fa fa-close"></i></a>
		               </li>
		             </ul>
		             <div class="clearfix"></div>
		           </div>
		           <div class="x_content">
                   <?php echo $this->session->flashdata('message'); ?>
                     <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nomor Faktur</th>
                                <th>Tgl Faktur</th>
                                <th>Supplier</th>
                                <th>Jml Item</th>
                                <th>Total</th>
                                <th>Payment Method</th>
                                <th>Opsi</th>                                       
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							//data Pembelian
							foreach($pembelian as $data_beli)
							{
							?>
                                <tr>
                                	<td><?php echo $data_beli->kode_beli;?></td>
                                    <td><?php echo $data_beli->faktur_beli;?></td>
                                    <td><?php echo date("d-m-Y", strtotime($data_beli->tgl_faktur));?></td>
                                    <td><?php echo $data_beli->nama_supplier;?></td>
                                    <td><?php echo $data_beli->item;?></td>
                                    <td><?php echo number_format($data_beli->total, 2, ',', '.');?></td>
                                    <td><?php echo $data_beli->method;
										if ($data_beli->method == 'Cash') {
											$jn =  $this->Pembelian_m->GetPaymentMethod($data_beli->kode_beli);
											echo "<small> (" . $jn . ")</small>";
										}
									?></td>
                                    <td>
                                    <a href="#" data-target="#detilPembelianModal<?php echo $data_beli->id_beli;?>" data-toggle="modal" title="Detail Pembelian" class="btn btn-primary btn-xs"><i class="fa fa-search-plus"></i></a>
                                    <a href="<?php echo site_url() . 'Dpembelian/retur/'.$data_beli->id_beli;?>" title="Retur Pembelian" class="btn btn-warning btn-xs"><i class="fa fa-retweet"></i></a>
									<!-------------------------------------------------------modal beli-------------------------------------------->
                                    <?php
									$tobeli=0;
									?>
									<div class="modal fade" id="detilPembelianModal<?php echo $data_beli->id_beli;?>" role="dialog">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
													</button>
														<h4 class="modal-title" id="detilPenjualanModal<?php echo $data_beli->id_beli;?>">Detail Pembelian</h4>
												</div>
												<div class="modal-body">
													<div class="tabel-produk">
														<h5><i class="fa fa-folder-open"></i> Produk</h5>
														<table id="detiljual" width="100%" class="table table-striped table-bordered">
															<thead>
																<tr>
                                                                    <th>Kode Detail</th>
                                                                    <th>Nama Item</th>
                                                                    <th>Harga Beli</th>
                                                                    <th>Harga Jual</th>
                                                                    <th>Qty</th>
                                                                    <th>Subtotal</th>
																</tr>
															</thead>
														    <tbody>
																<?php
																	$detail=$this->Pembelian_m->Detil_pembelian($data_beli->id_beli)->result();
																	foreach($detail as $data_detail)
																	{
																	?>
																	<tr>
                                                                    <td><?php echo $data_detail->kode_detil_beli;?></td>
                                                                    <?php
                                                                    //barang
                                                                    $barang=$this->Pembelian_m->Daftar_barang_id($data_detail->id_barang)->row();
                                                                    ?>
                                                                    <td><?php echo $barang->nama_barang;?></td>
                                                                    <td><?php echo number_format($barang->harga_beli, 3, ',', '');?></td>
                                                                    <td><?php echo number_format($barang->harga_jual, 0, ',', '');?></td>
                                                                    <td><?php echo $data_detail->qty_beli;?></td>
                                                                    <td><?php echo number_format($data_detail->subtotal, 3, ',', '');?></td>
																	</tr>
																	<?php
																	}
																	?>
																	</tbody>
																</table>
															</div>
															<div class="modal-footer">
															</div>
														</div>
													</div>
												</div>
											</div>
                                    <!-------------------------------------------------------akhir modal beli-------------------------------------------->
									</td>
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
		 </div>

		 <script>
  function RedirectData() {
    var b = document.getElementById("bulan");
    var t = document.getElementById("tahun"); 
    window.location.replace('<?= site_url('dpembelian') ?>/index/' + b.value + '/' + t.value );
  }

</script>