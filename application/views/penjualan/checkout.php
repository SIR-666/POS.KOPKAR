<?php
  $tagih = date('Y-m-d');
  if (date('d') == "29" | date('d') == "30" | date('d') == "31") {
    $tagih = date('Y-m-') . "28";
  }
  //tgl hr ini
  //bayar tanggal 25 bulan berikutnya
  $tagih=date('Y-m-d', strtotime($tagih. ' +1 months'));
  $tagih = substr($tagih,0,8) . '01';
?>
  <div class="modal fade" id="pembayaranModal">
   <div class="modal-dialog">
     <div class="modal-content">

       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
         </button>
         <h4 class="modal-title" id="inputKasModal">Pembayaran</h4>
       </div>
       <div class="modal-body">
        <div id="warning" style="text-align:center;width:100%" class=""></div>
         <form class="form-horizontal" method="post" action="<?php echo site_url('penjualan/simpanpenjualan') ?>">
           <div class="form-group">
             <input type="hidden" class="form-control" name="kasir" id="kasir" readonly>
             <input type="hidden" class="form-control" name="cus" id="cus" readonly>
             <input type="hidden" name="coa_cash"  readonly value="<?php echo $toko->coa_cash ?>">
		 				<input type="hidden" name="coa_transfer"  readonly value="<?php echo $toko->coa_transfer ?>">
		 				<input type="hidden" name="coa_kredit"  readonly value="<?php echo $toko->coa_kredit ?>">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">Sub Total</label>
             <div class="col-md-9 col-sm-9 col-xs-12">
               <input type="text" class="form-control" name="subtotal" id="subtotal" readonly>
             </div>
           </div>
           <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">Diskon (Rp)</label>
             <div class="col-md-9 col-sm-9 col-xs-12">
               <input type="text" class="form-control" name="diskon1" id="diskon1" autocomplete="off" readonly>
             </div>
           </div>
           <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">PPN</label>
             <div class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
               <input type="text" class="form-control has-feedback-left" name="nominal_ppn" id="nominal_ppn" readonly>
               <span class="form-control-feedback left" aria-hidden="true"><b>Rp</b></span>
             </div>
             <div class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
               <input type="number" class="form-control" name="ppn_persen" id="ppn_persen" autocomplete="off">
               <span class="form-control-feedback right" aria-hidden="true"><b>%</b></span>
             </div>
           </div>
           <!-- <div class="form-group cek-poin">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">Gunakan Poin</label>
             <div class="col-md-9 col-sm-9 col-xs-12">
               <div class="row">
                 <div class="col-md-2">
                   <label class="text-warning">
                     <input type="checkbox" class="js-switch" id="check" onclick="gunakanPoin()" />
                   </label>
                 </div>
                 <div class="col-md-10">
                   <input type="text" class="form-control" id="poin" name="poin" readonly>
                   <input type="hidden" class="form-control" id="poin1" name="poin1" readonly>
                   <input type="hidden" class="form-control" id="poin2" name="poin2" readonly>
                 </div>
               </div>
             </div>
           </div> -->

           <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">Grand Total</label>
             <div class="col-md-9 col-sm-9 col-xs-12">
               <input type="text" class="form-control" name="grandtotal" id="grandtotal" readonly>
               <input type="hidden" class="form-control" name="nominal" id="nominal" readonly>
             </div>
           </div>
           <div class="form-group">
             <label class="control-label mb-1 col-md-3 col-sm-3 col-xs-12">Payment Method</label>
             <div class="col-md-6 col-sm-6 col-xs-12">
               <div class="checkbox">
                 <label>
                   <input type="radio" name="metode" id="cash" value="Cash" checked> Cash
                 </label>
                 <label>
                   <input type="radio" name="metode" id="transfer" value="Transfer"> Transfer
                 </label>                 
                 <label>
                   <input type="radio" name="metode" id="kredit" value="Kredit" disabled> Kredit
                 </label>
               </div>
             </div>
           </div>
           <div class="form-group jatuh-tempo">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">Jatuh Tempo</label>
             <div class="col-md-9 col-sm-9 col-xs-12">
               <input type="date" class="form-control" name="tempo" id="tempo" autocomplete="off" value="<?php echo $tagih;?>">
             </div>
           </div>
           <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">Bayar</label>
             <div class="col-md-9 col-sm-9 col-xs-12">
               <input type="number" class="form-control" name="bayar" id="bayar" autocomplete="off" required>
             </div>
           </div>
           <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">Kembali</label>
             <div class="col-md-9 col-sm-9 col-xs-12">
               <input type="text" class="form-control" name="kembali" id="kembali" readonly autocomplete="off">
             </div>
           </div>
           <div class="modal-footer">
             <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
             <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Cetak dan Simpan</button>
           </div>
         </form>
       </div>
     </div>
   </div>
 </div>