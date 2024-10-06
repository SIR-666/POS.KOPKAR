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
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <button type="button" class="btn btn-sm btn-primary" title="Tambah Cabang" data-toggle="modal" data-target="#inputCabangModal"><i class="fa fa-plus"></i> Tambah Cabang</button>
            <!-- <a href="<?php //echo site_url('report/kas')
                          ?>" target="_blank" class="btn btn-sm btn-default" title="Export PDF"><i class="fa fa-download"></i> Export PDF</a> -->
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php echo $this->session->flashdata('message'); ?>
            <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Telp</th>
                  <th>Fax</th>
                  <th>E-mail</th>
                  <th>Opsi</th>
                </tr>
              </thead>
              <?php
              $data['dtcabang'] = $this->Cabang_m->getAllData();
              foreach ($data['dtcabang'] as $data) {
              ?>
                <tr>
                  <td><?php echo $data["id_toko"]; ?></td>
                  <td><?php echo $data["nama_toko"]; ?></td>
                  <td><?php echo $data["alamat_toko"]; ?></td>
                  <td><?php echo $data["telp_toko"]; ?></td>
                  <td><?php echo $data["fax_toko"]; ?></td>
                  <td><?php echo $data["email_toko"]; ?></td>
                  <td>
                    <button type="button" class="btn btn-sm btn-primary btn-xs" title="Edit Cabang" data-toggle="modal" data-target="#editCabangModel<?php echo $data["id_toko"]; ?>"><i class="fa fa-edit"></i></button>
                    <!------------------------------------- modul edit cabang--------------------------------------------------------------------->
                    <div class="modal fade" id="editCabangModel<?php echo $data["id_toko"]; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">

                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                            <h4 class="modal-title" id="editCabangModal">Edit Data Cabang </h4>
                          </div>
                          <div class="modal-body">
                            <form class="form-horizontal" method="post" action="<?php echo site_url('Profil/Edit_cabang') ?>">
                              <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="hidden" class="form-control" id="id" name="id" autocomplete="off" value="<?php echo $data["id_toko"]; ?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Cabang</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" class="form-control" id="namacabang" name="namacabang" autocomplete="off" value="<?php echo $data["nama_toko"]; ?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat Cabang</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" class="form-control" id="alamatcabang" name="alamatcabang" autocomplete="off" value="<?php echo $data["alamat_toko"]; ?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Telp Toko</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" class="form-control" id="telp" name="telp" autocomplete="off" value="<?php echo $data["telp_toko"]; ?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Fax</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" class="form-control" id="fax" name="fax" autocomplete="off" value="<?php echo $data["fax_toko"]; ?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                  <input type="text" class="form-control" name="email" id="email" autocomplete="off" value="<?php echo $data["email_toko"]; ?>">
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

                    <a href="<?php echo site_url() . "profil/hapus_cabang/" . $data["id_toko"]; ?>"><button data-toggle="tooltip" title="Trash" class="btn btn-danger btn-xs"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>
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
<!------------------------------------- modul input cabang--------------------------------------------------------------------->
<div class="modal fade" id="inputCabangModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="inputCabangModal">Entry Data Cabang</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" action="<?php echo site_url('Profil/Add_cabang') ?>" enctype="multipart/form-data">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Cabang</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" id="namacabang" name="namacabang" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat Cabang</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" id="alamatcabang" name="alamatcabang" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Telp Toko</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" id="telp" name="telp" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Fax</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" id="fax" name="fax" autocomplete="off">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Email</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" name="email" id="email" autocomplete="off">
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
<!-----------------------------------------------end modul input cabang--------------------------------------------------->

<!-----------------------------------------------------------------------------script------------------------------------->

<!-----------------------------------------------------------------------------end script------------------------------------->