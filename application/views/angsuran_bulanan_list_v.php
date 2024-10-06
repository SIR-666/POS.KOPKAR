<!-- Styler -->
<style type="text/css">
	td,
	div {
		font-family: "Arial", "​Helvetica", "​sans-serif";
	}

	.datagrid-header-row * {
		font-weight: bold;
	}

	.messager-window * a:focus,
	.messager-window * span:focus {
		color: blue;
		font-weight: bold;
	}

	.daterangepicker * {
		font-family: "Source Sans Pro", "Arial", "​Helvetica", "​sans-serif";
		box-sizing: border-box;
	}

	.glyphicon {
		font-family: "Glyphicons Halflings"
	}
</style>

<?php
// buaat tanggal sekarang
$tanggal = date('Y-m-d H:i');
$tanggal_arr = explode(' ', $tanggal);
$txt_tanggal = jin_date_ina($tanggal_arr[0]);
$txt_tanggal .= ' - ' . $tanggal_arr[1];
?>

<!-- Data Grid -->
<table id="dg" class="easyui-datagrid" title="Posting Angsuran Bulanan" style="width:auto; height: auto;" url="<?php echo site_url('angsuran/ajax_angsuran_anggota'); ?>" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true" collapsible="true" sortName="nama" sortOrder="asc" toolbar="#tb" striped="true">
	<thead>
		<tr>
			<th data-options="field:'id', width:'17', halign:'center', align:'center'" hidden="true">ID Anggota</th>
			<th data-options="field:'nik', width:'15', halign:'center', align:'center'">ID Anggota</th>
			<th data-options="field:'nama', width:'25', halign:'center', align:'left'">Nama</th>
			<th data-options="field:'no_pinjaman', width:'15', halign:'center', align:'left'">ID Pinjaman</th>
			<th data-options="field:'bulan', width:'5', halign:'center', align:'center'">Bulan</th>
			<th data-options="field:'tahun', width:'5',halign:'center', align:'center'">Tahun</th>
			<th data-options="field:'jumlah', width:'15', halign:'center', align:'right'" hidden="true">jumlah</th>
			<th data-options="field:'jumlah_txt', width:'10', halign:'center', align:'right'">Jumlah</th>
			<th data-options="field:'bayar_jasa_pinjaman', width:'15', halign:'center', align:'right'" hidden="true">jumlah</th>
			<th data-options="field:'bunga_txt', width:'10', halign:'center', align:'right'">Jasa Pinjaman</th>
			<th data-options="field:'status', width:'15', halign:'center', align:'center'">Status Bayar </th>
			<!-- <th data-options="field:'del_posting', width:'10', halign:'center', align:'center'">Hapus Posting </th> -->
		</tr>
	</thead>
</table>

<!-- Toolbar -->
<div id="tb" style="height: 35px;">
	<div style="vertical-align: middle; display: inline; padding-top: 15px;">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="create()">Posting Angsuran </a>
	</div>
	<div class="pull-right" style="vertical-align: middle;">
		<select id="filter_bulan" name="filter_bulan" style="width:100px; height:27px">
			<option value="1" <?= date('m') == '1' ? ' selected ' : '' ?>> Januari </option>
			<option value="2" <?= date('m') == '2' ? ' selected ' : '' ?>> Pebruari </option>
			<option value="3" <?= date('m') == '3' ? ' selected ' : '' ?>> Maret </option>
			<option value="4" <?= date('m') == '4' ? ' selected ' : '' ?>> April </option>
			<option value="5" <?= date('m') == '5' ? ' selected ' : '' ?>> Mei </option>
			<option value="6" <?= date('m') == '6' ? ' selected ' : '' ?>> Juni </option>
			<option value="7" <?= date('m') == '7' ? ' selected ' : '' ?>> Juli </option>
			<option value="8" <?= date('m') == '8' ? ' selected ' : '' ?>> Agustus </option>
			<option value="9" <?= date('m') == '9' ? ' selected ' : '' ?>> September </option>
			<option value="10" <?= date('m') == '10' ? ' selected ' : '' ?>> Oktober </option>
			<option value="11" <?= date('m') == '11' ? ' selected ' : '' ?>> Nopember </option>
			<option value="12" <?= date('m') == '12' ? ' selected ' : '' ?>> Desember </option>
		</select>
		<select id="filter_tahun" name="filter_tahun" style="width:70px; height:27px">
			<?php
			$i = date('Y');
			for ($x = $i; $x >= 2020; $x--) {
			?>
				<option value="<?= $x ?>" <?= date('Y') == $x ? ' selected ' : '' ?>> <?= $x ?> </option>
			<?php
			}
			?>
		</select>
		<span>Cari :</span>
		<input name="kode_transaksi" id="kode_transaksi" size="22" style="line-height:25px;border:1px solid #ccc;">

		<a href="javascript:void(0);" id="btn_filter" class="easyui-linkbutton" iconCls="icon-search" plain="false" onclick="doSearch()">Cari</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-print" plain="false" onclick="cetak()">Cetak Laporan</a>
		<a href="javascript:void(0);" class="easyui-linkbutton" iconCls="icon-clear" plain="false" onclick="clearSearch()">Hapus Filter</a>
	</div>
</div>

<!-- Dialog Form -->
<div id="dialog-form" class="easyui-dialog" show="blind" hide="blind" modal="true" resizable="false" style="width:380px; height:250px; padding-left:20px; padding-top:20px; " closed="true" buttons="#dialog-buttons" style="display: none;">
	<form id="form" method="post" novalidate>
		<table>
			<tr>
				<td>
					<table>
						<tr style="height:35px">
							<td>Tanggal Transaksi </td>
							<td>:</td>
							<td>
								<div class="input-group date dtpicker col-md-5" style="z-index: 9999 !important;">
									<input type="text" name="tgl_transaksi_txt" id="tgl_transaksi_txt" style="width:150px; height:25px" required="true" readonly="readonly" />
									<input type="hidden" name="tgl_transaksi" id="tgl_transaksi" />
									<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								</div>
								<input type="hidden" id="alist" name="alist">
							</td>
						</tr>
						<tr style="height:35px">
							<td>Simpan Ke Kas</td>
							<td>:</td>
							<td>
								<select id="kas" name="kas_id" style="width:195px; height:25px" class="easyui-validatebox" required="true">
									<option value="0"> -- Pilih Kas --</option>
									<?php
									foreach ($kas_id as $row) {
										echo '<option value="' . $row->id . '">' . $row->nama . '</option>';
									}
									?>
								</select>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
</div>

<!-- Dialog Button -->
<div id="dialog-buttons">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="save()">Simpan</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:jQuery('#dialog-form').dialog('close')">Batal</a>
</div>

<script type="text/javascript">
	$(document).ready(function() {

		$('#dg').datagrid({
			pageList: [10, 20, 30, 40, 50, 100, 500],
		});

		function thousands_separators(num) {
			var num_parts = num.toString().split(".");
			num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			return num_parts.join(".");
		}

		$("#cari_simpanan").change(function() {
			$('#dg').datagrid('load', {
				cari_simpanan: $('#cari_simpanan').val(),
				filter_bulan: $('#filter_bulan').val(),
				filter_tahun: $('#filter_tahun').val()
			});
		});
		$("#filter_bulan").change(function() {
			$('#dg').datagrid('load', {
				cari_simpanan: $('#cari_simpanan').val(),
				filter_bulan: $('#filter_bulan').val(),
				filter_tahun: $('#filter_tahun').val()
			});
		});
		$("#filter_tahun").change(function() {
			$('#dg').datagrid('load', {
				cari_simpanan: $('#cari_simpanan').val(),
				filter_bulan: $('#filter_bulan').val(),
				filter_tahun: $('#filter_tahun').val()
			});
		});
		$("#kode_transaksi").keyup(function(event) {
			if (event.keyCode == 13) {
				$("#btn_filter").click();
			}
		});


		$("#kode_transaksi").keyup(function(e) {
			var isi = $(e.target).val();
			$(e.target).val(isi.toUpperCase());
		});


	}); // ready
</script>

<script type="text/javascript">
	var url;

	function form_select_clear() {
		$('select option')
			.filter(function() {
				return !this.value || $.trim(this.value).length == 0;
			})
			.remove();
		$('select option')
			.first()
			.prop('selected', true);
	}

	function doSearch() {
		$('#dg').datagrid('load', {
			cari_simpanan: $('#cari_simpanan').val(),
			filter_bulan: $('#filter_bulan').val(),
			filter_tahun: $('#filter_tahun').val(),
			kode_transaksi: $('#kode_transaksi').val(),
		});
	}

	function clearSearch() {
		location.reload();
	}

	function create() {
		$('#dialog-form').dialog('open').dialog('setTitle', 'Posting Simpanan Bulanan');
		$('#form').form('clear');
		$('#tgl_transaksi_txt').val('<?php echo $txt_tanggal; ?>');
		$('#tgl_transaksi').val('<?php echo $tanggal; ?>');
		$('#kas option[value="0"]').prop('selected', true);
		oSimpanan = document.getElementById("cari_simpanan");
		oBulan = document.getElementById("filter_bulan");
		oTahun = document.getElementById("filter_tahun");
		url = '<?php echo site_url('angsuran/posting_bulk'); ?>';
	}

	function coData() {
		let list = $('#dg').datagrid('getData');
		let oBulan = document.getElementById("filter_bulan").value;
		let oTahun = document.getElementById("filter_tahun").value;
		let oKas = document.getElementById("kas").value;
		let oTgl = document.getElementById("tgl_transaksi").value;
		let oData = {
			'list': list,
			'bulan': oBulan,
			'tahun': oTahun,
			'kas': oKas,
			'tgl': oTgl
		}
		return oData;
	}

	function save() {
		var string = $("#form").serialize();
		var pl = coData();
		//validasi teks kosong

		var kas = $("#kas").val();
		if (kas == 0) {
			$.messager.show({
				title: '<div><i class="fa fa-warning"></i> Peringatan ! </div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Simpan Ke Kas belum dipilih.</div>',
				timeout: 2000,
				showType: 'slide'
			});
			$("#kas").focus();
			return false;
		}

		var isValid = $('#form').form('validate');
		if (isValid) {
			$.ajax({
				type: "POST",
				url: url,
				data: pl,
				success: function(result) {
					var result = eval('(' + result + ')');
					$.messager.show({
						title: '<div><i class="fa fa-info"></i> Informasi</div>',
						msg: result.msg,
						timeout: 2000,
						showType: 'slide'
					});
					if (result.ok) {
						jQuery('#dialog-form').dialog('close');
						//clearSearch();
						$('#dg').datagrid('reload');
					}
				}
			});
		} else {
			$.messager.show({
				title: '<div><i class="fa fa-info"></i> Informasi</div>',
				msg: '<div class="text-red"><i class="fa fa-ban"></i> Maaf, Lengkapi seluruh pengisian data.</div>',
				timeout: 2000,
				showType: 'slide'
			});
		}
	}


	function cetak() {
		var kode_transaksi = $('#kode_transaksi').val();
		var bulan = $('#filter_bulan').val();
		var tahun = $('#filter_tahun').val();

		var win = window.open('<?php echo site_url("angsuran/cetak_laporan_posting_bulanan/?&kode_transaksi=' + kode_transaksi + '&bln=' + bulan + '&thn=' + tahun + '"); ?>');
		if (win) {
			win.focus();
		} else {
			alert('Popup jangan di block');
		}
	}
</script>