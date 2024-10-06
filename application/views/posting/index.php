<script>
	function CekPosting(id,coa) {
		$.ajax({
			url: "<?= site_url('Posting/CekPosting') ?>",
			type: 'POST',
			dataType: 'json',
			data: {
				id: id,
				coa: coa,
			},
			success: function(data) {
				//memasukkan data shift ke dalam form
				if (data.id == '') {
					return "<i class='fa fa-times' style='color:red'></i>";
				} else {
					return "<i class='fa fa-check' style='color:green'></i>";
				}
			},
		});
	}



</script>
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="title_left">
				<h3><?php echo $title ?></h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php echo $this->session->flashdata('message'); ?>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<div class="row">
							<div class="col-md-10 col-sm-12 col-xs-12">

								<form method="post" class="form">
									<table>
										<tr>
											<td style="text-align:right" width="70px"><label>Bulan &nbsp;&nbsp;&nbsp;&nbsp;</label></td>
											<td>
												<select name="bulan" class="form-control">
													<option value="1" <?= $filter_bulan == 1 ? ' selected ' : '' ?>>Januari</option>
													<option value="2" <?= $filter_bulan == 2 ? ' selected ' : '' ?>>Februari</option>
													<option value="3" <?= $filter_bulan == 3 ? ' selected ' : '' ?>>Maret</option>
													<option value="4" <?= $filter_bulan == 4 ? ' selected ' : '' ?>>April</option>
													<option value="5" <?= $filter_bulan == 5 ? ' selected ' : '' ?>>Mei</option>
													<option value="6" <?= $filter_bulan == 6 ? ' selected ' : '' ?>>Juni</option>
													<option value="7" <?= $filter_bulan == 7 ? ' selected ' : '' ?>>Juli</option>
													<option value="8" <?= $filter_bulan == 8 ? ' selected ' : '' ?>>Agustus</option>
													<option value="9" <?= $filter_bulan == 9 ? ' selected ' : '' ?>>September</option>
													<option value="10" <?= $filter_bulan == 10 ? ' selected ' : '' ?>>Oktober</option>
													<option value="11" <?= $filter_bulan == 11 ? ' selected ' : '' ?>>November</option>
													<option value="12" <?= $filter_bulan == 12 ? ' selected ' : '' ?>>Desember</option>
												</select>
											</td>
											<td style="text-align:right" width="70px">
												<label>Tahun &nbsp;&nbsp;&nbsp;&nbsp;</label>
											</td>
											<td>
												<select name="tahun" class="form-control">
													<?php
													for ($x = date('Y'); $x >= 2023; $x--) {
														if ($filter_tahun == $x) {
															echo "<option value=" . $x . " selected >" . $x . "</option>";
														} else {
															echo "<option value=" . $x . " >" . $x . "</option>";
														}
													}
													?>
												</select>
											</td>
											<td>
												&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary" style="margin-top:5px;"><i class="fa fa-search"></i> Tampilkan </button>
											</td>
										</tr>
									</table>




								</form>
							</div>
							<div class="col-md-2" align="right">
								<a href="<?= site_url('Posting/Proses'); ?>" class="btn btn-warning"><i class="fa fa-gears"></i> Posting Journal</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="x_panel">
					<div class="x_content">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<table class="table table-bordered table-striped table-hover " id="example">
									<thead>
										<tr>
											<th>No</th>
											<th>Tanggal</th>
											<th>COA</th>
											<th>ID Journal</th>
											<th>Keterangan</th>
											<th>Debet</th>
											<th>Kredit</th>
											<th>Status Posting</th>
											<th>Repost</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no = 1;
										$totalDebet = 0;
										$totalKredit = 0;
										foreach ($list as $ls) {

											$totalDebet += $ls['cuJournalDebet'];

											$totalKredit += $ls['cuJournalCredit'];

										?>
											<tr>
												<td><?= $no ?></td>
												<td><?= $ls['dtJournal'] ?></td>
												<td><?= $ls['vcCOAJournal'] ?></td>
												<td><?= $ls['vcIDJournal'] ?></td>
												<td><?= $ls['vcJournalDesc'] ?></td>
												<td align="right"><?= number_format($ls['cuJournalDebet'], 2) ?></td>
												<td align="right"><?= number_format($ls['cuJournalCredit'], 2) ?></td>
												<td align="center">
													<?php
													if ($no <= 50) {
														$res = $this->Posting_m->CekPosting($ls['vcIDJournal'],$ls['vcCOAJournal']);
														if ($res['id'] == '') {
															echo "<div id='" . $ls['vcIDJournal'] . "'><i class='fa fa-times' style='color:red'></i></div>";
														} else {
															echo "<div id='" . $ls['vcIDJournal'] . "'><i class='fa fa-check' style='color:green'></i></div>";
														}
													} else {
														echo "<div id='" . $ls['vcIDJournal'] . "'>" . '<img src="img/loading.gif" height="16px"></div>';
													}
													?>
												</td>
												<td align="center"><button  class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i></button></td>
											</tr>
										<?php
											$no++;
										}
										?>
									</tbody>
									<tfoot>
										<tr>
											<th style="color:white;"><?= $no ?></th>
											<th></th>
											<th></th>
											<th style="color:white;">zzzzzz</th>
											<th>Total</th>
											<th style="text-align:right;"><?= number_format($totalDebet, 2) ?></th>
											<th style="text-align:right;"><?= number_format($totalKredit, 2) ?></th>
											<th></th>
											<th></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function test1() {
		console.log(table.page.info().page);
		table.cell()
	}
</script>