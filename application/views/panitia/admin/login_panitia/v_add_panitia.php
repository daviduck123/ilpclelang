<div class="col-md-12">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>panitia/username">Panitia</a></li>                            
        <li class="active">Tambah</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo validation_errors("<div class='alert alert-danger'><strong>", "</strong></div>"); ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Tambah data Panitia</strong></div>
                <div class="panel-body">
                    <?php echo form_open("panitia/username/tambah/", array("class" => "form-horizontal")); ?>                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "nama", "placeholder" => "Nama Panitia", "maxlength" => "45", "class" => "form-control", "required" => "true", "value" => set_value("nama", ""))); ?>                       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">username :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "username", "placeholder" => "Username Panitia", "maxlength" => "45", "class" => "form-control", "required" => "true", "value" => set_value("username", ""))); ?>                       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label text-right">Jabatan :</label>
                        <div class="col-md-10">
                            <?php echo form_dropdown("jabatan", array("0" => "Anggota", "1" => "Super Admin"), set_value("jabatan", ""), "class='form-control' required"); ?>                       
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