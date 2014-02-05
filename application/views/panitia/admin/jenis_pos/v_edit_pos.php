<div class="col-md-12">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>panitia/jenis_pos">Jenis</a></li>                            
        <li class="active">Tambah</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo validation_errors("<div class='alert alert-danger'><strong>", "</strong></div>"); ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Edit Jenis Pos</strong></div>
                <div class="panel-body">
                    <?php echo form_open("panitia/jenis_pos/edit/".$this->encrypt->encode($jenis['id']), array("class" => "form-horizontal")); ?>                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Jenis :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "nama", "placeholder" => "Nama Jenis Pos", "maxlength" => "45", "class" => "form-control", "required" => "true", "value" => set_value("nama",$jenis['nama_jenis']))); ?>                       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Sertifikat Menang :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "sertifikat_menang", "placeholder" => "Sertifikat Menang", "maxlength" => "10", "class" => "form-control numberonly nominal", "required" => "true", "value" => set_value("sertifikat_menang", number_format($jenis['sertifikat_menang'])))); ?>                       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Sertifikat Kalah :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "sertifikat_kalah", "placeholder" => "Sertifikat Kalah", "maxlength" => "10", "class" => "form-control numberonly nominal", "required" => "true", "value" => set_value("sertifikat_kalah", number_format($jenis['sertifikat_kalah'])))); ?>                       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Uang Menang :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "uang_menang", "placeholder" => "Uang Menang", "maxlength" => "10", "class" => "form-control numberonly nominal", "required" => "true", "value" => set_value("uang_menang", number_format($jenis['uang_menang'])))); ?>                       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Uang Kalah :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "uang_kalah", "placeholder" => "Uang MenKalahang", "maxlength" => "10", "class" => "form-control numberonly nominal", "required" => "true", "value" => set_value("uang_kalah", number_format($jenis['uang_kalah'])))); ?>                       
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