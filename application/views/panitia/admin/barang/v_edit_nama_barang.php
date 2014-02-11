<div class="col-md-12">
    <ol class="breadcrumb">     
        <li><a href="<?php echo site_url(); ?>panitia/barang">Barang</a></li>
        <li class="active">Edit</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo validation_errors("<div class='alert alert-danger'><strong>", "</strong></div>"); ?>
            <?php if (empty($barang)): ?>
                <h3>Tidak ada barang yang bisa dirubah.</h3>
            <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Data Barang</strong></div>
                    <div class="panel-body">
                        <?php echo form_open("panitia/barang/edit/" . $this->encrypt->encode($barang['id']), array("class" => "form-horizontal")); ?>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Nama Barang :</label>
                            <div class="col-md-10">
                                <?php
                                $data = array(
                                    'name' => 'nama_barang',
                                    'value' => $barang['nama_barang'],
                                    'class' => 'form-control',
                                    'maxlength' => '100',
                                );

                                echo form_input($data);
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 text-right">
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
