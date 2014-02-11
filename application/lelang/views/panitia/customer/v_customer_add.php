<div class="col-md-12">
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>panitia/customer">Customer</a></li>                            
        <li class="active">Tambah</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">            
            <?php echo validation_errors("<div class='alert alert-danger'><strong>", "</strong></div>") ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Detail Customer</strong></div>
                <div class="panel-body">
                    <?php echo form_open("panitia/customer/tambah/", array("class" => "form-horizontal")); ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Id Customer :</label>
                        <div class="col-md-9">
                            <label class="control-label"><strong><?php echo $new['id']; ?></strong></label>                        
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Nama Customer :</label>
                        <div class="col-md-9">
                            <?php echo form_input(array("name" => "nama", "placeholder" => "Nama Customer", "maxlength" => "50", "class" => "form-control", "required" => "true")) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-8 text-right">                            
                            <?php
                            echo form_submit(array("class" => "btn btn-info btnX", "name" => "submit", "value" => "Simpan"));
                            echo form_reset(array("class" => "btn btn-default btnX", "name" => "reset", "value" => "Reset"));
                            ?>               
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>