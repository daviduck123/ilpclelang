<div class="col-md-12">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>panitia/barang">Barang</a></li>                            
        <li class="active">Tambah</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo validation_errors("<div class='alert alert-danger'><strong>", "</strong></div>"); ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Tambah Barang</strong></div>
                <div class="panel-body">
                    <?php echo form_open("panitia/barang/tambah/", array("class" => "form-horizontal")); ?>                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Barang :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "nama_barang", "placeholder" => "Nama Barang", "maxlength" => "45", "class" => "form-control", "required" => "true", "value" => set_value("nama_barang", ""))); ?>                       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Harga :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "harga", "placeholder" => "Harga Barang", "maxlength" => "50", "class" => "form-control numberonly nominal", "required" => "true", "value" => set_value("harga", ""))); ?>                       
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-5 col-md-offset-7 text-right">
                            <?php
                            echo form_button(array("name" => "submit", "value" => "true", "type" => "submit", "class" => "btn btn-info btn-lg btnX", "content" => "<span class=' glyphicon glyphicon-floppy-save'></span> Simpan"));
                            echo form_button(array("name" => "reset", "value" => "true", "type" => "reset", "class" => "btn btn-default btn-lg btnX", "content" => "<span class='glyphicon glyphicon-refresh'></span> Reset"));
                            ?>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>bootstrap/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/angka.js"></script>