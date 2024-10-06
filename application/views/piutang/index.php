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
          <select style="width:150px;height:25px" id="bulan" name="bulan" onChange="RedirectData()">
              <option value="1" <?= $bln == '1' ? ' selected ' : '' ?>>Januari</option>
              <option value="2" <?= $bln =='2' ? ' selected ' : '' ?>>Februari</option>
              <option value="3" <?= $bln == '3' ? ' selected ' : '' ?>>Maret</option>
              <option value="4" <?= $bln == '4' ? ' selected ' : '' ?>>April</option>
              <option value="5" <?= $bln ==  '5' ? ' selected ' : '' ?>>Mei</option>
              <option value="6" <?= $bln == '6' ? ' selected ' : '' ?>>Juni</option>
              <option value="7" <?= $bln == '7' ? ' selected ' : '' ?>>Juli</option>
              <option value="8" <?= $bln == '8' ? ' selected ' : '' ?>>Agustus</option>
              <option value="9" <?= $bln == '9' ? ' selected ' : '' ?>>September</option>
              <option value="10" <?= $bln == '10' ? ' selected ' : '' ?>>Oktober</option>
              <option value="11" <?= $bln == '11' ? ' selected ' : '' ?>>November</option>
              <option value="12" <?= $bln == '12' ? ' selected ' : '' ?>>Desember</option>
            </select>
            <?php                 
                $cTh = intval(date('Y'));
                
            ?>
            <select style="width:70px;height:25px" id="tahun" name="tahun" onChange="RedirectData()">
              <?php
                for ($x = $cTh; $x >= 2022; $x--) {
                  if ($x == $thn) {
                    echo "<option value='" . $x . "' selected>".$x."</option>";
                  } else {
                    echo "<option value='" . $x . "' >".$x."</option>";
                  }
                  
                }   
              ?>
            </select>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <?php echo $this->session->flashdata('message'); ?>

            <table width="100%" class="table table-striped table-bordered datatable">
              <thead>
                <tr>
                  <th>Invoice</th>
                  <th>Customer</th>
                  <th>Tgl. Piutang</th>
                  <th>Jatuh Tempo</th>
                  <th>Jml. Piutang</th>
                  <th>Jml. Bayar</th>
                  <th>Sisa</th>
                  <th>Status</th>
                  <th>Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($piutang as $val) { ?>
                  <tr>
                    <td><?php echo $val['invoice'] ?></td>
                    <td><?php echo $val['nama'] ?></td>
                    <td><?php echo $val['tgl_piutang'] ?></td>
                    <td><?php echo $val['jatuh_tempo'] ?></td>
                    <td>Rp. <?php echo number_format($val['jml_piutang'], '0', '.', '.') ?></td>
                    <td>Rp. <?php echo number_format($val['bayar'], '0', '.', '.') ?></td>
                    <td>Rp. <?php echo number_format(($val['jml_piutang']-$val['bayar']), '0', '.', '.') ?></td>
                    <td>
                      <?php if ($val['status'] == 'Lunas') { ?>
                        <span class="label label-success"><?php echo $val['status'] ?></span>
                      <?php } else { ?>
                        <span class="label label-danger"><?php echo $val['status'] ?></span>
                      <?php } ?>
                    </td>
                    <td>
                      <?php if ($val['status'] == 'Lunas') { ?>
                        <a href="#" onclick="detailPay('<?php echo $val['id_piutang'] ?>')" class="btn btn-primary btn-xs"><i class="fa fa-search-plus"></i> Detail Pembayaran</a>
                      <?php } else { ?>
                        <a href="<?php echo site_url('piutang/payment/' . encrypt_url($val['id_piutang'])) ?>" class="btn btn-success btn-xs"><i class="fa fa-check"></i> Payment</a>
                      <?php } ?>

                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function RedirectData() {
    var b = document.getElementById("bulan");
    var t = document.getElementById("tahun"); 
    window.location.replace('<?= site_url('piutang') ?>/index/' + b.value + '/' + t.value );
  }

</script>
<?php include 'script.php' ?>
<?php include 'detail_payment.php' ?>