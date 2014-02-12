<div class="col-md-12">
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>panitia/lelang">Lelang</a></li>                            
        <li class="active">Tambah</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo validation_errors("<div class='alert alert-danger'><strong>", "</strong></div>"); ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Detail Lelang</strong></div>
                <div class="panel-body">
                    <?php echo form_open("panitia/lelang/tambah", array("class" => "form-horizontal")); ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label text-right">Customer :</label>
                        <div class="col-md-10">
                            <?php echo form_dropdown("customer", $dataCustomer, set_value("customer", 0), "class='form-control' required"); ?>                       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label text-right">Season :</label>
                        <div class="col-md-10">
                            <?php echo form_dropdown("season", $dataSeason, set_value("season", 0), "class='form-control' required"); ?>                       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label text-right">No Lelang :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "no_lelang", "placeholder" => "No Lelang", "maxlength" => "50", "class" => "form-control", "required" => "true", "value" => set_value("no_lelang", ""))) ?>                       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label text-right">Judul Lelang :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "judul_lelang", "placeholder" => "Judul Lelang", "class" => "form-control", "required" => "true", "value" => set_value("judul_lelang", ""))) ?>                       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label text-right">Deskripsi :</label>
                        <div class="col-md-10">
                            <?php echo form_textarea(array("name" => "deskripsi", "placeholder" => "Deskripsi Lelang", "rows" => "2", "class" => "form-control", "required" => "true", "value" => set_value("deskripsi", ""))) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label text-right">Budget per Unit :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "budget", "placeholder" => "Budget per Unit Barang Lelang", "maxlength" => "10", "class" => "form-control numberonly nominal", "required" => "true", "value" => set_value("budget", 0))) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label text-right">Jumlah Permintaan :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "jumlah", "placeholder" => "Jumlah Barang Lelang", "maxlength" => "5", "class" => "form-control numberonly nominal", "required" => "true", "value" => set_value("jumlah", 0))) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label text-right">Nama Barang :</label>
                        <div class="col-md-10">
                            <?php echo form_input(array("name" => "nama_barang", "placeholder" => "Nama Barang Lelang", "maxlength" => "30", "class" => "form-control", "required" => "true", "value" => set_value("nama_barang", ""))) ?>                       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label text-right">Komposisi :</label>
                        <div class="col-md-10">
                            <?php
                            $count = 0;
                            foreach ($dataBarang as $index => $single):
                                if ($count == 0):
                                    ?>
                                    <div class="col-md-9">
                                        <?php
                                    endif;
                                    $count++;
                                    ?>
                                    <div class="col-md-3">
                                        <?php echo form_checkbox(array("name" => "barang[" . $single['id'] . "]", "value" => $single["id"], "checked" => set_checkbox("barang", $single['id']))); ?>
                                        <?php echo $single['nama_barang'] . " - " . number_format($single['stok']);  ?>
                                    </div>
                                    <?php
                                    if ($count == 3):
                                        $count = 0;
                                        ?>
                                    </div>
                                    <?php
                                endif;
                            endforeach;
                            ?>
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
