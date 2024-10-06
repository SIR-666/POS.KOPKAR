		 <?php 
     cek_user();
     $awal=$this->input->post('awal');
     $akhir=$this->input->post('akhir');
     $takhir=date('Y-m-d', strtotime($akhir. ' +1 days'));
     $kbarang=$this->input->post('nama_brg');
     ?>
		 <div class="right_col" role="main">
		   <div class="">
		     <div class="page-title">
		       <div class="title_left">
              <?php
              $nbarang=$this->Penjualan_m->Detail_barang($kbarang)->row();
              ?>
              <h3><?php echo $title .' '. $nbarang->nama_barang; ?></h3>
		       </div>
		     </div>
		     <div class="clearfix"></div>
		     <div class="row">
		       <div class="col-md-12 col-sm-12 col-xs-12">
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
                   <!------------Content---------------------->
                        <H2><center>Periode <?php echo date("d F Y",strtotime($awal))?> Sampai <?php echo date("d F Y",strtotime($akhir))?></center><H2>
                        <H4>Barang Keluar</H4>
                        <!-----------------------Pembelian---------------------------------------->
                        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Anggota</th>
                                    <th>Harga Jual</th>
                                    <th>Barang Keluar</th>   
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $takhir=date('Y-m-d', strtotime($akhir. ' +1 days'));
                                $jual=$this->Penjualan_m->Detail_penjualan_barang_by_tgl($kbarang,$awal,$takhir)->result();
                            foreach($jual as $djual)
                            {
                            ?>
                            <tr>
                              <td><?php echo $djual->invoice;  ?></td>
                              <td><?php echo date("d-m-Y",strtotime($djual->tgl));  ?></td>
                              <td><?= $djual->nama ?></td>
                              <td><?php echo number_format($djual->harga_item, '0', '.', '.');  ?></td>
                              <td><?php echo $djual->qty_jual;  ?></td>
                            </tr>
                            <?php  
                            }
                            ?>
                            </tbody>
                        </table>
                        <!-----------garis---------------------------------->
                        <hr style="border: 1px solid;">
                        
                        <H4>Barang Masuk</H4>
                        
                        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No Faktur</th>
                                    <th>Tanggal</th>
                                    <th>Supplier</th>
                                    <th>Harga Beli</th>
                                    <th>Barang Masuk</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $takhir=date('Y-m-d', strtotime($akhir. ' +1 days'));
                                $beli=$this->Pembelian_m->Detil_pembelian_barang_by_tgl($kbarang,$awal,$takhir)->result();
                                foreach($beli as $dbeli)
                                {
                            ?>
                                <tr>
                                  <td><?php echo $dbeli->faktur_beli;  ?></td>
                                  <td><?php echo date("d-m-Y",strtotime($dbeli->tgl_pembelian));  ?></td>
                                  <td><?= $dbeli->nama_supplier ?></td>
                                  <td><?php echo number_format($dbeli->hrg_beli, '2', '.', '.');  ?></td>
                                  <td><?php echo $dbeli->qty_beli;  ?></td>
                                </tr>
                            <?php  
                                }
                            ?>
                            </tbody>
                        </table>
                    <!------------Content---------------------->
		           </div>
		         </div>
		       </div>
		     </div>
		   </div>
		 </div>