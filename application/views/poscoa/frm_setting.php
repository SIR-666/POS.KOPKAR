<?php 
	if ($this->session->cabang == 0) {
		$namaToko = "Holding";
		$alamat = "";
		$telp = "";
		$coa1 = "";
		$coa2 = "";
		$coa3 = "";
		$coa4 = "";
	} else {
		$namaToko = $toko->nama_toko;
		$alamat = $toko->alamat_toko;
		$telp = $toko->telp_toko;
		$coa_cash = $toko->coa_cash;
		$coa_transfer = $toko->coa_transfer;
		$coa_kredit = $toko->coa_kredit;
	}
?>
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
		 	<div class="title_left">
		 		<h3><?php echo $title ?></h3>
		 	</div>
		</div>
		<div class="clearfix"></div>
        <div class="clearfix">&nbsp;</div>

		<?php 
			if ($this->session->flashdata('message')) {
				echo "<div class='alert alert-warning'><b>" . $this->session->flashdata('message') . "</b></div>"; 
			}
		?>
	 	<form class="form-horizontal" method="post" action="<?php echo site_url('Poscoa/Simpan') ?>">
			<div class="row" align ="right">
				<div class="col-md-12">
					<input type="submit" value="Simpan" name="simpan" class="btn btn-primary">
				</div>
			</div>
		 	<div class="row">
                <div class="col-md-4 col-sm-12 col-xs-12">
		 			<div class="x_panel">
		 				<div class="x_title">
                            <b>Informasi</b>
		 					<div class="clearfix"></div>
		 			    </div>
		 			    <div class="x_content">
                            <p><b>Toko / Cabang : </b> <?= $namaToko ?></p>
                            <p><b>Alamat :</b> <?= $alamat ?></p>
                            <p><b>Telp :</b> <?= $telp ?></p> 
							<div id="selector" style="color:white;"></div>
		 			    </div>
		 		    </div>
                </div>

            <div class="col-md-5 col-sm-12 col-xs-12">
		 		<div class="x_panel">
		 			<div class="x_title">
                        <b>COA KAS Penjualan</b>
		 				<div class="clearfix"></div>
					</div>	
		 			<div class="x_content">
						<div class="form-group">
							<label class="col-md-4 col-sm-4 col-xs-12">COA Cash</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select id="coa_cash" name="coa_cash" class="form-control" required>
									<option value="all">Pilih Akun</option>
									<?php
										foreach ($coa as $akun) {
											$spasi = '';
											for ($x = 0; $x <= $akun->itCOALevel; $x++) {
											$spasi = $spasi . '&nbsp;&nbsp;&nbsp;'; 
											}
											if($akun->vcCOACode == $toko->coa_cash){
											?>
											<option selected="selected" value="<?php echo $akun->vcCOACode?>" <?= $akun->itCOAType == 0 ? ' disabled ' : '' ?>><?php echo $spasi . $akun->vcCOAName?></option>
											<?php
											}else{
											?>
											<option value="<?php echo $akun->vcCOACode?>" <?= $akun->itCOAType == 0 ? ' disabled ' : '' ?>><?php echo $spasi . $akun->vcCOAName?></option>
											<?php
											}
										}
                      				?>		
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 col-sm-4 col-xs-12">COA Transfer</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select id="coa_transfer" name="coa_transfer" class="form-control" required>
									<option value="all">Pilih Akun</option>
									<?php
										foreach ($coa as $akun) {
											$spasi = '';
											for ($x = 0; $x <= $akun->itCOALevel; $x++) {
											$spasi = $spasi . '&nbsp;&nbsp;&nbsp;'; 
											}
											if($akun->vcCOACode == $toko->coa_transfer){
											?>
											<option selected="selected" value="<?php echo $akun->vcCOACode?>" <?= $akun->itCOAType == 0 ? ' disabled ' : '' ?>><?php echo $spasi . $akun->vcCOAName?></option>
											<?php
											}else{
											?>
											<option value="<?php echo $akun->vcCOACode?>" <?= $akun->itCOAType == 0 ? ' disabled ' : '' ?>><?php echo $spasi . $akun->vcCOAName?></option>
											<?php
											}
										}
                      				?>		
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 col-sm-4 col-xs-12">COA Kredit</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select id="coa_kredit" name="coa_kredit" class="form-control" required>
									<option value="all">Pilih Akun</option>
									<?php
										foreach ($coa as $akun) {
											//edit
											$spasi = '';
											for ($x = 0; $x <= $akun->itCOALevel; $x++) {
											$spasi = $spasi . '&nbsp;&nbsp;&nbsp;'; 
											}
											if($akun->vcCOACode == $toko->coa_kredit){
											?>
											<option selected="selected" value="<?php echo $akun->vcCOACode?>" <?= $akun->itCOAType == 0 ? ' disabled ' : '' ?>><?php echo $spasi . $akun->vcCOAName?></option>
											<?php
											}else{
											?>
											<option value="<?php echo $akun->vcCOACode?>" <?= $akun->itCOAType == 0 ? ' disabled ' : '' ?>><?php echo $spasi . $akun->vcCOAName?></option>
											<?php
											}
										}
                      				?>		
								</select>
							</div>
						</div>
		 			</div>
		 		</div>
			</div>
 				<!-- <div class="col-md-4 col-sm-12 col-xs-12">
		 					<div class="x_panel">
		 						<div class="x_title">
                                    <b>COA untuk Transaksi Pembelian</b>
		 							<div class="clearfix"></div>
		 						</div>
		 						<div class="x_content">

		 							<!-- <div class="form-group barcode-produk">
		 								<input type="hidden" class="form-control" name="idbarangitem" id="idbarangitem" readonly>
		 								<label class="control-label col-md-4 col-sm-4 col-xs-12" style="margin-right:9px">Jurnal Debet</label>
		 								<div class="input-group">
		 									<input type="text" class="form-control" name="coa2" value="<?= $coa2 ?>" id="coa2" autofocus autocomplete="off" ">
		 									<span class="input-group-btn">
		 										<button type="button" class="btn btn-info" onClick="SetSelector(2)" data-toggle="modal" data-target="#dataCoa"><i class="fa fa-search"></i></button>
		 									</span>
		 								</div>
		 							</div>
		 							<div class="form-group barcode-produk">
		 								<input type="hidden" class="form-control" name="idbarangitem" id="idbarangitem" readonly>
		 								<label class="control-label col-md-4 col-sm-4 col-xs-12" style="margin-right:9px">Jurnal Kredit</label>
		 								<div class="input-group">
		 									<input type="text" class="form-control" name="coa4" id="coa4" value="<?= $coa4 ?>" autofocus autocomplete="off">
		 									<span class="input-group-btn">
		 										<button type="button"  onClick="SetSelector(4)" class="btn btn-info" data-toggle="modal" data-target="#dataCoa"><i class="fa fa-search"></i></button>
		 									</span>
		 								</div>
		 							</div> -->
		 						</div>
		 					</div>
		 		</div> -->
		 	</div>
		</form>

		
	</div>
</div>


<div class="modal fade" id="dataCoa">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">

		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
		  </button>
		  <h4 class="modal-title" id="inputSupplierModal">Pilih Chart of Account</h4>
		</div>
		<div class="modal-body">
			<table id="tableCoa" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" class="table table-striped" width="100%">
				<thead>
					<tr>
						<td>Kode</td>
						<td>Nama</td>
						<td>Grup Akun</td>
						<td>Tipe</td>
						<td>Balance</td>
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach ($coa as $dt) { ?>
						<tr>
							<td><u><a href="#" onClick="SetValue('<?= $dt->vcCOACode ?>')" data-dismiss="modal" ><?= $dt->vcCOACode ?></a></u></td>
							<td><?php 
									//echo $dt->itCOALevel;
									for ($x = 0; $x <= $dt->itCOALevel;$x++) {
										echo '&nbsp;&nbsp;&nbsp;';
									}
									echo $dt->vcCOAName 

								?>
							</td>
							<td><?= $dt->vcGroupName ?></td>
							<td><?= $dt->itCOAType == '0' ? 'Header' : 'Item'  ?></td>
							<td><?= $dt->vcCOABalanceType == 'D' ? 'Debet' : 'Kredit' ?></td>
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

  <script src="<?php echo site_url('assets/') ?>vendors/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo site_url('assets/'); ?>DataTables/datatables.min.js"></script>

<script>
  $(document).ready( function () {
    $('#tableCoa').DataTable();
} );
</script>

<script>
	function SetSelector(a) {
		document.getElementById("selector").innerHTML = "coa"+a;
	}

	function SetValue(a) {
		se = document.getElementById("selector").innerHTML;
		document.getElementById(se).value = a; 
	}
</script>