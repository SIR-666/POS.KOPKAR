<?php cek_user() ?>
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?php echo $title ?></h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12">
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
						<form class="form-horizontal" method="post" action="<?php echo site_url('stok/create') ?>">
							<div class="form-group">
								<input type="hidden" class="form-control" name="iditem" id="iditem" readonly>
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Barcode</label>
								<div class="input-group">
									<input type="text" class="form-control" name="barcode" id="barcode" autofocus onkeypress="scanBarcode()" autocomplete="off">
									<span class="input-group-btn">
										<button type="button" onclick="tampildata_brg()" class="btn btn-primary"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Barang</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input type="text" class="form-control" name="namabarang" id="namabarang" readonly>
									<input type="hidden" class="form-control" name="harga" id="harga" readonly>
									<input type="hidden" class="form-control" name="stok" id="stok">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<input type="number" class="form-control" name="jml" id="jml" required autocomplete="off">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<select name="jenis" id="jenis" class="form-control select2">
										<option value="Stok Masuk">Stok Masuk</option>
										<option value="Stok Keluar">Stok Keluar</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="3"></textarea>
								</div>
							</div>
							<div style="text-align: right">
								<button type="reset" class="btn btn-danger"><i class="fa fa-recycle m-right-xs"></i> Batal</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane-o m-right-xs"></i> Simpan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'dialog_brg.php' ?>
<?php include 'script.php' ?>