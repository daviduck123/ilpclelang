<div class="col-md-12">
    <ol class="breadcrumb">                      
        <li class="active">Rekap</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (empty($pemenang_rally)): ?>
                <h3>Tidak ada Pemenang saat ini</h3>
            <?php else: ?>
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading"><a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><strong>Daftar Jumlah Sertifikat Semua Peserta</strong></a></div>
                        <div id="collapse1" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Tim</th>
                                            <th>Jumlah Sertifikat</th>
                                            <th>Jumlah Pos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pemenang_rally as $index => $single): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td><?php echo $single['nama']; ?></td>
                                                <td><?php echo $single['jumlahSertifikat']; ?></td>
                                                <td><?php echo $single['jumlahpos']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <br>
            <?php if (empty($pemenang_lelang)): ?>
                <h3>Tidak ada Pemenang Lelang saat ini</h3>
            <?php else: ?>
                <div class="panel-group" id="accordion2">
                    <div class="panel panel-default">
                        <div class="panel-heading"><a data-toggle="collapse" data-parent="#accordion2" href="#collapse2"><strong>Daftar Jumlah Uang Semua Peserta</strong></a></div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Tim</th>
                                            <th>Jumlah Hasil Lelang</th>
                                            <th>Jumlah Uang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pemenang_lelang as $index => $single): ?>
                                            <tr>
                                                <td><?php echo $index + 1; ?></td>
                                                <td><?php echo $single['nama']; ?></td>
                                                <td><?php echo number_format($single['jumlahlelang']); ?></td>
                                                <td><?php echo number_format($single['jumlahuang']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>