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
          <div class="col-md-6 col-sm-6 col-xs-12">
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
                <form class="form-horizontal" method="post" action="<?php echo site_url('report/penjualan') ?>">
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <label for="">Tanggal Awal :</label>
                      <input type="date" id="awal" class="form-control datepicker" name="awal" required />
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <label for="">Tanggal Akhir :</label>
                      <input type="date" id="akhir" class="form-control datepicker" name="akhir" required />
                    </div>
                    <?php
                      $kasir=$this->Penjualan_m->Peg_kasir($user['cabang'])->result();
                    ?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <label for="kasir">Kasir :</label>
                     <select name="kasir" id="kasir" class="form-control">
                     <option value="all">Semua Kasir</option>
                      <?php
                        foreach($kasir as $data_kasir)
                        {
                      ?>
                        <option value="<?php echo $data_kasir->id_user;?>"><?php echo $data_kasir->nama_lengkap;?></option>
                      <?php
                        }
                      ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-12 col-sm-6 col-xs-12">
                      <button type="submit" class="btn btn-sm btn-primary btn-block"><i class="fa fa-file-pdf-o"></i> Export PDF</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>