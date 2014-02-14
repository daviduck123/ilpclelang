<div class="row-justified ">
    <!-- Tab panes -->
    <div class="col-md-12">
        <h3>Stok Barang - Buy</h3>
        <hr>
        <div>
            <?php
            echo form_open("stok/buy");
            echo validation_errors("<div class='alert alert-danger'><b>", "</b></div>");
            ?>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Harga Jual NPC</th>
                        <th>Stok Bebas Pengadaan</th>
                        <th class="col-md-2">Jumlah</th>
                        <th class="col-md-3">Total Harga</th>
                    </tr>                       
                </thead>
                <tbody>
                    <?php foreach ($daftarStok as $index => $stok): ?>
                        <?php $nama = explode(' ', $stok['nama_barang']) ?>
                        <tr>
                            <td><?php echo $stok['id']; ?></td>
                            <td><?php echo $stok['nama_barang']; ?></td>
                            <td class="text-right"id="harga_<?php echo $stok['id']; ?>"><?php echo ($stok['harga_sekarang']) ? number_format($stok['harga_sekarang']) : "0"; ?></td>
                            <td class="text-right"><?php echo ($stok['stok_user']) ? number_format($stok['stok_user'] - $stok['lock_user']) : "0"; ?></td>    
                            <td><?php echo form_input(array("name" => "jumlah[" . $stok['id'] . "]", "id" => "item_" . $stok['id'], "class" => "inputData form-control numberonly nominal text-right hitung angkaInput", "maxlength" => "5", "value" => set_value("jumlah[]", "0"))); ?></td>
                            <td class="text-right TotalHitung" id="item_<?php echo $stok['id']; ?>_total">0</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right"><b>Grand Total :</b></td>
                        <td  class="text-right"><b><span id="grandTotal">0</span></b></td>
                    </tr>
                </tfoot>
            </table>
            <?php
            echo form_input(array("name" => "grandTotal", "id" => "grandTotal1", "type" => "hidden", "value" => "0"));
            echo form_submit(array('name' => 'beli', 'class' => 'btn btn-lg btn-primary btn-block', 'value' => 'Beli', 'id' => 'tombol_beli'));
            echo form_close();
            ?>
        </div>        
    </div>
</div>
<div style="display: none">
    <div id="graph"></div>                    
</div>
<!--SCRIPT UNTUK FLUKTUASI-->
<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/morris.css"/>
<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/david.css"/>
<script>var DATA;</script>
<script src="<?php echo base_url(); ?>bootstrap/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/angka.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/raphael.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/morris.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/fluktuasi_bt.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/v_buy.js"></script>
<script>update_graph();</script>