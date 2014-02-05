<div class="col-md-12">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>panitia/lelang">Lelang</a></li>                            
        <li class="active">Detail</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (empty($lelang)): ?>
                <h3>Lelang tidak ditemukan</h3>
            <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Detail Lelang</strong></div>
                    <div class="panel-body">
                        <dl class="dl-horizontal">
                            <dt>Nama Customer :</dt>
                            <dd><?php echo $lelang['nama_customer']; ?></dd>
                            <dt>No Lelang :</dt>
                            <dd><?php echo $lelang['no_lelang']; ?></dd>
                            <dt>Judul Lelang :</dt>
                            <dd><?php echo $lelang['judul_lelang']; ?></dd>
                            <dt>Deskripsi :</dt>
                            <dd><?php echo $lelang['deskripsi']; ?></dd>
                            <dt>Budget :</dt>
                            <dd><?php echo number_format($lelang['budget']); ?></dd>
                            <dt>Jumlah :</dt>
                            <dd><?php echo $lelang['jumlah']; ?></dd>
                            <dt>Nama Barang :</dt>
                            <dd><?php echo $lelang['nama_barang']; ?></dd>
                            <dt>Season :</dt>
                            <dd><?php echo $lelang['season_id']; ?></dd>
                        </dl>
                        <div>
                            <h5><strong>Komposisi Bahan Baku :</strong></h5>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($detailLelang as $index => $single): ?>
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
                <?php if ($lelang['status_lelang'] != '0'): ?>
                    <div class="col-md-4 col-md-offset-8 text-right">
                        <a href="<?php echo base_url(); ?>panitia/lelang/peserta/<?php echo $this->encrypt->encode($lelang['id']); ?>" class="btn btn-lg btn-info btnX"><span class="glyphicon glyphicon-tasks"></span> Lihat Peserta</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>