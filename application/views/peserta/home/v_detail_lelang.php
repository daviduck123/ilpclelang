<?php if (!empty($deskripsi)): ?>
    <!-- ini buat News-->
    <div class="panel panel-default">
        <div class="panel-heading"><u><?php echo $deskripsi['judul_lelang'] . " - " . $deskripsi['nama_customer']; ?></u></div>
        <div class="panel-body">
            <div class="form-group">
                <dl class="dl-horizontal">
                    <dt>Deskripsi :</dt>
                    <dd><?php echo $deskripsi['deskripsi']; ?></dd>
                    <dt>Nama Barang :</dt>
                    <dd><?php echo $deskripsi['nama_customer']; ?></dd>
                    <dt>Modal untuk per Unit :</dt>
                    <dd><?php echo number_format($deskripsi['budget']); ?></dd>
                    <dt>Jumlah Kebutuhan :</dt>
                    <dd><?php echo $deskripsi['jumlah_kebutuhan']; ?></dd>
                    <dt>Harga penawaran :</dt>
                    <dd><?php echo number_format($deskripsi['harga']); ?></dd>
                    <dt>Jumlah barang  :</dt>
                    <dd><?php echo number_format($deskripsi['jumlah']); ?></dd>
                    <dt>Jumlah terima  :</dt>
                    <dd><?php echo ($deskripsi['status'] == 3) ? "-" : number_format($deskripsi['jumlah_terima']); ?></dd>
                    <dt>Status :</dt>
                    <dd>
                        <?php if ($deskripsi['status'] == 1): ?>
                            <span class="green"><span class="glyphicon glyphicon-ok-sign green"></span> Penawaran Diterima</span>
                        <?php elseif ($deskripsi['status'] == 2): ?>
                            <span class="red"><span class="glyphicon glyphicon-minus-sign red"></span> Penawaran Ditolak</span>
                        <?php elseif ($deskripsi['status'] == 3): ?>
                            <span><span class="glyphicon glyphicon-time"></span> Penawaran Dipertimbangkan</span>
                        <?php endif; ?>
                    </dd>
                </dl>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Komposisi Bahan Jadi :</label>
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($barang as $index => $single): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo $single['nama_barang']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-group clearfix">
            <div class="col-md-4 col-md-offset-8 text-right">
                <a class="btn btn-info btn-lg" href="<?php echo base_url() . "home" ?>">Kembali</a>
            </div>
        </div>    
        &nbsp;
    </div>
<?php else: ?>
    <div class="col-md-12" style="min-height: 50%;">
        <div class="well">
            <h2>Detail lelang tidak ditemukan!!!!</h2>
            <h3>Klik <span><a class="btn btn-info btn-lg" href="<?php echo base_url() . "home" ?>">Kembali</a></span> untuk melanjutkan pencarian anda</h3>
        </div>
    </div>
<?php endif; ?>

<script src="<?php echo base_url(); ?>bootstrap/js/numeral.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/angka.js"></script>
