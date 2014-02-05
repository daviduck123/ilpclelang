<div class="col-md-12">
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>panitia/lelang">Lelang</a></li>                            
        <li><a href="<?php echo base_url(); ?>panitia/lelang/lihat/<?php echo $this->encrypt->encode($id); ?>">Detail</a></li>                            
        <li class="active">Peserta</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (empty($peserta)): ?>
                <h3>Lelang tidak ditemukan</h3>
            <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Peserta Lelang</strong></div>
                    <div class="panel-body">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Tim</th>
                                    <th>Jumlah Penawaran</th>
                                    <th>Status</th>
                                    <th>Harga</th>
                                    <th>Time</th>
                                    <th>Jumlah Diterima</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($peserta as $index => $single): ?>
                                    <tr>
                                        <td><?php echo $single['nama']; ?></td>
                                        <td><?php echo number_format($single['jumlah']); ?></td>
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
                                        <td>
                                            <?php
                                            $tgl = new DateTime($single['time']);
                                            echo $tgl->format("H:i:s");
                                            ?>
                                        </td>
                                        <td><?php echo number_format($single['jumlah_terima']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-8 text-right">
                    <a href="<?php echo base_url(); ?>panitia/lelang/lihat/<?php echo $this->encrypt->encode($id); ?>" class="btn btn-lg btn-info btnX"><span class="glyphicon glyphicon-tasks"></span> Kembali</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
