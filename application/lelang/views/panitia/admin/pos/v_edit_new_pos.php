<div class="col-md-12">
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>panitia/pos">Pos</a></li>                            
        <li class="active">Tambah</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo validation_errors("<div class='alert alert-danger'><strong>", "</strong></div>"); ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Tambah Pos</strong></div>
                <div class="panel-body">
                    <?php echo form_open("panitia/pos/edit/" . $this->encrypt->encode($pos['id']), array("class" => "form-horizontal")); ?>                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nama Pos :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "nama", "placeholder" => "Nama Pos", "maxlength" => "45", "class" => "form-control", "required" => "true", "value" => set_value("nama", $pos['nama_pos']))); ?>                       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Jenis Pos :</label>
                        <div class="col-md-10">
                            <?php echo form_dropdown("jenis", $jenis, set_value("jenis", $pos['jenis_pos_id']), "class='form-control' required"); ?>                       
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