
<div class="container">
    <div class="col-md-12" style="min-height: 50%;">
        <div class="col-md-3" style="border-right: background solid 1px;">
            <h3 class="text-center">Price List</h3>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga Jual</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Kayu</td>
                        <td id="harga_kayu" class="text-right">0</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Besi</td>
                        <td id="harga_besi" class="text-right">0</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Batu Bata</td>
                        <td id="harga_batu" class="text-right">0</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Semen</td>
                        <td id="harga_semen" class="text-right">0</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Tanah</td>
                        <td id="harga_tanah" class="text-right">0</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Plastik</td>
                        <td id="harga_plastik" class="text-right">0</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Kaca</td>
                        <td id="harga_kaca" class="text-right">0</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Air</td>
                        <td id="harga_air" class="text-right">0</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Karet</td>
                        <td id="harga_karet" class="text-right">0</td>
                    </tr>
                </tbody>
            </table> 
        </div>
        <div class="col-md-6" style="border-right: background solid 1px;">
            <div style="height: 450px;">
                <h3 class="text-center">Grafik Fluktuasi</h3>
                <div id="graph">
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <h3 class="text-center">Login</h3>
            <?php echo form_open("login"); ?>
            <?php echo form_input(array('name' => 'username', 'class' => 'form-control', 'placeholder' => 'Username', 'required' => '', 'autofocus' => '')); ?>
            <?php echo form_password(array('name' => 'password', 'class' => 'form-control', 'placeholder' => 'Password', 'required' => '')); ?><br>
            <?php echo form_submit(array('name' => 'masuk', 'class' => 'btn btn-lg btn-primary btn-block', 'value' => 'Sign In')); ?>
            <?php echo form_close(); ?>
            <?php echo (isset($error)) ? "<div class='alert alert-danger'><strong>$error</strong></div>" : ''; ?>
        </div>
    </div> 
    <hr>
    <div class="col-md-12 row-justified">
        <h3>News</h3>
        <hr>
        <?php if (empty($news)): ?>
            <h4>Tidak Ada News Saat Ini</h4>
        <?php else: ?>
            <div class="news">
                <dl class="dl-horizontal">
                    <?php foreach ($news as $index => $single): ?>
                        <dt><?php echo date_format(date_create($single['time']), 'H:i:s'); ?></dt>
                        <dd><?php echo $single['berita']; ?></dd>
                    <?php endforeach; ?>
                </dl>
            </div>
        <?php endif; ?>
    </div>
</div>
<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/morris.css"/>
<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/david.css"/>
<script>var DATA;</script>
<script src="<?php echo base_url(); ?>bootstrap/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/raphael.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/morris.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/fluktuasi_bt.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/v_fluktuasi.js"></script>
<script>update_graph();</script>
<div>
    <div>
        <div>