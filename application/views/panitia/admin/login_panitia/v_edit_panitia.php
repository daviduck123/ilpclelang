<div class="col-md-12">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>panitia/username">Panitia</a></li>                            
        <li class="active">Edit</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (empty($panitia)): ?>
                <h3>Data panitia tidak ditemukan</h3>
            <?php else: ?>
                <?php echo validation_errors("<div class='alert alert-danger'><strong>", "</strong></div>"); ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Edit data Panitia</strong></div>
                    <div class="panel-body">
                        <?php echo form_open("panitia/username/edit/" . $this->encrypt->encode($panitia['id']), array("class" => "form-horizontal")); ?>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Id :</label>
                            <div class="col-md-10">
                                <label class="control-label"><?php echo $panitia['id']; ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Nama :</label>
                            <div class="col-md-10">
                                <?php echo form_input(array("name" => "nama", "placeholder" => "Nama Panitia", "maxlength" => "45", "class" => "form-control", "required" => "true", "value" => set_value("nama", $panitia['nama']))); ?>                       
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label text-right">Jabatan :</label>
                            <div class="col-md-10">
                                <?php echo form_dropdown("jabatan", array("0" => "Anggota", "1" => "Super Admin"), set_value("jabatan", $panitia['status']), "class='form-control' required"); ?>                       
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
            <?php endif; ?>
        </div>
    </div>
</div>