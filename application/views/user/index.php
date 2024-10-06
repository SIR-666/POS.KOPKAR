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
		 						<button type="button" class="btn btn-sm btn-primary" title="Tambah User" data-toggle="modal" data-target="#inputUserModal"><i class="fa fa-plus"></i> Tambah User</button>
		 						<div class="clearfix"></div>
		 					</div>
		 					<div class="x_content">
		 						<?php echo $this->session->flashdata('message'); ?>
		 						<table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" class="table table-striped">
		 							<thead>
		 								<tr>
		 									<th>Username</th>
		 									<th>Tipe User</th>
		 									<th>Nama Lengkap</th>
		 									<th>Alamat</th>
		 									<th>Telp</th>
		 									<th>Email</th>
		 									<th>Cabang</th>
		 									<th>Opsi</th>
		 								</tr>
		 							</thead>
		 							<?php
										$data['user'] = $this->User_m->getAllData();
										foreach ($data['user'] as $user) {
										?>
		 								<tr>
		 									<td><?php echo $user['username']; ?></td>
		 									<td><?php echo $user['tipe']; ?></td>
		 									<td><?php echo $user['nama_lengkap']; ?></td>
		 									<td><?php echo $user['alamat_user']; ?></td>
		 									<td><?php echo $user['telp_user']; ?></td>
		 									<td><?php echo $user['email_user']; ?></td>
		 									<td>
		 										<?php
													$datacabang = $this->Cabang_m->Select_cabang_byid($user['cabang'])->row();
													if ($user['cabang'] == 0) {
														echo "Holding";
													} else {
														echo $datacabang->nama_toko;
													}
													?>
		 									</td>
		 									<td>
		 										<button type="button" class="btn btn-sm btn-primary btn-xs" title="Edit User" data-toggle="modal" data-target="#editUserModel<?php echo $user['id_user']; ?>"><i class="fa fa-edit"></i></button>
		 										<!------------------------------------- modul edit user--------------------------------------------------------------------->
		 										<div class="modal fade" id="editUserModel<?php echo $user['id_user']; ?>">
		 											<div class="modal-dialog">
		 												<div class="modal-content">
		 													<div class="modal-header">
		 														<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
		 														</button>
		 														<h4 class="modal-title" id="editUserModal">Edit Data User </h4>
		 													</div>
		 													<div class="modal-body">
		 														<form class="form-horizontal" method="post" action="<?php echo site_url() . 'User/Edit_user' ?>">
		 															<div class="form-group">
		 																<div class="col-md-9 col-sm-9 col-xs-12">
		 																	<input type="hidden" class="form-control" id="iduser" name="iduser" autocomplete="off" value="<?php echo $user['id_user']; ?>">
		 																</div>
		 															</div>
		 															<div class="form-group">
		 																<label class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
		 																<div class="col-md-9 col-sm-9 col-xs-12">
		 																	<input type="text" class="form-control" id="username" name="username" autocomplete="off" value="<?php echo $user['nama_lengkap']; ?>" disabled="disabled">
		 																</div>
		 															</div>
		 															<div class="form-group">
		 																<label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Lengkap</label>
		 																<div class="col-md-9 col-sm-9 col-xs-12">
		 																	<input type="text" class="form-control" id="nama" name="nama" autocomplete="off" value="<?php echo $user['nama_lengkap']; ?>">
		 																</div>
		 															</div>
		 															<div class="form-group">
		 																<label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telp</label>
		 																<div class="col-md-9 col-sm-9 col-xs-12">
		 																	<input type="text" class="form-control" id="telp" name="telp" autocomplete="off" value="<?php echo $user['telp_user']; ?>">
		 																</div>
		 															</div>
		 															<div class="form-group">
		 																<label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
		 																<div class="col-md-9 col-sm-9 col-xs-12">
		 																	<input type="text" class="form-control" id="email" name="email" autocomplete="off" value="<?php echo $user['email_user']; ?>">
		 																</div>
		 															</div>
		 															<div class="form-group">
		 																<label class="control-label col-md-3 col-sm-3 col-xs-12">Tipe User</label>
		 																<div class="col-md-9 col-sm-9 col-xs-12">
		 																	<select id="tipe" name="tipe" class="form-control" required>
		 																		<?php
																					if ($user['tipe'] == "Administrator") {
																					?>
		 																			<option value="Kasir">Kasir</option>
		 																			<option value="Administrator" selected="selected">Administrator</option>
		 																		<?php
																					} else {
																					?>
		 																			<option value="Kasir" selected="selected">Kasir</option>
		 																			<option value="Administrator">Administrator</option>
		 																		<?php
																					}
																					?>
		 																		<option value="Kasir">Kasir</option>
		 																	</select>
		 																</div>
		 															</div>
		 															<div class="form-group">
		 																<label class="control-label col-md-3 col-sm-3 col-xs-12">Cabang</label>
		 																<div class="col-md-9 col-sm-9 col-xs-12">
		 																	<select id="cabanguser" name="cabanguser" class="form-control" required>
		 																		<?php
																					if ($user['cabang'] == 0) {
																					?>
		 																			<option value="0" selected="selected">Holding</option>
		 																			<?php
																						$cabang = $this->Cabang_m->getAllData();
																						foreach ($cabang as $cuser) {
																						?>
		 																				<option value="<?php echo $cuser['id_toko']; ?>"><?php echo $cuser['nama_toko']; ?></option>
		 																			<?php
																						}
																					} else {
																						?>
		 																			<option value="0" selected="selected">Holding</option>
		 																			<?php
																						$cabang = $this->Cabang_m->getAllData();
																						foreach ($cabang as $cuser) {
																							if ($cuser['id_toko'] == $user['cabang']) {
																						?>
		 																					<option value="<?php echo $cuser['id_toko']; ?>" selected="selected"><?php echo $cuser['nama_toko']; ?></option>
		 																				<?php
																							} else {
																							?>
		 																					<option value="<?php echo $cuser['id_toko']; ?>"><?php echo $cuser['nama_toko']; ?></option>
		 																				<?php
																							}
																							?>
		 																		<?php
																						}
																					}
																					?>
		 																	</select>
		 																</div>
		 															</div>
		 															<div class="form-group">
		 																<label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat</label>
		 																<div class="col-md-9 col-sm-9 col-xs-12">
		 																	<textarea col="7" rows="2" class="form-control" name="alamat" id="alamat"><?php echo $user['alamat_user']; ?></textarea>
		 																</div>
		 															</div>
		 															<div class="modal-footer">
		 																<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		 																<button type="submit" class="btn btn-primary">Save changes</button>
		 															</div>
		 														</form>
		 													</div>
		 												</div>
		 											</div>
		 										</div>
		 										<!-----------------------------------------------end modul edit cabang--------------------------------------------------->
		 										<a href="<?php echo site_url() . "user/hapususer/" . $user["id_user"]; ?>"><button data-toggle="tooltip" title="Trash" class="btn btn-danger btn-xs"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>
		 									</td>
		 								</tr>
		 							<?php
										}
										?>
		 						</table>
		 					</div>
		 				</div>
		 			</div>
		 		</div>
		 	</div>
		 </div>
		 <!------------------------------------- modul input user--------------------------------------------------------------------->
		 <div class="modal fade" id="inputUserModal">
		 	<div class="modal-dialog">
		 		<div class="modal-content">
		 			<div class="modal-header">
		 				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
		 				</button>
		 				<h4 class="modal-title" id="inputUserModal">Entry User</h4>
		 			</div>
		 			<div class="modal-body">
		 				<form class="form-horizontal" method="post" action="<?php echo site_url('user/inputuser') ?>">
		 					<div class="form-group">
		 						<label class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
		 						<div class="col-md-9 col-sm-9 col-xs-12">
		 							<input type="text" class="form-control" id="username" name="username" autocomplete="off">
		 						</div>
		 					</div>
		 					<div class="form-group">
		 						<label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Lengkap</label>
		 						<div class="col-md-9 col-sm-9 col-xs-12">
		 							<input type="text" class="form-control" id="nama" name="nama" autocomplete="off">
		 						</div>
		 					</div>
		 					<div class="form-group">
		 						<label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
		 						<div class="col-md-9 col-sm-9 col-xs-12">
		 							<input type="password" class="form-control" id="password" name="password">
		 						</div>
		 					</div>
		 					<div class="form-group">
		 						<label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telp</label>
		 						<div class="col-md-9 col-sm-9 col-xs-12">
		 							<input type="text" class="form-control" id="telp" name="telp" autocomplete="off">
		 						</div>
		 					</div>
		 					<div class="form-group">
		 						<label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
		 						<div class="col-md-9 col-sm-9 col-xs-12">
		 							<input type="text" class="form-control" id="email" name="email" autocomplete="off">
		 						</div>
		 					</div>
		 					<div class="form-group">
		 						<label class="control-label col-md-3 col-sm-3 col-xs-12">Tipe User</label>
		 						<div class="col-md-9 col-sm-9 col-xs-12">
		 							<select id="tipe" name="tipe" class="form-control" required>
		 								<option value=""></option>
		 								<option value="Kasir">Kasir</option>
		 								<option value="Administrator">Administrator</option>
		 							</select>
		 						</div>
		 					</div>
		 					<div class="form-group">
		 						<label class="control-label col-md-3 col-sm-3 col-xs-12">Cabang</label>
		 						<div class="col-md-9 col-sm-9 col-xs-12">
		 							<select id="cabanguser" name="cabanguser" class="form-control" required>
		 								<option value="0">Holding</option>
		 								<?php
											foreach ($cabang as $data_cabang) {
											?>
		 									<option value="<?php echo $data_cabang['id_toko']; ?>"><?php echo $data_cabang['nama_toko']; ?></option>
		 								<?php
											}
											?>
		 							</select>
		 						</div>
		 					</div>
		 					<div class="form-group">
		 						<label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat</label>
		 						<div class="col-md-9 col-sm-9 col-xs-12">
		 							<textarea col="7" rows="2" class="form-control" name="alamat" id="alamat"></textarea>
		 						</div>
		 					</div>
		 					<div class="modal-footer">
		 						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		 						<button type="submit" class="btn btn-primary">Save changes</button>
		 					</div>
		 				</form>
		 			</div>
		 		</div>
		 	</div>
		 </div>
		 <!-----------------------------------------------end modul input user--------------------------------------------------->