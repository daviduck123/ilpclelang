<div class="col-md-12">
    <ol class="breadcrumb">     
        <li><a href="<?php echo site_url(); ?>panitia/wewenang">Wewenang</a></li>
        <li class="active">Edit</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo validation_errors("<div class='alert alert-danger'><strong>", "</strong></div>"); ?>
            <?php if (empty($panitia)): ?>
                <h3>Tidak ada wewenang yang bisa ditambahkan ke panitia</h3>
            <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Data Wewenang Panitia </strong></div>
                    <div class="panel-body">
                        <?php echo form_open("panitia/wewenang/edit/" . $this->encrypt->encode($panitia['id']), array("class" => "form-horizontal")); ?>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Nama Panitia :</label>
                            <div class="col-md-10">
                                <label class="control-label"><?php echo $panitia['nama']; ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Status :</label>
                            <div class="col-md-10">
                                <label class="control-label"><?php echo ($panitia['status'] == '1') ? "Super Admin" : "Panitia"; ?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Wewenang :</label>
                            <div class="col-md-10">
                                <?php if (empty($pos)): ?>
                                    <h3>Pos tidak ada silahkan buat pos di meu Pos</h3>
                                <?php else: ?>
                                    <?php foreach ($pos as $index => $singlepos): ?>
                                        <div class="col-md-4">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <h4 class="text-center"><?php echo $index; ?></h4>
                                                    <?php foreach ($singlepos as $key => $single): ?>
                                                        <div class="col-md-6">
                                                            <?php echo form_checkbox(array("name" => "wewenang[" . $single['id'] . "]", "value" => $single["id"], "checked" => set_checkbox("wewenang", $single['id'], (!empty($single['panitia']))))); ?>
                                                            <?php echo $single['nama']; ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (!empty($pos)): ?>
                            <div class="form-group">
                                <div class="col-md-12 text-right">
                                    <?php
                                    echo form_button(array("name" => "submit", "value" => "true", "type" => "submit", "class" => "btn btn-info btn-lg btnX", "content" => "<span class=' glyphicon glyphicon-floppy-save'></span> Simpan"));
                                    echo form_button(array("name" => "reset", "value" => "true", "type" => "reset", "class" => "btn btn-default btn-lg btnX", "content" => "<span class='glyphicon glyphicon-refresh'></span> Reset"));
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
