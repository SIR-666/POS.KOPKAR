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
		 			<div class="col-md-12 col-sm-12 col-xs-12">
		 				<div class="x_panel">
		 					<div class="x_title">
		 						<?php include 'inputcs.php' ?>
		 						<div class="clearfix"></div>
		 					</div>
		 					<div class="x_content">
		 						<?php echo $this->session->flashdata('message'); ?>
		 						<table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" class="table table-striped">
		 							<thead>
		 								<tr>
		 									<th>Nik</th>
		 									<th>Nama Customer</th>
		 									<th>Identitas</th>
		 									<th>Alamat</th>
		 									<th>Telp</th>
		 								</tr>
		 							</thead>
									<tbody>
										<?php 
											foreach ($dt as $rs) {
										?>
											<tr>
												<td><?= $rs->nik ?></td>
												<td><?= $rs->nama ?></td>
												<td><?= $rs->identitas ?></td>
												<td><?= $rs->alamat ?></td>
												<td><?= $rs->notelp ?></td>
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
		 <?php include 'editcs.php' ?>
		 <?php include 'import.php' ?>
		 <?php include 'script.php' ?>