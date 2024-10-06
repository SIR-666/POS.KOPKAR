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
               <button type="button" class="btn btn-sm btn-primary" title="Tambah Kategori" data-toggle="modal" data-target="#inputKategoriModal"><i class="fa fa-plus"></i> Tambah Kategori</button>
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
                     <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>COA Penjualan</th>
                                <th>COA Persediaan</th>
                                <th>COA HPP</th>
                                <th>Opsi</th>                                       
                            </tr>
                        </thead>
                        <tbody>
                          <?php 
                          foreach($kategori as $data)
                          {
                          ?>  
                            <tr>
                                <td><?php echo $data->kategori;?></td>
                                <td><?php echo $data->coa_penjualan;?></td>
                                <td><?php echo $data->coa_persediaan;?></td>
                                <td><?php echo $data->coa_hpp?></td>
                                <td> 
                                <button type="button" class="btn btn-sm btn-primary btn-xs" title="Edit Kategori" data-toggle="modal" data-target="#EditKategoriModal<?php echo $data->id_kategori;?>"><i class="fa fa-edit"></i></button>
                                 <!------------------------------------- modul edit kategori--------------------------------------------------------------------->
                                <div class="modal fade" id="EditKategoriModal<?php echo $data->id_kategori;?>">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title" id="inputUserModal">Edit Kategori</h4>
                                      </div>
                                      <div class="modal-body">
                                        <form class="form-horizontal" method="post" action="<?php echo site_url('kategori/editkategori') ?>">
                                        <div class="form-group">
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                              <input type="hidden" class="form-control" id="idkategori" name="idkategori" autocomplete="off" value="<?php echo $data->id_kategori;?>">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                              <input type="text" class="form-control" id="kategori" name="kategori" autocomplete="off" value="<?php echo $data->kategori;?>">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">COA Penjualan</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                              <select class="form-control" id="coa_penjualan" name="coa_penjualan">
                                              <?php
                                              foreach($coa as $dtcoa)
                                              {
                                                $spasi = '';
                                                 for ($x = 0; $x <= $dtcoa->itCOALevel; $x++) {
                                                $spasi = $spasi . '&nbsp;&nbsp;&nbsp;'; 
                                                }
                                                if($data->coa_penjualan==$dtcoa->vcCOACode)
                                                {
                                              ?>
                                                <option 
                                                <?php 
                                                if($dtcoa->itCOAType==0)
                                                {
                                                  echo "disabled='disabled'";
                                                }
                                                ?>
                                                value="<?php echo $dtcoa->vcCOACode;?>" selected="selected"><?php echo $spasi.$dtcoa->vcCOAName;?></option>
                                              <?php
                                                }
                                                else
                                                {
                                              ?>
                                                  <option 
                                                  <?php 
                                                    if($dtcoa->itCOAType==0)
                                                    {
                                                      echo "disabled='disabled'";
                                                    }
                                                    ?>
                                                  value="<?php echo $dtcoa->vcCOACode;?>"><?php echo $spasi.$dtcoa->vcCOAName;?></option>
                                              <?php    
                                                }  
                                              }
                                              ?>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">COA Persediaan</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                              <select class="form-control" id="coa_pembelian" name="coa_pembelian">
                                              <?php
                                              foreach($coa as $dtcoa)
                                              {
                                                $spasi = '';
                                                for ($x = 0; $x <= $dtcoa->itCOALevel; $x++) {
                                                $spasi = $spasi . '&nbsp;&nbsp;&nbsp;'; 
                                                }  
                                                if($data->coa_persediaan==$dtcoa->vcCOACode)
                                                {
                                              ?>
                                                  <option 
                                                  <?php 
                                                    if($dtcoa->itCOAType==0)
                                                    {
                                                      echo "disabled='disabled'";
                                                    }
                                                  ?>
                                                  value="<?php echo $dtcoa->vcCOACode;?>" selected="selected"><?php echo $spasi.$dtcoa->vcCOAName;?></option>
                                              <?php
                                                }
                                                else
                                                {
                                              ?>
                                                  <option 
                                                  <?php 
                                                    if($dtcoa->itCOAType==0)
                                                    {
                                                      echo "disabled='disabled'";
                                                    }
                                                    ?>
                                                  value="<?php echo $dtcoa->vcCOACode;?>"><?php echo $spasi.$dtcoa->vcCOAName;?></option>
                                              <?php
                                                }
                                              }
                                              ?>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">COA HPP</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                              <select class="form-control" id="coa_hpp" name="coa_hpp">
                                              <?php
                                              foreach($coa as $dtcoa)
                                              {
                                                $spasi = '';
                                                for ($x = 0; $x <= $dtcoa->itCOALevel; $x++) {
                                                $spasi = $spasi . '&nbsp;&nbsp;&nbsp;'; 
                                                }
                                                if($data->coa_hpp==$dtcoa->vcCOACode)
                                                {
                                              ?>
                                                  <option 
                                                  <?php 
                                                    if($dtcoa->itCOAType==0)
                                                    {
                                                      echo "disabled='disabled'";
                                                    }
                                                    ?>
                                                  value="<?php echo $dtcoa->vcCOACode;?>" selected="selected"><?php echo $spasi.$dtcoa->vcCOAName;?></option>
                                              <?php
                                                }
                                                else
                                                {
                                              ?>    
                                                  <option 
                                                  <?php 
                                                    if($dtcoa->itCOAType==0)
                                                    {
                                                      echo "disabled='disabled'";
                                                    }
                                                    ?>
                                                  value="<?php echo $dtcoa->vcCOACode;?>"><?php echo $spasi.$dtcoa->vcCOAName;?></option>
                                              <?php  
                                                }
                                              }
                                              ?>
                                              </select>
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
		 <!-----------------------------------------------end modul edit kategori--------------------------------------------------->
                                <a href="<?php echo site_url() . "kategori/hapuskategori/" . $data->id_kategori; ?>"><button data-toggle="tooltip" title="Trash" class="btn btn-danger btn-xs"><i class="fa fa-trash-o" aria-hidden="true"></i></button></a>
                                </td>
                            </tr>
                          <?php
                          }
                          ?>
                        </tbody>
                    </table>
		           </div>
		         </div>
		       </div>
		     </div>
		   </div>
		 </div>

     <!------------------------------------- modul input kategori--------------------------------------------------------------------->
		 <div class="modal fade" id="inputKategoriModal">
		 	<div class="modal-dialog">
		 		<div class="modal-content">
		 			<div class="modal-header">
		 				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
		 				</button>
		 				<h4 class="modal-title" id="inputUserModal">Entry Kategori</h4>
		 			</div>
		 			<div class="modal-body">
		 				<form class="form-horizontal" method="post" action="<?php echo site_url('kategori/inputkategori') ?>">
		 					<div class="form-group">
		 						<label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori</label>
		 						<div class="col-md-9 col-sm-9 col-xs-12">
		 							<input type="text" class="form-control" id="kategori" name="kategori" autocomplete="off">
		 						</div>
		 					</div>
              <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">COA Penjualan</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                      <select class="form-control" id="coa_penjualan" name="coa_penjualan">
                      <?php
                        foreach($coa as $dtcoa)
                        {
                          $spasi = '';
                          for ($x = 0; $x <= $dtcoa->itCOALevel; $x++) {
                         $spasi = $spasi . '&nbsp;&nbsp;&nbsp;'; 
                         }
                      ?>
                          <option 
                          <?php 
                            if($dtcoa->itCOAType==0)
                            {
                            echo "disabled='disabled'";
                            }
                          ?>
                          value="<?php echo $dtcoa->vcCOACode;?>"><?php echo $spasi.$dtcoa->vcCOAName;?></option>
                      <?php
                        }
                      ?>
                      </select>
                    </div>
              </div>
		 					<div class="form-group">
		 						<label class="control-label col-md-3 col-sm-3 col-xs-12">COA Persediaan</label>
                 <div class="col-md-9 col-sm-9 col-xs-12">
                      <select class="form-control" id="coa_pembelian" name="coa_pembelian">
                      <?php
                        foreach($coa as $dtcoa)
                        {
                          $spasi = '';
                          for ($x = 0; $x <= $dtcoa->itCOALevel; $x++) {
                         $spasi = $spasi . '&nbsp;&nbsp;&nbsp;'; 
                         }
                      ?>
                          <option 
                          <?php 
                            if($dtcoa->itCOAType==0)
                            {
                            echo "disabled='disabled'";
                            }
                          ?>
                          value="<?php echo $dtcoa->vcCOACode;?>"><?php echo $spasi.$dtcoa->vcCOAName;?></option>
                      <?php
                        }
                      ?>
                      </select>
                    </div>
		 					</div>
               <div class="form-group">
		 						<label class="control-label col-md-3 col-sm-3 col-xs-12">COA HPP</label>
                 <div class="col-md-9 col-sm-9 col-xs-12">
                      <select class="form-control" id="coa_hpp" name="coa_hpp">
                      <?php
                        foreach($coa as $dtcoa)
                        {
                          $spasi = '';
                          for ($x = 0; $x <= $dtcoa->itCOALevel; $x++) {
                         $spasi = $spasi . '&nbsp;&nbsp;&nbsp;'; 
                         }
                      ?>
                          <option 
                          <?php 
                            if($dtcoa->itCOAType==0)
                            {
                            echo "disabled='disabled'";
                            }
                          ?>
                          value="<?php echo $dtcoa->vcCOACode;?>"><?php echo $spasi.$dtcoa->vcCOAName;?></option>
                      <?php
                        }
                      ?>
                      </select>
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
		 <!-----------------------------------------------end modul input kategori--------------------------------------------------->
        