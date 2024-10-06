		<footer>
			<div class="pull-right">
				Copyright &copy; Point Of Sales <?php echo date('Y') ?> by Pillar Sejahtera
			</div>
			<div class="clearfix"></div>
		</footer>
		</div>
		</div>
		<script src="<?php echo base_url('assets/') ?>vendors/jquery/dist/jquery.min.js"></script>
		<script src="<?php echo base_url('assets/') ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url('assets/') ?>vendors/fastclick/lib/fastclick.js"></script>
		<script src="<?php echo base_url('assets/') ?>vendors/nprogress/nprogress.js"></script>
		<script src="<?php echo base_url('assets/') ?>vendors/Chart.js/dist/Chart.min.js"></script>
		<script src="<?php echo base_url('assets/') ?>vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
		<script src="<?php echo base_url('assets/') ?>vendors/DateJS/build/date.js"></script>
		<script src="<?php echo base_url('assets/') ?>vendors/moment/min/moment.min.js"></script>
		<script src="<?php echo base_url('assets/') ?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
		<script src="<?php echo base_url('assets/') ?>build/js/custom.min.js"></script>
		<script src="<?php echo base_url('assets/') ?>bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
		<!-- <script src="<?php //echo base_url('assets/')
							?>select2/dist/js/select2.full.min.js"></script> -->
		<script type="text/javascript" src="<?php echo base_url('assets/'); ?>DataTables/datatables.min.js"></script>
		<script src="<?php echo base_url('assets/') ?>grafik/chart.js"></script>
		<script src="<?php echo base_url('assets/') ?>Javascript/Js-main.js"></script>
		<script src="<?php echo base_url('assets/') ?>Javascript/modjs-custom.js"></script>
		<script src="<?php echo base_url('assets/select2/select2.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/') ?>vendors/switchery/dist/switchery.min.js"></script>
		<!----------------------------------------------old data table------------------------------------------------>
		<script src="<?php echo base_url(); ?>assets/old-data-tables/bootstrap-table.js"></script>
		<script src="<?php echo base_url(); ?>assets/old-data-tables/tableExport.js"></script>
		<script src="<?php echo base_url(); ?>assets/old-data-tables/data-table-active.js"></script>
		<script src="<?php echo base_url(); ?>assets/old-data-tables/bootstrap-table-editable.js"></script>
		<script src="<?php echo base_url(); ?>assets/old-data-tables/bootstrap-editable.js"></script>
		<script src="<?php echo base_url(); ?>assets/old-data-tables/bootstrap-table-resizable.js"></script>
		<script src="<?php echo base_url(); ?>assets/old-data-tables/colResizable-1.5.source.js"></script>
		<script src="<?php echo base_url(); ?>assets/old-data-tables/bootstrap-table-export.js"></script>
		<!--  editable JS
				============================================ -->
		<script src="<?php echo base_url(); ?>assets/editable/jquery.mockjax.js"></script>
		<script src="<?php echo base_url(); ?>assets/editable/mock-active.js"></script>

		<script src="<?php echo base_url(); ?>assets/editable/moment.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/editable/bootstrap-datetimepicker.js"></script>
		<script src="<?php echo base_url(); ?>assets/editable/bootstrap-editable.js"></script>
		<script src="<?php echo base_url(); ?>assets/editable/xediable-active.js"></script>
		<!---------------------------------------------end old data table---------------------------------------------->

		<script>
			$(document).ready(function() {
				$('.select2').select2();
				$('.datatable').DataTable();
				$('.kode-servis').hide();
				$('.jatuh-tempo').hide();
				var persen_ppn = $('#ppn_persen');
				var subtotal = $('#subtotal');
				var grandtotal = $('#grandtotal');
				var ppn_rp = $('#nominal_ppn');
				persen_ppn.keyup(function() {
					var persen = document.getElementById('ppn_persen').value;
					if (persen == null || persen == 0) {
						grandtotal.val(subtotal.val());
						ppn_rp.val(0);
					} else {
						var nominal_ppn = subtotal.val() * persen_ppn.val() / 100;
						ppn_rp.val(nominal_ppn);
						var total = Number(subtotal.val()) + Number(nominal_ppn);
						grandtotal.val(total);

					}
				});

				$('input:radio[name="metode"]').on('change', function() {
					var pay = document.getElementById("bayar");
					var kembali = document.getElementById("kembali");
					var total = document.getElementById("grandtotal");
					if ($(this).is(':checked') && $(this).val() == "Cash") {
						$('.jatuh-tempo').hide();
						kembali.value = "";
						pay.removeAttribute("readonly");
					} else if ($(this).is(':checked') && $(this).val() == "Kredit") {
						$('.jatuh-tempo').show();
						pay.value = 0; // memberikan nilai pada elemen input
						pay.setAttribute("readonly", "readonly");
						kembali.value = (-1 * total.value);
					} else {
						$('.jatuh-tempo').hide();
						pay.removeAttribute("readonly");
						kembali.value = "";
					}
				});

				hitung_servis();
				diskon();
				totalbayar();
				invoice();
				discbeli();
				$('#ppn_persen').val(0);
				$('#nominal_ppn').val(0);
				$('#diskon1').val(0);
				$('#diskonbeli').val(0);
				$('#selisih').val(0);
				grafikKategori();
				grafikKas();
				grafikPendapatan();
				grafikTerlaris();
			})
			var table = $('#example').DataTable();

			$('#example').on('page.dt', function() {
				var page = table.page.info();
				for (let i = page.start; i < page.end; i++) {
					var kode = table.cell(i, 3).data();
					var coa = table.cell(i, 2).data();
					$.ajax({
						url: "<?= site_url('Posting/CekPosting') ?>",
						type: 'POST',
						dataType: 'json',
						data: {
							id: kode,
							coa: coa,
						},
						success: function(data) {
							//memasukkan data shift ke dalam form
							if (data.id == '') {
								table.cell(i, 7).data("<div id='" + kode + "'><i class='fa fa-times' style='color:red'></i></div>");
							} else {
								table.cell(i, 7).data("<div id='" + kode + "'><i class='fa fa-check' style='color:green'></i></div>");
							}
						},
					});

				}


			});

			table.on('search.dt', function() {
				var row = table.rows({
					search: 'applied'
				});
				var jml = table.rows({
					search: 'applied'
				}).count();
				console.log('halaman : ', jml);
				for (let i = 0; i < jml; i++) {
					var kode = table.cell(row[0][i], 3).data();
					var coa = table.cell(row[0][i], 2).data();
					if (i <= table.page.len()) {
						$.ajax({
							url: "<?= site_url('Posting/CekPosting') ?>",
							type: 'POST',
							dataType: 'json',
							data: {
								id: kode,
								coa: coa,
							},
							success: function(data) {
								//memasukkan data shift ke dalam form
								if (data.id == '') {
									table.cell(row[0][i], 7).data("<div id='" + kode + "'><i class='fa fa-times' style='color:red'></i></div>");
								} else {
									table.cell(row[0][i], 7).data("<div id='" + kode + "'><i class='fa fa-check' style='color:green'></i></div>");
								}
							},
						});
					} else {
						break;
					}
				}

			});

			table.on('click', 'button', function(e) {
				let data = table.row(e.target.closest('tr')).data();
				var i = data[0] -1;
            	table.cell(i, 7).data("<img src='../img/loading.gif' height='16px'>");
				$.ajax({
					url: "<?= site_url('Posting/Repost') ?>",
					type: 'POST',
					dataType: 'json',
					data: {
						tgl: data[1],
						coa: data[2],
						id: data[3],
						ket: data[4],
						debet: data[5],
						kredit: data[6],
					},
					success: function(res) {
						//memasukkan data shift ke dalam form
						if (res.id > 0) {

								var kode = table.cell(i, 3).data();
								var coa = table.cell(i, 2).data();
								$.ajax({
									url: "<?= site_url('Posting/CekPosting') ?>",
									type: 'POST',
									dataType: 'json',
									data: {
										id: kode,
										coa: coa,
									},
									success: function(data) {
										//memasukkan data shift ke dalam form
										if (data.id == '') {
											table.cell(i, 7).data("<div id='" + kode + "'><i class='fa fa-times' style='color:red'></i></div>");
										} else {
											table.cell(i, 7).data("<div id='" + kode + "'><i class='fa fa-check' style='color:green'></i></div>");
										}
									},
								});

							
						}
					},
				});
			});

			const timer = ms => new Promise(res => setTimeout(res, ms))
			async function test() { // We need to wrap the loop into an async function for this to work
				var jml = table.rows().count();
				for (var i = 0; i < jml; i++) {
					console.log(i);
					await timer(500); // then the created Promise can be awaited
				}
			}
		</script>
		</body>

		</html>