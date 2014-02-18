<div class="col-md-12">
    <div class="row-justified ">
        <!-- Tab panes -->
        <div class="col-md-12">
            <?php if (!empty($notif)): ?>
                <div class="alert alert-<?php echo $notif["jenis"]; ?>"><?php echo $notif["pesan"] ?></div>
            <?php endif; ?>
            <div class="page-header">
                <h2>
                    <div class="col-md-5">Stok Anda</div>
                    &nbsp;
                    <div class="col-md-6 text-right">
                        <a role="button" class="btn btn-primary btn-lg btnbuysell" href="<?php echo site_url(); ?>stok/buy">Buy</a>
                        <a role="button" class="btn btn-info btn-lg btnbuysell" href="<?php echo site_url(); ?>stok/sell">Sell</a>
                    </div>
                </h2>
            </div>
            <div>
                <table class="table table-hover table-striped table-bordered">
                    <thead>                        
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Penawaran Pengadaan</th>
                            <th>Harga Rata-rata Barang Anda</th>
                            <th>Harga Jual NPC</th>
                        </tr>   
                    </thead>
                    <tbody>
                        <?php foreach ($daftarStok as $index => $stok): ?>
                            <?php $nama = explode(' ', $stok['nama_barang']) ?>
                            <tr>
                                <td><?php echo $stok['id']; ?></td>
                                <td><?php echo $stok['nama_barang']; ?></td>
                                <td class="text-right"><?php echo ($stok['stok_user']) ? number_format($stok['stok_user']) : "0"; ?></td>
                                <td class="text-right"><?php echo ($stok['lock_user']) ? number_format($stok['lock_user']) : "0"; ?></td>
                                <td class="text-right"><?php echo ($stok['harga_user']) ? number_format($stok['harga_user']) : "0"; ?></td>
                                <td class="text-right" id="harga_<?php echo $nama[0]; ?>"><?php echo ($stok['harga_sekarang']) ? number_format($stok['harga_sekarang'] + 1000) : "0"; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div style="display: none">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />

    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators bg-carousel">                        
            <?php for ($i = 0; $i < 9; $i++): ?>
                <li id="point-<?php echo $i; ?>" data-toggle="tooltip" data-placement="bottom" title="" data-target="#carousel-example-generic" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i == 0) ? "active" : ""; ?>"></li>
            <?php endfor; ?>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <?php for ($i = 0; $i < 9; $i++): ?>
                <div class="item <?php echo ($i == 0) ? "active" : ""; ?>">
                    <div class="test">  
                        <h3 id="titlegraph-<?php echo $i; ?>" class="text-center black"></h3>

                        <div id="graph-<?php echo $i; ?>" class="graph">
                        </div>
                    </div>                                
                </div>
            <?php endfor; ?>
        </div>
    </div>                   
</div>
<!--SCRIPT UNTUK FLUKTUASI-->
<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/morris.css"/>
<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/david.css"/>
<script>var DATA;</script>
<script src="<?php echo base_url(); ?>bootstrap/js/raphael.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/morris.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/fluktuasi_bt.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/v_fluktuasi.js"></script>
<script>update_graph();</script>