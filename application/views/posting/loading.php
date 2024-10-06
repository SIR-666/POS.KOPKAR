<?php 
	$nextPage=$page+1;
?>
<script>
		setTimeout(function(){
				window.location.href = '<?php echo site_url("Posting/Proses/$nextPage"); ?>';
		}, 5000); 
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
							<div class="col-md-12 col-sm-12 col-xs-12">
								<h3>Perhatian !!!, Jangan tutup halaman ini sampai proses selesai</h3>
							</div>
						</div>
						<div class="row" style="border: 1 1 1 1;">
							<?php for ($x=1; $x <= $page; $x++) { ?>
								<div class="col-md-2" style="background-color: blue;">.</div>					
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
