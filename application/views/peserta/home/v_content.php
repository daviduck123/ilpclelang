<div class="panel panel-default">
    <div class="panel-body">
        <h4>Home</h4>
        <!-- ini buat Grafik-->
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseGrafik"><u>Grafik</u></a>
                    </h4>
                </div>
                <div id="collapseGrafik" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
                        <div id="graph">
                        </div>
                    </div>
                </div>
            </div>
            <!-- ini buat News-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseNews"><u>News</u></a>
                    </h4>
                </div>
                <div id="collapseNews" class="panel-collapse collapse">
                    <div class="panel-body"> 
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
            </div>
            <?php foreach ($lelang as $indexLuar => $singleLuar): ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $singleLuar['id']; ?>"><u>Season <?php echo $singleLuar['id']; ?></u></a>
                        </h4>
                    </div>
                    <div id="collapse<?php echo $singleLuar['id']; ?>" class="panel-collapse collapse">
                        <div class="panel-body">
                            <?php if (empty($singleLuar['lelang'])): ?>
                                <h4>Tidak ada Lelang yang anda ikuti di Season <?php echo $singleLuar['id']; ?></h4>
                            <?php else: ?>
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Harga</th>
                                            <th>Barang</th>
                                            <th>Penerimaan</th>
                                            <th>Sisa</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($singleLuar['lelang'] as $index => $single): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td><?php echo $single['judul_lelang']; ?></td>
                                                <td class="text-center">
                                                    <?php if ($single['status'] == '1'): ?>
                                                        <span class="glyphicon glyphicon-ok-sign green"></span>
                                                    <?php elseif ($single['status'] == '2'): ?>
                                                        <span class="glyphicon glyphicon-minus-sign red"></span>
                                                    <?php elseif ($single['status'] == '3'): ?>
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo number_format($single['harga']); ?></td>
                                                <td><?php echo number_format($single['jumlah']); ?></td>
                                                <td><?php echo number_format($single['jumlah_terima']); ?></td>
                                                <td><?php echo number_format($single['jumlah'] - $single['jumlah_terima']); ?></td>
                                                <td><a href="<?php echo base_url() . "home/lelang/" . $this->encrypt->encode($single['id']); ?>" class="btn btn-info"><span class="glyphicon glyphicon-list"></span> Lihat</a></td>
                                            </tr>
                                        <?php endforeach; ?>                                        
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!--SCRIPT UNTUK FLUKTUASI-->
<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/morris.css"/>
<link rel="stylesheet" media="screen" href="<?php echo base_url(); ?>bootstrap/css/david.css"/>
<script>var DATA;</script>
<script src="<?php echo base_url(); ?>bootstrap/js/raphael.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/morris.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/fluktuasi_bt.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/v_fluktuasi.js"></script>
<script>update_graph();</script>