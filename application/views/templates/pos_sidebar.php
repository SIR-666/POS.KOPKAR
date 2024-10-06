        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="#" class="site_title"><i class="fa fa-shopping-cart" style="color:white"></i> <span style="color: white;font: size 16px;">Greenfields</span></a>
            </div>
            <div class="clearfix"></div>
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php echo site_url('assets/production/') ?>images/user.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $user['nama_lengkap'] ?></h2>
              </div>
            </div>
            <br />
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <?php if ($user['tipe'] == "Administrator") { ?>
                    <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?php echo site_url('dashboard') ?>">Dashboard</a></li>
                      </ul>
                    </li>
                  <?php } ?>
                  <li><a><i class="fa fa-shopping-cart"></i> Transaksi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo site_url('penjualan') ?>">Entry Penjualan</a></li>
                      <li><a href="<?php echo site_url('dpenjualan') ?>">Daftar Penjualan</a></li>

                      <li><a href="<?php echo site_url('pembelian') ?>">Entry Pembelian</a></li>
                      <li><a href="<?php echo site_url('dpembelian') ?>">Daftar Pembelian</a></li>
                      <li><a href="<?php echo site_url('hutang') ?>">Hutang</a></li>
                      <li><a href="<?php echo site_url('piutang') ?>">Piutang</a></li>
                      <li><a href="<?php echo site_url('posting') ?>">Posting Jurnal</a></li>
                    </ul>
                  </li>
                  <?php if ($user['tipe'] == "Administrator") { ?>
                    <li><a><i class="fa fa-desktop"></i> Master Data <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?php echo site_url('barang') ?>">Data Barang</a></li>
                        <li><a href="<?php echo site_url('kategori') ?>">Data Kategori Barang</a></li>
                        <li><a href="<?php echo site_url('satuan') ?>">Data Satuan Barang</a></li>
                        <li><a href="<?php echo site_url('supplier') ?>">Data Supplier</a></li>
                        <li><a href="<?php echo site_url('customer') ?>">Data Anggota</a></li>
                        <li><a href="<?php echo site_url('karyawan') ?>">Data Karyawan</a></li>
                        <!-------------------------------------------------------------------
                        <li><a href="<?php //echo site_url('servis') ?>">Data Servis</a></li>
                        --------------------------------------------------------------------->
                        <!-- <li><a href="<?php //echo site_url('mutasi')
                                          ?>">Mutasi Barang</a></li> -->
                        <li><a href="<?php echo site_url('stokopname') ?>">Stok Opname</a></li>
                        <!---------------------------------------------------------------------
                        <li><a href="<?php //echo site_url('stok') ?>">Stok In/Out</a></li>
                        <li><a href="<?php //echo site_url('gudang') ?>">Data Gudang</a></li>
                        ---------------------------------------------------------------------->
                      </ul>
                    </li>

                   <!--  <li><a><i class="fa fa-money"></i> Keuangan <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?php //echo site_url('kas') ?>">Kas</a></li>
                        <li><a href="<?php //echo site_url('ppn') ?>">PPN</a></li>
                        <li><a href="<?php //echo site_url('bank') ?>">Bank</a></li>
                      </ul>
                    </li> -->

                    <li><a><i class="fa fa-file-text-o"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?php echo site_url('laporan/barang') ?>">Laporan Barang</a></li>
                        <li><a href="<?php echo site_url('Barang/Kartu_barang') ?>">Kartu Barang</a></li>
                        <li><a href="<?php echo site_url('laporan/penjualan') ?>">Laporan Penjualan</a></li>
                        <li><a href="<?php echo site_url('laporan/Rekap_penjualan') ?>">Rekap Penjualan</a></li>
                        <li><a href="<?php echo site_url('Laporan/Laporan_kategori') ?>">Laporan Penjualan Kategori</a></li>
                        <li><a href="<?php echo site_url('laporan/pembelian') ?>">Laporan Pembelian</a></li>
                        <!-- <li><a href="<?php //echo site_url('laporan/mutasi')
                                          ?>">Laporan Mutasi Barang</a></li> -->
                        <li><a href="<?php echo site_url('laporan/stokopname') ?>">Laporan Stok Opname</a></li>
                        <!-----------------------------------------------------------------------------------
                        <li><a href="<?php //echo site_url('laporan/laba_rugi') ?>">Laporan Laba Rugi</a></li>
                        ------------------------------------------------------------------------------------->
                        <li><a href="<?php echo site_url('laporan/kas') ?>">Laporan Kas</a></li>
                        <!-----------------------------------------------------------------------------------
                        <li><a href="<?php //echo site_url('laporan/kas_bank') ?>">Laporan Kas Bank</a></li>
                        <li><a href="<?php //echo site_url('laporan/stok') ?>">Laporan Stok In/Out</a></li>
                        ------------------------------------------------------------------------------------->
                        <li><a href="<?php echo site_url('laporan/hutang') ?>">Laporan Hutang</a></li>
                        <li><a href="<?php echo site_url('laporan/piutang') ?>">Laporan Piutang</a></li>
                      </ul>
                    </li>
                    <li><a><i class="fa fa-user"></i> Management User <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?php echo site_url('user') ?>">Data User</a></li>
                        <li><a href="<?php echo site_url('userlog') ?>">User Log</a></li>
                      </ul>
                    </li>

                    <li><a><i class="fa fa-bar-chart-o"></i> Grafik <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?php echo site_url('grafik') ?>">Grafik</a></li>
                      </ul>
                    </li>
                    <!------------------------------------------------------------------------------------------------
                    <li><a><i class="fa fa-magic"></i> Tools <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">
                        <li><a href="<?php echo site_url('barcode') ?>">Generate Barcode</a></li>
                        <li><a href="<?php echo site_url('backup') ?>">Backup Data</a></li>
                        <li><a href="<?php echo site_url('applog') ?>">Application Log</a></li>
                      </ul>
                    </li>s
        
                    <li><a><i class="fa fa-gift"></i> Prestasi <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?php //echo site_url('prestasi') ?>">Index Prestasi</a></li>
                      </ul>
                    </li>
                    ---------------------------------------------------------------------------------------------------->
                    <li><a><i class="fa fa-gears"></i> Setting <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="<?php echo site_url('profil') ?>">Profil Toko</a></li>
                        <li><a href="<?php echo site_url('Poscoa') ?>">Setup Chart of account</a></li>
                        <!-- <li><a href="<?php //echo site_url('promo')
                                          ?>">Setting Promo</a></li> -->
                      </ul>
                    </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
          </div>
        </div>