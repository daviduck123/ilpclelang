<?php echo validation_errors("<div class='alert alert-danger'><b>", "</b></div>"); ?>
<div class="page-header">
    <h3>Status Lelang : <span class="<?php echo $status["class"]; ?>"><?php echo $status["pesan"]; ?></span></h3>
</div>
<?php if (!empty($deskripsi)): ?>
    <!-- ini buat News-->
    <div class="panel panel-default">
        <div class="panel-heading"><u><?php echo $deskripsi['judul_lelang'] . " - " . $deskripsi['nama_customer']; ?></u></div>
        <div class="panel-body">
            <div class="form-group">
                <dl>
                    <dt>Deskripsi :</dt>
                    <dd><?php echo $deskripsi['deskripsi']; ?></dd>
                </dl>
            </div>
            <div class="form-group">
                <dl>                            
                    <dt>Nama Barang :</dt>
                    <dd><?php echo $deskripsi['nama_barang']; ?></dd>
                </dl>
            </div>
            <div class="form-group">
                <dl>                            
                    <dt>Modal untuk per Unit :</dt>
                    <dd><?php echo number_format($deskripsi['budget']); ?></dd>
                </dl>
            </div>                    
            <div class="form-group">
                <dl>                        
                    <dt>Jumlah Kebutuhan :</dt>
                    <dd><?php echo $deskripsi['jumlah']; ?></dd>
                </dl>
            </div>
            <div class="form-group">
                <label>Komposisi Bahan Jadi :</label>
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga Barang yang dimiliki perUnit</th>
                            <th>Stok Yang Dimiliki</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detailBarang as $index => $single): ?>
                            <tr>
                                <td><?php echo $single['nama_barang']; ?></td>
                                <td><?php echo number_format($single['harga_sekarang']); ?></td>
                                <td><?php echo number_format($single['stok']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if ($deskripsi['aktif'] == 2): ?>
            <?php if (!empty($deskripsi['time'])): ?>
                <div class="form-group clearfix">
                    <div class="col-md-9 col-md-offset-3 text-right">
                        <h4>Anda Sudah Mengikuti Lelang silahkan dicek di Home anda <a class="btn btn-info" href="<?php echo base_url() . "lelang" ?>">Kembali</a></h4>
                    </div>
                </div>    
                &nbsp;
            <?php else: ?>
                <?php echo form_open("lelang/detail/" . $this->encrypt->encode($deskripsi['id']), array("class" => "form-horizontal")); ?>
                <div class="form-group">
                    <label class="col-md-4 text-right">Jumlah Unit yang Ditawarkan :</label>
                    <label class="col-xs-1"></label>
                    <div class="col-md-4">
                        <?php echo form_input(array("name" => "jumlah", "id" => "item_$index", "class" => "form-control numberonly nominal text-right", "maxlength" => "5", "value" => set_value("jumlah", "0"))) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 text-right">Harga per Unit yang Ditawarkan :</label>
                    <label class="col-xs-1 text-right">Rp.</label>
                    <div class="col-md-4">
                        <?php echo form_input(array("name" => "harga", "id" => "item_$index", "class" => "form-control numberonly nominal text-right", "maxlength" => "10", "value" => set_value("harga", "0"))) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 col-md-offset-5 text-right">
                        <?php echo form_input(array("name" => "submit", "type" => "submit", "class" => "btn btn-primary", "value" => "Ikut Lelang")); ?>
                        <?php echo form_input(array("name" => "reset", "type" => "Reset", "class" => "btn btn-default", "value" => "Reset")); ?>
                    </div>
                </div>                
                <?php echo form_close(); ?>
            <?php endif; ?>
        <?php else: ?>
            <div class="form-group clearfix">
                <div class="col-md-4 col-md-offset-8 text-right">
                    <a class="btn btn-info btn-lg" href="<?php echo base_url() . "lelang" ?>">Kembali</a>
                </div>
            </div>    
            &nbsp;
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="col-md-12" style="min-height: 50%;">
        <div class="well">
            <h2>Lelang Tidak ditemukan atau Sesi Lelang Masih ditutup!!!!</h2>
            <h3>Klik <span><a class="btn btn-info btn-lg" href="<?php echo base_url() . "lelang" ?>">Kembali</a></span> untuk melanjutkan pencarian anda</h3>
        </div>
    </div>
<?php endif; ?>

<script src="<?php echo base_url(); ?>bootstrap/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/angka.js"></script>
