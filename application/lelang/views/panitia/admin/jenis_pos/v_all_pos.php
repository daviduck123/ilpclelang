<div class="col-md-12">
    <ol class="breadcrumb">                      
        <li class="active">Jenis</li>                            
    </ol>    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (empty($jenis)): ?>
                <h3>Tidak ada Jenis Pos saat ini</h3>
            <?php else: ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Data Pos</strong></div>
                    <div class="panel-body">

                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Sertifikasi Menang</th>
                                    <th>Sertifikasi Kalah</th>
                                    <th>Uang Menang</th>
                                    <th>Uang Kalah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jenis as $index => $single): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $single['nama_jenis']; ?></td>
                                        <td class="text-right"><?php echo number_format($single['sertifikat_menang']); ?></td>
                                        <td class="text-right"><?php echo number_format($single['sertifikat_kalah']); ?></td>
                                        <td class="text-right"><?php echo number_format($single['uang_menang']); ?></td>
                                        <td class="text-right"><?php echo number_format($single['uang_kalah']); ?></td>
                                        <td><a class="btn btn-primary btnX" href="<?php echo site_url(); ?>panitia/jenis_pos/edit/<?php echo $this->encrypt->encode($single['id']) ?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-md-2 col-md-offset-10">
                <a href="<?php echo site_url(); ?>panitia/jenis_pos/tambah" class="btn btn-success btn-lg btnX"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
            </div>
        </div>
    </div>
</div>