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
                                <th>Invoice</th>
                                <th>Kasir</th>
                                <th>Customer</th>
                                <th>Diskon</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Items</th>
                                <th>Waktu</th>
								<th>Posting</th>
                                <th>Opsi</th>                                       
                            </tr>
                        </thead>
                        <tbody>
							<?php
							//data penjualan
							foreach($penjualan as $data_jual)
							{
							?>
							 	<tr>
                                	<td><?php echo $data_jual->invoice;?></td>
									<td><?php echo $data_jual->nama_lengkap;?></td>
									<td><?php echo $data_jual->nama;?></td>
									<td><?php echo $data_jual->diskon;?></td>
									<td><?php echo $data_jual->total;?></td>
									<td><?php echo $data_jual->method;?></td>
									<td><?php echo $data_jual->qty;?></td>
									<td><?php echo date("d-m-Y H:i:s", strtotime($data_jual->tgl));?></td>
									<td><?php echo $data_jual->kode_jual;?></td>
									<td>
										<a href="#" data-target="#detilPenjualanModal<?php echo $data_jual->id_jual;?>" data-toggle="modal" title="Detail Penjualan" class="btn btn-primary btn-xs"><i class="fa fa-search-plus"></i></a>
										<a href="<?php echo site_url() . 'Report/struk_penjualan/'.$data_jual->id_jual;?>" title="Cetak Nota Penjualan" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a>
										<a href="<?php echo site_url() . 'Dpenjualan/retur/'.$data_jual->id_jual;?>" title="Retur Penjualan" class="btn btn-warning btn-xs"><i class="fa fa-retweet"></i></a>
										<!-------------------------------------------------------modal jual-------------------------------------------->
											<div class="modal fade" id="detilPenjualanModal<?php echo $data_jual->id_jual;?>" role="dialog">
												<div class="modal-dialog modal-lg">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
															</button>
															<h4 class="modal-title" id="detilPenjualanModal<?php echo $data_jual->id_jual;?>">Detail Penjualan</h4>
														</div>
														<div class="modal-body">
															<div class="tabel-produk">
																<h5><i class="fa fa-folder-open"></i> Produk</h5>
																<table id="detiljual" width="100%" class="table table-striped table-bordered">
																	<thead>
																		<tr>
																			<th>Kode Detail</th>
																			<th>Nama Item</th>
																			<th>Harga</th>
																			<th>Qty</th>
																			<th>Diskon</th>
																			<th>Subtotal</th>
																		</tr>
																	</thead>
																	<tbody>
																	<?php
																	$detail=$this->Penjualan_m->Detail_penjualan2($data_jual->id_jual)->result();
																	foreach($detail as $data_detail)
																	{
																	?>
																	<tr>
																		<td><?php echo $data_detail->kode_detil_jual;?></td>
																		<td><?php echo $data_detail->nama_barang;?></td>
																		<td><?php echo $data_detail->harga_item;?></td>
																		<td><?php echo $data_detail->qty_jual;?></td>
																		<td><?php echo $data_detail->diskon;?></td>
																		<td><?php echo $data_detail->subtotal;?></td>
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
											<!---------------------------------akhir detil jual------------------------------------------------->
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
    window.location.replace('<?= site_url('dpenjualan') ?>/index/' + b.value + '/' + t.value );
  }

</script>	